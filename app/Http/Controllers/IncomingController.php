<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IncomingController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->validate(
            [
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',

            ],
            [
                'endDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء تاريخًا بعد تاريخ البدء أو مساويًا له'
            ]
        );
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        if ($startDate and $endDate) {
            $incomings = Incoming::whereBetween('incoming_date', [$startDate, $endDate])->paginate(30);
            return view('incomings.index')->with([
                'incomins' => $incomings,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        } else {
            $incomings = Incoming::paginate(30);

            return view('incomings.index')->with([
                'incomins' => $incomings,
            ]);

        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required',
            'note' => 'required',
        ]);
        $newIncome = new Incoming();
        $newIncome->incoming_type = $request->type;
        $newIncome->incoming_date = date('Y-m-d');
        $newIncome->incoming_value = $request->amount;
        $newIncome->user_id = Auth::user()->id;

        return redirect()->back();







    }
}