<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Storage;
use App\Provider;
use App\User;

class ProviderController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }  

    public function handleProviderCallback($provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect()->route('home');
        }

        $socialProvider = Provider::where('provider_id',$socialUser->getId())->first();

        if(!$socialProvider)
        {
			$user = new User();
			$user->name     = $socialUser->getName();
			$user->email    = $socialUser->getEmail();
			$user->description = "That's Me!";
			$user->has_social_account = 1;
			$user->save();

			$social_user = new Provider();
			$social_user->user_id = $user->id;
			$social_user->provider_id = $socialUser->getId();
			$social_user->provider = $provider;
			$social_user->save();

            $avatar = 'images/users/'.$user->id.'/avatar.png';
            Storage::copy('images/users/avatar.png',$avatar);
        }
        else
            $user = $socialProvider->user;

        auth()->login($user);
        return redirect()->route('home');
    }  
}

