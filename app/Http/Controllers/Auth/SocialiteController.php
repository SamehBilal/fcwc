<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $gUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $gUser->getEmail()],
            [
                'name'      => $gUser->getName(),
                'google_id' => $gUser->getId(),
                'password'  => bcrypt(str()->random(16)),
            ]
        );

        Auth::login($user);

        if (!$user->phone) {
            return redirect()->route('complete.profile');
        }

        return redirect()->intended('/standings');
    }
}
