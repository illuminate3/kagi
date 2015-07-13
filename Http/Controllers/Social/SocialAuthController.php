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

		// $user->token;
	}


}
