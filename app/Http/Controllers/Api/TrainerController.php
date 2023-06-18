<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PasswordReset;
use App\Models\Subscriber;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TrainerController extends Controller
{
    public function changePassword(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|min:6|max:100',
                'confirm_password' => 'required|same:password',
                'trainer_id' => 'required|numeric|'
            ],
        );
        if (!$validator->fails()) {
            $trainer = $request->user(); // المستخد الحالي
            // $trainer = Trainer::find($id);
            $trainer = Trainer::find($request->trainer_id);
            if (Hash::check($request->old_password, $trainer->password)) {
                $trainer = Trainer::find($trainer->id);
                $trainer->password = Hash::make($request->password);
                $result = $trainer->save();
                if ($result) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'تم تحديث كلمة المرورو بنجاح'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'فشلت عملة تغير كلمة المرور'
                        ],
                        400
                    );
                }

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'كلمة السر القديمة غير متطابقة !!'
                    ],
                    400
                );
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], 400);
        }

    }



    public function showNotificatio()
    {
        try {
            $notifications = Notification::all();
            if (!$notifications) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'حدثت مشكلة يبو نوح'
                    ],
                    400
                );
            } else {
                return response()->json(
                    [
                        'status' => true,
                        'notifications' => $notifications
                    ],
                    200
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                ],
                400
            );
        }


    }

    public function showSubscribers(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'trainer_id' => 'required|numeric|exists:trainers,id'
            ],
        );
        try {
            if (!$validator->fails()) {
                $trainer_id = $request->post('trainer_id');
                $subscribers = Subscriber::with('subscription')->where('trainer_id', $trainer_id)->get();
                return response()->json([
                    'status' => true,
                    'subscribers' => $subscribers
                ], 200);

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validator->getMessageBag()->first(),
                    ],
                    400
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                ],
                500
            );
        }


    }

}