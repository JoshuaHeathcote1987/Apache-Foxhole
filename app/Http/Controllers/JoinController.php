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
        $soldier = Soldier::updateOrCreate(
            [
                'user_id' => Auth::id(),
            ],
            [
                'squad_id'  => $request->squad_id,
                'user_id'   => Auth::id(),
                'game_name' => Auth::user()->game_name,
            ]
        );
     
        $vote = Vote::updateOrCreate(
            ['category' => 'squad', 'voting_soldier_id' => $soldier->id],
            ['user_id' => Auth::id(), 'voted_soldier_id' => $soldier->id],
        );

        return redirect('join');
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
