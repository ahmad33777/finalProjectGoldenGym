<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    //


    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'phone' => 'required|min:10|numeric',
            'password' => 'required|min:5',
            'fcm_token' => 'required|string'
        ]);

        if (!$validator->fails()) {
            $subscriber = Subscriber::where('phone', $request->get('phone'))->first();
            if ($subscriber!==null) {
                if (Hash::check($request->get('password'), $subscriber->password)===true) {
                    if ($subscriber->status == 1) {
                        $token = $subscriber->createToken('subscriber')->plainTextToken;
                        $subscriber->fcm_token = $request->get("fcm_token");
                        $subscriber->save();
                        return response()->json(
                            [
                                'status' => true,
                                'token' => $token,
                                'type' => 'subscriber',
                                'subscriber' => $subscriber,

                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => false,
                                'message' => 'غير مصرح لك بالدخول أنت غير مصرح بك يرجى مراجة المالية'

                            ],
                            200
                        );
                    }

                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'خطأ في كلمة المرور '
                        ],
                        200
                    );
                }
            } else if ($subscriber===null) {
                $trainer = Trainer::where('phone', $request->get('phone'))->first();
              if($trainer!==null){
                if (Hash::check($request->get('password'), $trainer->password)) {
                    $token = $trainer->createToken('trainer')->plainTextToken;
                    $trainer->fcm_token = $request->fcm_token;
                    $trainer->save();
                    return response()->json(
                        [
                            'status' => true,
                            'token' => $token,
                            'type' => 'trainer',
                            'trainer' => $trainer,

                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'خطأ في كلمة المرور'
                        ],
                        200
                    );
                }
              }else{
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'خطأ في رقم الهاتف'
                    ],
                    200
                );
              }
            }

        } else {
            return response()->json(['status' => false, 'message' => 'خطأ في كلمة المرور أو رقم الهاتف'], 200);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => true,
                'message' => 'شكراً لاستخدام التطبيق'
            ],
            200
        );


    }


}