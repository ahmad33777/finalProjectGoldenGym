<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Trainer;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //

    public function ratings(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'trainer_id' => 'required|numeric',
            ],
        );
           
        if (!$validator->fails()) {
            // $trainer = Trainer::where('id', $request['trainer_id'])->first();
            $ratings = Rating::where('trainer_id', $request['trainer_id'])->get();
            if ($ratings) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'كل التقيمات من قبل المشتركين',
                        'ratings' => $ratings
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'لا يموجد تقيمات إلى هذه اللحظة من قبل المشتركين'
                    ],
                    400
                );
            }
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ],
                400
            );
        }

    }
}