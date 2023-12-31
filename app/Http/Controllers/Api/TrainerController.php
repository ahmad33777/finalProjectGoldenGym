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
            $trainer = $request->user(); // المستخدم الحالي
            $trainer = Trainer::find($request->trainer_id);
            if (Hash::check($request->old_password, $trainer->password)) {
                $trainer = Trainer::find($trainer->id);
                $trainer->password = Hash::make($request->password);
                $result = $trainer->save();
                if ($result) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'تم تحديث كلمة المرور بنجاح'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'فشلت عملة تغير كلمة المرور'
                        ],
                        200
                    );
                }

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'كلمة المرور القديمة غير متطابقة !!'
                    ],
                    200
                );
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "يجب أن تتكون كلمة المرور على الأقل من 6 حروف",
            ], 200);
        }

    }



    public function showNotificatio()
    {
        try {
            $notifications = Notification::orderBy('created_at', 'desc')->get();
            if ($notifications->isEmpty()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => "لا يوجد إشعارات للعرض"
                    ],
                    200
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
                200
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
                    200
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                ],
                200
            );
        }


    }

}