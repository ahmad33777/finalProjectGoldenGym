<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Expense;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Incoming;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $numberSubscribers = Subscriber::count();
        $employees = User::count();
        $trainers = Trainer::count();
        $incomings = Incoming::sum('incoming_value');

        $currentDate = date('Y-m-d');

        $dailyIncoming = Incoming::where('incoming_date', $currentDate)->sum('incoming_value');
        $dailyExpenses = Expense::where('date', $currentDate)->sum('amount');
        // chart one subs
        $subscribers = Subscriber::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupby('month')
            ->orderBy('month')
            ->get();
        // dd($subscribers->toArray());
        $labels = [];
        $data = [];
        $colors = ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#ffc107', '#198754', '#fd7e14', '#adb5bd', '#cc65fe', '#ffce56'];

        for ($i = 1; $i < 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $count = 0;
            foreach ($subscribers as $subscriber) {
                if ($subscriber->month == $i) {
                    $count = $subscriber->count;
                    break;
                }
            }
            array_push($labels, $month);
            array_push($data, $count);
        }

        $datasets = [
            [
                'label' => 'المشتركين',
                'data' => $data,
                'backgroundColor' => $colors,
            ]
        ];

        $datasetIncomming = $this->incommingChart();

        // dd($datasetIncomming );
        return view('home')->with([
            'subscribers' => $numberSubscribers,
            'employees' => $employees,
            'trainers' => $trainers,
            'incomings' => $incomings,
            'dailyIncoming' => $dailyIncoming,
            'labels' => $labels,
            'datasets' => $datasets,
            'datasetIncomming' => $datasetIncomming,
            'dailyExpenses' => $dailyExpenses

        ]);

    }

    public function incommingChart()
    {

        $incommings = Incoming::selectRaw('MONTH(created_at) as month, SUM(incoming_value) as sum')
            ->whereYear('created_at', date('Y'))
            ->groupby('month')
            ->orderBy('month')
            ->get();
        $labels = [];
        $data = [];
        $colors = ['red', '#36a2eb', '#cc65fe', '#ffce56', '#ffc107', '#198754', '#fd7e14', '#adb5bd', '#cc65fe', '#ffce56'];

        for ($i = 1; $i < 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $sum = 0;
            foreach ($incommings as $incomming) {
                if ($incomming->month == $i) {
                    $sum = $incomming->sum;
                    break;
                }
            }
            array_push($labels, $month);
            array_push($data, $sum);
        }


        $datasets = [
            [
                'label' => 'الواردات',
                'data' => $data,
                'backgroundColor' => $colors,
            ]
        ];

        return $datasets;

    } // End  function






}