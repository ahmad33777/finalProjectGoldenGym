<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function index()
    {

        $orders = Order::where('deleted_at', null)
            ->where('status', 0)
            ->get();
        return view('orders.index', compact('orders'));
    }


    public function acceptOrder($id)
    {
        $oredr = Order::find($id);
        $oredr->status = 1;
        $status = $oredr->save();
        session()->flash('status', $status);
        return redirect()->back();

    }
    
    public function rejectOrder($id)
    {
        $oredr = Order::find($id);
        $oredr->status = -1;
        $status = $oredr->save();
        session()->flash('rejectstatus', $status);
        return redirect()->back();
    }

}