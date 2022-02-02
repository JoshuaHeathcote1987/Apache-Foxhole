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

        $companies = Company::all();
        $platoons = Platoon::all();
        $squads = Squad::all();
        $soldiers = Soldier::all();
        $votes = Vote::all();

        $tallied_squads = collect();
        $tallied_platoons = collect();
        $tallied_companys = collect();

        $count = 0;

        // Counts each votes and tallies it
        foreach ($soldiers as $key => $soldier) {
            $count = $votes->where('category', '=', 'squad')
                ->where('voted_soldier_id', '=', $soldier->id)
                ->count();
            $tallied_squads->push(['squad_id' => $soldier->squad_id, 'soldier_id' => $soldier->id, 'vote_count' => $count]);
            $count = $votes->where('category', '=', 'platoon')
                ->where('voted_soldier_id', '=', $soldier->id)
                ->count();
            $tallied_platoons->push(['platoon_id' => $soldier->squad->platoon->id, 'soldier_id' => $soldier->id, 'vote_count' => $count]);
        }

    

        $max_squads = collect();
        $max_platoons = collect();
        $max_companys = collect();

        // Max number for the percentage calculation
        foreach ($squads as $key => $squad) {
            $max = $tallied_squads->where('squad_id', '=', $squad->id)
                ->max('vote_count');
            $max_squads->push(['squad_id' => $squad->id, 'max' => $max]);   
        }

        foreach ($platoons as $platoon) {
            $max = $tallied_platoons->where('platoon_id', '=', $platoon->id)->max('vote_count');
            $max_platoons->push(['platoon_id' => $platoon->id, 'max' => $max]);
        }

        $percentage_squads = collect();
        $percentage_platoons = collect();
        $percentage_companys = collect();
      
        // Percentage
        foreach ($max_squads as $key => $max_squad) {
            foreach ($tallied_squads as $key => $tallied_squad) {
                if ($max_squad['max'] != null) {
                    if ($max_squad['squad_id'] == $tallied_squad['squad_id']) {
                        $percentage = ($tallied_squad['vote_count'] / $max_squad['max']) * 100;
                        $percentage_squads->push(['squad_id' => $max_squad['squad_id'], 'soldier_id' => $tallied_squad['soldier_id'], 'percentage' => $percentage]);
                    } 
                } 
            }
        }

        foreach ($max_platoons as $key => $max_platoon) {
            foreach ($tallied_platoons as $key => $tallied_platoon) {
                if ($max_platoon['max'] != null) {
                    if ($max_platoon['platoon_id'] == $tallied_platoon['platoon_id']) {
                        $percentage = ($tallied_platoon['vote_count'] / $max_platoon['max']) * 100;
                        $percentage_platoons->push(['platoon_id' => $max_platoon['platoon_id'], 'soldier_id' => $tallied_platoon['soldier_id'], 'percentage' => $percentage]);
                    } 
                } 
            }
        }


        // Stores the highest percentage in squad database. This needs to be reference since I don't think it's the best place for this kind of action to be taking place, it should take place when the user clicks the vote button, but that is something to think about later.
        foreach ($squads as $key => $squad) {
            foreach ($percentage_squads as $key => $percentage_squad) {
                if ($squad->id == $percentage_squad['squad_id']) {
                    if ($percentage_squad['percentage'] == 100) {
                        $update = Squad::find($squad->id);
                        $update->soldier_id = $percentage_squad['soldier_id'];
                        $update->save();
                    }
                }
            }
        }

        foreach ($platoons as $key => $platoon) {
            foreach ($percentage_platoons as $key => $percentage_platoon) {
                if ($platoon->id == $percentage_platoon['platoon_id']) {
                    if ($percentage_platoon['percentage'] == 100) {
                        $update = Platoon::find($platoon->id);
                        $update->soldier_id = $percentage_platoon['soldier_id'];
                        $update->save();
                    }
                }
            }
        }
        
        $data = ['companies' => $companies, 'platoons' => $platoons, 'squads' => $squads, 'soldiers' => $soldiers, 'votes' => $votes, 'percentage_squads' => $percentage_squads, 'percentage_platoons' => $percentage_platoons];

        


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

        switch ($category) {
            case 'squad':
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
                break;

            case 'platoon':
                $current_soldier = Soldier::find(Auth::id());
                $voted_soldier = Soldier::find($request->voted_soldier_id);

                // This is not updating correctly, you need to reconsider this, the update is not creating a new one but changing the squad vote
                if ($current_soldier->squad->platoon_id == $voted_soldier->squad->platoon_id) {
                    $createOrUpdate = Vote::updateOrCreate(
                        ['category' => $category, 'user_id' => Auth::id(), 'soldier_id' => $current_soldier->id],
                        ['voted_soldier_id' => $voted_soldier->id]
                    );
                    return redirect()->route('vote.index')->with('status', 'Vote successful!');
                }
                return redirect()->route('vote.index')->with('status', 'Vote failed! You need to be in the same platoon.');
                break;

            case 'company':
                dd('platoon');
                break;
            default:
                # code...
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