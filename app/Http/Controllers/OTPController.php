<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{

    public function verify(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if ($request->otp == $user->otp && $user->otp_expired_at && now()->lt($user->otp_expired_at)) {

            $user->update([
                'otp' => null,
                'otp_expired_at' => null
            ]);

            return redirect('/home');
        }

        return back()->with('error', 'OTP salah atau expired');
    }

}