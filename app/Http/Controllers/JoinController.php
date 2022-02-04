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

        // THIS IS THE PROBLEM :: You have a problem where if a squad leader leaves the squad, the squad leader isn't updated in the squad table

        // Check to see if the current soldier change is squad leader.
        $old_squad_leader_id = $user->soldier->squad->leader_id;
        if ($user->solider->id == $old_squad_leader_id) {
            dd('You are here');
        }
        // If he is squad leader then perform these actions

        // Delete his percentage
        // Run tally on the squad that he left
        // Run max on the squad that he left
        // Update squad table with the new current squad leader
        // Run percentage on squad that he left
        

        




        // Tally, Max, Percentage Calculation
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
            ['category' => 'squad', 'voting_soldier_id' => $user->soldier->id],
            ['voted_soldier_id' => $user->soldier->id],
        );

        if ($update) {

            // Tally the Votes
            $votes = Vote::where('category', '=', 'squad')->get();
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
                        'category' => 3,
                    ],
                    [
                        'percentage' => $percentage['percent'],
                        'count' => $percentage['count'],
                    ]
                );
            }


            // READ THIS In the vote and the join section, you have to make it so that all percentage have another vote created for platoon, then the leader of that will be shown in the company

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
