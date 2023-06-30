<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    //
    function index()
    {
        $ratings = Rating::with('trainer')
            ->selectRaw('trainer_id,AVG(rating) as averageRate, count(trainer_id)as countRate')
            ->groupBy('trainer_id')
            ->get();


        return view('ratings.index')->with('ratings', $ratings);
    }


}