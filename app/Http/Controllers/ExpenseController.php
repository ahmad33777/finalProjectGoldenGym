<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{


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
            $expenses = Expense::whereBetween('date', [$startDate, $endDate])->paginate(30);
            return view('expenses.index')->with([
                'expenses' => $expenses,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        } else {
            $expenses = Expense::paginate(30);

            return view('expenses.index')->with([
                'expenses' => $expenses,
            ]);

        }
    }
    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'type' => 'required|string',
                'amount' => 'required|numeric|min:0',
                'note' => 'nullable|string',
            ],
            [
                'type.required' => 'هذا الحقل مطلوب',
                'type.string' => 'يجب أن يكون نص',
                'amount.required' => 'هذا الحقل مطلوب',
                'amount.numeric' => ' المدخل غير مناسب ',
            ]
        );
        $newExpense = new Expense();
        $newExpense->user_id = Auth::user()->id;
        $currentDate = now()->toDateString();
        $newExpense->date = $currentDate;
        $newExpense->type = $request->post('type');
        $newExpense->amount = $request->post('amount');
        if ($request->has('note') ?? false) {
            $newExpense->note = $request->post('note');
        }
        $status = $newExpense->save();
        session()->flash('status', $status);
        return redirect()->back();




    }
}