<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Company;
use App\Models\Platoon;
use App\Models\Squad;
use App\Models\Soldier;
use App\Models\User;

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
        // You will have to rethink this because even if you fix it here you will have problems down below
        // You will have to make a DB for Squad_Leaders, Platoon_Leaders, and Company_Leaders
        // You will have to look into Eloquent to see if this can be done better using ->count() instead of the crazy mess you used

        $companies = Company::all();
        $platoons = Platoon::all();
        $squads = Squad::all();
        $soldiers = Soldier::all();
        $votes = Vote::all();

        $tallied_squad = collect();
        $tallied_platoon = collect();
        $tallied_company = collect();

        $count = 0;

        // Count the votes
        foreach ($soldiers as $key => $soldier) {
            $count = $votes->where('category', '=', 'squad')
                ->where('voted_soldier_id', '=', $soldier->id)
                ->count();
            $tallied_squad->push(['squad_id' => $soldier->squad_id, 'soldier_id' => $soldier->id, 'vote_count' => $count]);
            $count = $votes->where('category', '=', 'platoon')
                ->where('voted_soldier_id', '=', $soldier->id)
                ->count();
            $tallied_platoon->push(['squad_id' => $soldier->squad_id, 'soldier_id' => $soldier->id, 'vote_count' => $count]);
            $count = $votes->where('category', '=', 'company')
                ->where('voted_soldier_id', '=', $soldier->id)
                ->count();
            $tallied_company->push(['squad_id' => $soldier->squad_id, 'soldier_id' => $soldier->id, 'vote_count' => $count]);
        }

        $max_squad = collect();
        $max_platoon = collect();
        $max_company = collect();

        foreach ($squads as $key => $squad) {
            $max = $tallied_squad->where('squad_id', '=', $squad->id)->max('vote_count');
            $max_squad->push(['squad->id' => $squad->id, 'max' => $max]);
        }

        $percentage_squad = collect();
        $percentage_platoon = collect();
        $percentage_company = collect();
        
        // work out the percentage to each soldier
        
        
        $data = ['companies' => $companies, 'platoons' => $platoons, 'squads' => $squads, 'soldiers' => $soldiers, 'votes' => $votes];

  

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

        $voted_soldier_id = $request->voted_soldier_id;

        $voting_soldier = Soldier::where('user_id', '=', Auth::user()->id)->first();
        $voted_soldier = Soldier::where('id', '=', $voted_soldier_id)->first();

        if ($voting_soldier == null) {
            return redirect()->route('vote.index')->with('status', 'Vote failed! You must join the squad first.');
        }

        if ($voting_soldier->squad_id == $voted_soldier->squad_id) {
            if (!is_null($voting_soldier)) {
                $vote = Vote::where('category', '=', $category)
                            ->where('soldier_id', '=', $voting_soldier->id)
                            ->first();
    
                if (is_null($vote)) {
                    $voted = Vote::create([
                        'category' => $category,
                        'user_id' => Auth::user()->id,
                        'soldier_id' => $voting_soldier->id,
                        'voted_soldier_id' => $voted_soldier_id,
                    ]);
                } else {
                    $vote->category = $category;
                    $vote->soldier_id = $voting_soldier->id;
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