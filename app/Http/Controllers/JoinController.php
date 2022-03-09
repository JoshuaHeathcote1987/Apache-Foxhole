<?php

namespace App\Http\Controllers;

use App\Models\Join;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\Platoon;
use App\Models\Squad;
use App\Models\Soldier;
use App\Models\User;
use App\Models\Vote;
use App\Models\Percentage;

class JoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();
        $platoons = Platoon::get();
        $squads = Squad::get();
        $soldiers = Soldier::get();

        $data = collect(['companies' => $companies, 'platoons' => $platoons, 'squads' => $squads, 'soldiers' => $soldiers]);

        return view('pages.join')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(\Auth::id());
                      
        // CREATE A NEW SOLDIER IF ONE DOES NOT EXIST
        try 
        {
            $squad = Squad::find($user->soldier->squad_id);                                     // previous squad   
        } 
        catch (\Throwable $th) 
        {
            $soldier = Soldier::updateOrCreate(                                                 // This soldier is created with reference to the new squad
                [
                    'game_name' => $user->game_name,
                ],
                [
                    'squad_id'  => $request->squad_id,
                    'game_name' => $user->game_name,
                ]
            );

            $user->soldier_id = $soldier->id;                                                   // The user is linked to the newly created soldier here
            $user->save();
        }

        // Change the soldiers squad to the new one
        $soldier = Soldier::updateOrCreate(
            [
                'game_name' => $user->game_name,
            ],
            [
                'squad_id'  => $request->squad_id,
                'game_name' => $user->game_name,
            ]
        );

        // Updating the old squad table for new squad leader, tally, max percentages
        try {
            // 0 Check to see if the leader is set or is the same
            if ($user->soldier->id == $user->soldier->squad->leader_id)                
            {
                // 1 Get the old Squad, and set leader to null
                $squad->leader_id = null;
                $squad->save();

                // 2 Grab the soldiers in the squad
                $soldiers = $squad->soldiers;
                
                

                if (count($soldiers) > 0) {
                    // 3 Fill the Tally collect
                    $tallied = collect();
                        
                    foreach ($soldiers as $soldier) {
                        $count = $soldier->votes->count();
                        $tallied->push(['soldier' => $soldier, 'count' => $count]);
                    }

                    // 4 Grab the max Tally
                    $max = $tallied->max('count');

                    // 6 Update the previous squad table with the new squad leader 
                    $leader = $tallied->where('count', '=', $max);
                    $leader = $leader->values();
                    $squad_leader = Soldier::find($leader[0]['soldier']['id']);
                    $squad->leader_id = $squad_leader->id;
                    $squad->save();

                    // 7 Calculate the percentages
                    $percentages = collect();

                    foreach ($tallied as $tally) {
                        if ($tally['count'] != 0) {
                            $percentage = ($tally['count'] / $max) * 100;
                            $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => 'squad', 'percent' => $percentage, 'count' => $tally['count']]);
                        } else {
                            $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => 'squad', 'percent' => 0, 'count' => 0]); 
                        }
                    }
                    
                    // 8 Update the percentage table
                    foreach ($percentages as $percentage) {
                        $update = Percentage::updateOrCreate(
                            [
                                'soldier_id' => $percentage['soldier_id'],
                                'category' => 'squad',
                            ],
                            [
                                'percentage' => $percentage['percent'],
                                'count' => $percentage['count'],
                            ]
                        );
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        // Update new squad table data
        $soldier = Soldier::updateOrCreate(
            [
                'game_name' => $user->game_name,
            ],
            [
                'squad_id'  => $request->squad_id,
                'game_name' => $user->game_name,
            ]
        );

        $user->soldier_id = $soldier->id;
        $user->save();

        $update = Vote::updateOrCreate(
            ['category' => 'squad', 'voting_soldier_id' => $user->soldier_id],
            ['voted_soldier_id' => $user->soldier_id],
        );

        if ($update) {

            // Tally the Votes
            $soldiers = Soldier::where('squad_id', '=', $soldier->squad_id)->get();
            
            $tallied = collect();
            
            foreach ($soldiers as $soldier) {
                $count = $soldier->votes->count();
                $tallied->push(['soldier' => $soldier, 'count' => $count]);
            }

            // Max the Votes
            $max = $tallied->max('count');

            // Now you need to update the squad table with the soldier id to show that he is leader
            $leader = $tallied->where('count', '=', $max);
            $leader = $leader->values();
            $squad_leader = Soldier::find($leader[0]['soldier']['id']);
            $update_squad = Squad::find($squad_leader->squad_id);
            $update_squad->leader_id = $squad_leader->id;
            $update_squad->save();

            // Check to see if the user is still a squad leader, if not delete the percentage
            if (isset($percentage_delete)) {
                $percentage_delete = Percentage::where('soldier_id', '=', $user->soldier->id)
                    ->where('category', '=', 'platoon');
                $percentage_delete->delete();
            }

            if (isset($squad_delete)) {
                $squad_delete = Percentage::where('soldier_id', '=', $user->soldier->id)
                    ->where('category', '=', 'squad');
                $squad_delete->delete();
            }

            $percentages = collect();

            // Find the Percentage and store
            foreach ($tallied as $tally) {
                $percentage = ($tally['count'] / $max) * 100;
                $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => 'squad', 'percent' => $percentage, 'count' => $tally['count']]);
            }

            foreach ($percentages as $percentage) {
                $update = Percentage::updateOrCreate(
                    [
                        'soldier_id' => $percentage['soldier_id'],
                        'category' => 'squad',
                    ],
                    [
                        'percentage' => $percentage['percent'],
                        'count' => $percentage['count'],
                    ]
                );
            }
            
            return redirect()->route('join.index')->with('status', 'Welcome to '. $soldier->squad->platoon->company->name .' '. $soldier->squad->platoon->name .' '. $soldier->squad->name .' squad!');
        }     

        return redirect()->route('join.index')->with('status', 'Failed to join squad!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Join  $join
     * @return \Illuminate\Http\Response
     */
    public function show(Join $join)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Join  $join
     * @return \Illuminate\Http\Response
     */
    public function edit(Join $join)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Join  $join
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $soldier_id)
    {
        $soldier = Soldier::where('user_id', '=', Auth::id())->first();

        if ($soldier->id != $soldier_id) {
            return redirect('join')->with('status', 'Profile update failed!');
        }

        Soldier::where('id', $soldier_id)->update([
            'steam_id' => $request->steam_id,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'twitch' => $request ->twitch,
        ]);
        return back()->with('status', 'Profile updated!');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Join  $join
     * @return \Illuminate\Http\Response
     */
    public function destroy(Join $join)
    {
        //
    }
}
