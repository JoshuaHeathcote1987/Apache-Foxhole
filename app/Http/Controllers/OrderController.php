<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Company;
use App\Models\Platoon;
use App\Models\Squad;
use App\Models\Soldier;

use Illuminate\Http\Request;


class OrderController extends Controller
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
        $orders = Order::orderBy('created_at', 'desc')->get();
        
        $data = collect([
            'companies' => $companies, 
            'platoons' => $platoons, 
            'squads' => $squads, 
            'soldiers' => $soldiers,
            'orders' => $orders,
        ]);

        return view('pages.orders')->with('data', $data);
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
        $user = \Auth::user();
        $platoon_id = $request->platoon_id;
        $platoon = Platoon::find($platoon_id);
        $company_leader_id = $platoon->company->leader_id;

        if ($user->soldier->id == $company_leader_id) {
            $order = Order::create([
                'platoon_id' => $request->platoon_id,
                'head' => $request->head,
                'body' => $request->body,
            ]);

            return redirect('orders')->with('status', 'Order created!');
        } else {
            return redirect('orders')->with('status', 'Order failed!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
