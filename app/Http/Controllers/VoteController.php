<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Platoon;
use App\Models\Squad;
use App\Models\Soldier;
use App\Models\User;

use App\Models\Vote;
use App\Models\Percentage;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use Auth;


class VoteController extends Controller
{
    const CATEGORY = ['company', 'platoon', 'squad'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['companies' => Company::all(), 'percentages' => Percentage::all()];
        return view('pages.vote')->with('data', $data);
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
        $category = $request->category;

        switch ($category) {
            case 'squad':
                    $voting_soldier = Soldier::find($request->voting_soldier_id);
                    $voted_soldier = Soldier::find($request->voted_soldier_id);

                    if (!isset($voting_soldier)) {
                        return redirect()->route('vote.index')->with('status', 'Vote failed! You need to join a squad.');
                    }

                    if ($voting_soldier->squad->id == $voted_soldier->squad->id) {
                        $update = Vote::updateOrCreate(
                            [
                                'category' => $category,
                                'voting_soldier_id' => $voting_soldier->id,
                            ],
                            [
                                'voted_soldier_id' => $voted_soldier->id,
                            ]
                        );
    
                        if ($update) {
                            // Somewhere around here you will have to turn it into a method so that you can run it in other locations of 
                            // the document. An example of this is in the Join, where specific criteria will have to be updated to corrisponde certain events.

                            // Tally the Votes
                            $soldiers = Soldier::where('squad_id', '=', $voted_soldier->squad->id)->get();
                            
                            $tallied = collect();
                            
                            foreach ($soldiers as $soldier) {
                                $count = $soldier->votes
                                    ->where('category', '=', $category)
                                    ->count();
                                $tallied->push(['soldier' => $soldier, 'count' => $count]);
                            }

                            // Max the Votes
                            $max = $tallied->max('count');

                            // Now you need to update the squad table with the soldier id to show that he is leader
                            $leader = $tallied->where('count', '=', $max);
                            $leader = $leader->values();
                            $squad_leader = Soldier::find($leader[0]['soldier']['id']);
                            $update_squad = Squad::find($squad_leader->squad_id);

                            // Reset Vote on Squad Lead Platoon Vote
                            // Check to see if the current max (new) squad leader is equal to the previous one, if 
                            // not then the previous vote will be deleted, if true, then the vote won't be touch
                            if ($voted_soldier->id != $squad_leader->id) 
                            {
                                // Its important to take into account that when all vote's are equal among the squad, then 
                                // the first member in the squad is crowned squad leader.
                                $remove_vote = Vote::where('category', '=', 'platoon')
                                    ->where('voted_soldier_id', '=', $voted_soldier->id);

                                $remove_vote->delete();

                                $create_vote = new Vote;
                                $create_vote->category = 'platoon';
                                $create_vote->voting_soldier_id = $voting_soldier->id;
                                $create_vote->voted_soldier_id = $voted_soldier->id;
                            }

                            $update_squad->leader_id = $squad_leader->id;
                            $update_squad->save();

                            $percentages = collect();

                            // Find the Percentage and store
                            foreach ($tallied as $tally) {
                                $percentage = ($tally['count'] / $max) * 100;
                                $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => $category, 'percent' => $percentage, 'count' => $tally['count']]);
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

                            // Reset the platoon vote
                            


                            return redirect()->route('vote.index')->with('status', 'Vote successful!');
                        }     
                        return redirect()->route('vote.index')->with('status', 'Vote failed! Failed to update');
                    }
                    return redirect()->route('vote.index')->with('status', 'Vote failed! Incorrect squad.');
                    
                break;

            case 'platoon':
                    $voting_soldier = Soldier::find($request->voting_soldier_id);
                    $voted_soldier = Soldier::find($request->voted_soldier_id);

                    // Check to see if the two soldiers are in the same platoon
                    if ($voting_soldier->squad->platoon->id == $voted_soldier->squad->platoon->id)
                    {
                        $platoon_vote = Vote::updateOrCreate(
                            [
                                'category' => $category,
                                'voting_soldier_id' => $voting_soldier->id,
                            ],
                            [
                                'voted_soldier_id' => $voted_soldier->id,
                            ]
                        );

                        $squads = Squad::where('platoon_id', '=', $voting_soldier->squad->platoon->id)->get();
   
                        $tallied = collect();
                        
                        foreach ($squads as $squad) {    
                            if (isset($squad->leader->votes)) {
                                $count = $squad->leader->votes->where('category', '=', $category)->count(); 
                                $tallied->push(['soldier' => $squad->leader, 'count' => $count]);
                            }             
                        }

                        $max = $tallied->max('count');

                        $leader = $tallied->where('count', '=', $max);
                        $leader = $leader->values();
                        $squad_leader = Soldier::find($leader[0]['soldier']['id']);
                        $update_squad = Platoon::find($squad_leader->squad->platoon->id);

                        // Reset Vote on Squad Lead Company Vote
                        // Check to see if the current max (new) squad leader is equal to the previous one, if 
                        // not then the previous vote will be deleted, if true, then the vote won't be touch
                        if ($voted_soldier->id != $squad_leader->id) 
                        {
                            // Its important to take into account that when all vote's are equal among the squad, then 
                            // the first member in the squad is crowned squad leader.
                            $remove_vote = Vote::where('category', '=', $category)
                                ->where('voted_soldier_id', '=', $voted_soldier->id);

                            $remove_vote->delete();

                            $create_vote = new Vote;
                            $create_vote->category = 'company';
                            $create_vote->voting_soldier_id = $voting_soldier->id;
                            $create_vote->voted_soldier_id = $voted_soldier->id;
                        }

                        $update_squad->leader_id = $squad_leader->id;
                        $update_squad->save();

                        $percentages = collect();

                        // Find the Percentage and store
                        foreach ($tallied as $tally) {
                            $percentage = ($tally['count'] / $max) * 100;
                            $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => $category, 'percent' => $percentage, 'count' => $tally['count']]);
                        }

