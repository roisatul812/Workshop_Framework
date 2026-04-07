<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GoogleController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // gunakan stateless supaya tidak error session
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            [
                'email' => $googleUser->getEmail()
            ],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt('password')
            ]
        );

        Auth::login($user);

        // generate OTP 6 digit
        $otp = rand(100000,999999);

        $user->update([
            'otp' => $otp,
            'otp_expired_at' => now()->addMinutes(5)
        ]);

        // kirim email OTP
        Mail::raw("Kode OTP login kamu: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode OTP Login');
        });

        return redirect('/verify');
    }

}