<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Company;
use App\Models\Platoon;
use App\Models\Squad;
use App\Models\Soldier;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        $companies = Company::get();
        $platoons = Platoon::get();
        $squads = Squad::get();
        $soldiers = Soldier::get();
        $votes = Vote::get();


        $tallys = [];
        $percentages = [];
        $squad_highest_numbers = [];
        $high = 0;

        foreach ($soldiers as $soldier) {
            $amount = 0;
            foreach ($votes as $vote) {
                if ($soldier->id == $vote->voted_soldier_id) {
                    $amount++;
                }
            }
            array_push($tallys, ['soldier_id' => $soldier->id, 'game_name' => $soldier->game_name,'squad_id' => $soldier->squad_id, 'amount' => $amount]);
        }

        foreach ($squads as $key => $squad) {
            foreach ($tallys as $tally) {
                $next = $tally['amount'];

                if ($squad->id == $tally['squad_id'] && $next > $high) {
                    $high = $next;
                    $squad_highest_numbers[$key] = ['soldier_id' => $tally['soldier_id'], 'game_name' => $tally['game_name'], 'squad_id' => $squad->id, 'high' => $high];
                    $top_soldier = Squad::where('id', '=', $squad->id)->first();
                    $top_soldier->soldier_id = $tally['soldier_id'];
                    $top_soldier->save();
                }
            }
            $next = 0;
            $high = 0;
        }

        foreach ($squads as $squad) 
        {
            foreach ($tallys as $tally) 
            {
                foreach ($squad_highest_numbers as $squad_highest_number) 
                {
                    if ($squad->id == $tally['squad_id'] && $squad->id == $squad_highest_number['squad_id'] && $squad_highest_number['high'] != 0) 
                    {
                        $percentage = ($tally['amount'] / $squad_highest_number['high']) * 100;
                        array_push($percentages, ['squad_id' => $squad->id, 'soldier_id' => $tally['soldier_id'], 'percentage' => $percentage]);
                    }
                }
            }
        }



        usort($percentages, function ($a, $b) {
            return $a['soldier_id'] <=> $b['soldier_id'];
        });

        $data = collect(['companies' => $companies, 'platoons' => $platoons, 'squads' => $squads, 'soldiers' => $soldiers, 'percentages' => $percentages, 'squad_highests' => $squad_highest_numbers]); 

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
        $voting_soldier_id = $request->voting_soldier_id;
        $voted_soldier_id = $request->voted_soldier_id;

        $voting_soldier = Soldier::where('user_id', '=', \Auth::user()->id)->first();
        $voted_soldier = Soldier::where('id', '=', $voted_soldier_id)->first();

        if ($voting_soldier == null) {
            return redirect()->route('vote.index')->with('status', 'Vote failed! You must join the squad first.');
        }

        if ($voting_soldier->squad_id == $voted_soldier->squad_id) {
            if (!is_null($voting_soldier)) {
                $vote = Vote::where('category', '=', $category)
                            ->where('voting_soldier_id', '=', $voting_soldier_id)
                            ->first();
    
                if (is_null($vote)) {
                    $voted = Vote::create([
                        'category' => $category,
                        'voting_soldier_id' => $voting_soldier_id,
                        'voted_soldier_id' => $voted_soldier_id,
                    ]);
                } else {
                    $vote->category = $category;
                    $vote->voting_soldier_id = $voting_soldier_id;
                    $vote->voted_soldier_id = $voted_soldier_id;
                    $vote->save();
                }
                return redirect()->route('vote.index')->with('status', 'Vote successful!');
            } else {
                return redirect()->route('vote.index')->with('status', 'Vote failed! Try joining a squad first.');
            }
        } else {
            return redirect()->route('vote.index')->with('status', 'Vote failed! You can only vote for a soldier in your squad.');
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
