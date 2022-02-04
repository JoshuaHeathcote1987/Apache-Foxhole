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
        $category = self::CATEGORY[$request->category];
    
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
                            // Somewhere around here you will have to turn it into a method so that you can run it in other locations of the document. An example of this is in the Join, where specific criteria will have to be updated to corrisponde certain events.

                            // Tally the Votes
                            $votes = Vote::where('category', '=', 'squad')->get();
                            $soldiers = Soldier::where('squad_id', '=', $voted_soldier->squad->id)->get();
                            
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
                                $percentages->push(['soldier_id' => $tally['soldier']['id'], 'category' => $category, 'percent' => $percentage, 'count' => $tally['count']]);
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

                            return redirect()->route('vote.index')->with('status', 'Vote successful!');
                        }     
                        return redirect()->route('vote.index')->with('status', 'Vote failed! Failed to update');
                    }
                    return redirect()->route('vote.index')->with('status', 'Vote failed! Incorrect squad.');
                    
                break;

            case 'platoon':

                break;

            case 'company':

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