                        foreach ($percentages as $percentage) {
                            $update = Percentage::updateOrCreate(
                                [
                                    'soldier_id' => $percentage['soldier_id'],
                                    'category' => $category,
                                ],
                                [
                                    'percentage' => $percentage['percent'],
                                    'count' => $percentage['count'],
                                ]
                            );
                        }
                        return redirect()->route('vote.index')->with('status', 'Vote successful!');
                    }
                    return redirect()->route('vote.index')->with('status', 'Invalid platoon!');
                break;

            case 'company':
                    
                $voting_soldier = Soldier::find($request->voting_soldier_id);
                $voted_soldier = Soldier::find($request->voted_soldier_id);

                if ($voting_soldier->squad->platoon->company->id == $voted_soldier->squad->platoon->company->id) {
                    $company_vote = Vote::updateOrCreate(
                        [
                            'category' => $category,
                            'voting_soldier_id' => $voting_soldier->id,
                        ],
                        [
                            'voted_soldier_id' => $voted_soldier->id,
                        ]
                    );

                    $platoons = Platoon::where('company_id', '=', $voting_soldier->squad->platoon->company->id)->get();

                    $tallied = collect();
                        
                    foreach ($platoons as $platoon) {    
                        if (isset($platoon->leader->votes)) {
                            $count = $platoon->leader->votes->where('category', '=', $category)->count(); 
                            $tallied->push(['soldier' => $platoon->leader, 'count' => $count]);
                        }             
                    }

                    $max = $tallied->max('count');

                    $leader = $tallied->where('count', '=', $max);
                    $leader = $leader->values();
                    $squad_leader = Soldier::find($leader[0]['soldier']['id']);
                    $update_squad = Company::find($squad_leader->squad->platoon->company->id);

                    $update_squad->leader_id = $squad_leader->id;
                    $update_squad->save();

                    $percentages = collect();

                    // Find the Percentage and store
                    foreach ($tallied as $tally) {
                        $percentage = ($tally['count'] / $max) * 100;
                        $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => $category, 'percent' => $percentage, 'count' => $tally['count']]);
                    }

                    foreach ($percentages as $percentage) {
                        $update = Percentage::updateOrCreate(
                            [
                                'soldier_id' => $percentage['soldier_id'],
                                'category' => $category,
                            ],
                            [
                                'percentage' => $percentage['percent'],
                                'count' => $percentage['count'],
                            ]
                        );
                    }
                    return redirect()->route('vote.index')->with('status', 'Vote successful!');
                }
                return redirect()->route('vote.index')->with('status', 'Invalid company!');

                break;
            
            default:
                
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}