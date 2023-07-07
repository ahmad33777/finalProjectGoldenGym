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
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{

    /**
     * Summary of forgetPassword
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
                    Mail::to($request->email)->send(new ResetPasswordMail($data));
                    $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                    PasswordReset::updateOrCreate(
                        ['email' => $request->email],
                        ['token' => $token, 'created_at' => $dateTime],
                    );

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
                            'message' => 'تأكد من صحة البريد الإلكتروني'
                        ],
                        200
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

    /**
     * Summary of resetPasswordshow
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */

    public function resetPasswordshow(Request $request)
    {
        $resetData = DB::table('password_resets')->where('token', $request->token)->first();
        // $resetData = PasswordReset::where('token', $request->token)->get();
        $trainer = Trainer::where('email', $resetData->email)->first();
        if (isset($resetData)) {
            $trainer = Trainer::where('email', $trainer->email)->first();
            return view('password.resetPassword')->with('trainer', $trainer);

        } else {
            return view('errors.404');
        }

    }

    /**
     * Summary of resetPassword
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function resetPassword(Request $request)
    {

        $request->validate([
            'id' => 'required|',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $trainer = Trainer::where('id', $request->id)->first();

        $trainer->password = Hash::make($request->password);

        $status = $trainer->save();

        session()->flash('status', $status);
        return redirect()->back();



    }



}