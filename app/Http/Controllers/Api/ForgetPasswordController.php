<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ForgetPasswordController extends Controller
{
    //

    public function forgetPassword(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email',
        ]);

        try {
            if (!$validator->fails()) {
                $trainer = Trainer::where('email', $request->email)->get();
                if (count($trainer) > 0) {

                    $token = Str::random(40);
                    $domain = URL::to('/');
                    $url = $domain . '/reset-password?token=' . $token;

                    $data['url'] = $url;
                    $data['email'] = $request->email;
                    $data['title'] = 'Password Reset';
                    $data['body'] = 'من فضلك إضغط على الرابط التالي من أجل إعادة تعين كلمة المرور الخاصة بك';
                    Mail::to('nouh.work@gmail.com')->send(new ResetPasswordMail($data));
                    $dateTime = Carbon::now()->format('Y-m-d H:i:s');

                    $result = PasswordReset::where('token', $token)->first();

                    if (is_null($result)) {
                        $newReast = new PasswordReset([
                            'email' => $request->email,
                            'token' => $token,
                            'created_at' => $dateTime
                        ]);
                        $newReast->save();
                    } else {
                        $result->email = $request->email;
                        $result->token = $token;
                        $result->created_at = $dateTime;
                        $result->update();
                    }

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'من فضلك افحص البريد الإلكتروني '
                        ],
                        200
                    );


                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'المستخدم غير موجود ؟؟'
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


        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                ],
                403
            );
        }
    }



}