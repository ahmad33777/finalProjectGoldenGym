<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    // to show login laget
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $validator = Validator(
            $request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string|min:3',
                'remember' => 'boolean'
            ],

        );

        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];


        if ($validator) {
            if (Auth::guard('web')->attempt($credentials, $request->get('remember'))) {
                $user = Auth::user();
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('error', 'الرجاء ادخال البريد الإلكتروني وكلمة المرورو بشكل صحيح');
            }
        } else {
            return redirect()->back()->with('error', 'الرجاء ادخال البريد الإلكتروني وكلمة المرورو بشكل صحيح');
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate(); // لابطال الجلسة
        return redirect()->route('admin.login');
    }



    public function forgetPasswordLoad()
    {
        return view('forgotpassword');
    }



    public function sendURL(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email',
        ]);

        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'هذا الحقل كطلوب',
                'email.email' => 'خطأفي التنسيق'
            ]
        );
        $user = \App\Models\User::where('email', $request->email)->get();
        if (count($user) > 0) {

            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain . '/user/reset-password?token=' . $token;

            $data['url'] = $url;
            $data['email'] = $request->email;
            $data['title'] = 'Password Reset';
            $data['body'] = 'من فضلك إضغط على الرابط التالي من أجل إعادة تعين كلمة المرور الخاصة بك';
            Mail::to($request->email)->send(new ResetPasswordMail($data));
            $dateTime = Carbon::now()->format('Y-m-d H:i:s');
            $status = \App\Models\PasswordReset::updateOrCreate(
                ['email' => $request->email],
                ['token' => $token, 'created_at' => $dateTime],
            );
            session()->flash('status', $status);
            return redirect()->back();



        }
    }


    function resetPasswordshow(Request $request)
    {
        $resetData = DB::table('password_resets')->where('token', $request->token)->first();
        $user = User::where('email', $resetData->email)->first();

        if (isset($resetData)) {
            $user = User::where('email', $resetData->email)->first();
            return view('reset-password')->with('user', $user);
        } else {
            return view('errors.404');
        }


    }
    function resetPassword(Request $request)
    {
        $request->validate([
            'id' => 'required|',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('id', $request->id)->first();

        $user->password = Hash::make($request->password);

        $status = $user->save();

        session()->flash('status', $status);
        return redirect()->back();

    }


}