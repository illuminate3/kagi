<?php

namespace App\Modules\kagi\Http\Controllers\Social;

use App\Http\Controllers\Controller;

use App\Modules\kagi\Http\Controllers\Auth\ThrottlesLogins;
use App\Modules\kagi\Http\Controllers\Auth\AuthenticatesAndRegistersUsers;

use App\Modules\Kagi\Http\Models\User;

use Config;
use Socialite;
use Validator;


class SocialAuthController extends Controller
{


	/**
	 * Redirect the user to the GitHub authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProvider()
	{
		return Socialite::driver(Config::get('kagi.kagi_social'))->redirect();
	}


	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderCallback()
	{
		$user = Socialite::driver(Config::get('kagi.kagi_social'))->user();

		// OAuth Two Providers
		$token = $user->token;

		// OAuth One Providers
// 		$token = $user->token;
// 		$tokenSecret = $user->tokenSecret;

		// All Providers
		$user->getId();
		$user->getNickname();
		$user->getName();
		$user->getEmail();
		$user->getAvatar();


		return redirect('/');
		$this->auth->login($user, true);
		return $listener->userHasLoggedIn($user);
	}


}
