<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\Trainer;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->get();
        if (isset($resetData->token) && count($resetData) > 0) {
            $trainer = Trainer::where('email', $resetData[0]['email']);
            return view('password.resetPassword')->with('trainer', $trainer);
        } else {
            return view('errors.404');
        }
    }
}