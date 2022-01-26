<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Platoon;
use App\Models\Company;

use Livewire\Component;

class Listgroup extends Component
{
    public $orders;
    public $platoons;
    public $ordered_orders = [];

    public function mount()
    {
        $this->orders = Order::orderBy('created_at', 'desc')->get();
        $this->platoons = Platoon::all();
        $this->companies = Company::all();

        foreach ($this->orders as $order) {
            foreach ($this->companies as $company) {
                foreach ($this->platoons as $platoon) {
                    $time_since = Order::time_elapsed_string($order->created_at);
                    if ($platoon->company_id == $company->id && $platoon->id == $order->platoon_id) {
                        array_push($this->ordered_orders, ['company' => $company->name, 'platoon' => $platoon->name, 'head' => $order->head, 'body' => $order->body, 'date' => $time_since]);
                    }
                } 
            }
        }
    }

    public function hydrate()
    {

    }

    public function render()
    {
        return view('livewire.listgroup');
    }
}
