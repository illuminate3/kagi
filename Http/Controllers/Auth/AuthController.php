<?php

namespace App\Modules\kagi\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\kagi\Http\Controllers\Auth\ThrottlesLogins;
use App\Modules\kagi\Http\Controllers\Auth\AuthenticatesAndRegistersUsers;

use App\Modules\Kagi\Http\Models\User;

use Config;
use Socialite;
use Validator;


class AuthController extends Controller
{


	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}


	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}

	/**
	 * Redirect the user to the GitHub authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProvider()
	{
//		return Socialite::driver(Config::get('kagi.kagi_social'))->redirect();
		return Socialite::driver('github')->redirect();
	}


	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderCallback()
	{
//dd('die');
//		$user = Socialite::driver(Config::get('kagi.kagi_social'))->user();
$user = Socialite::driver('github')->user();
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

dd($user);

		return redirect('/');
		$this->auth->login($user, true);
		return $listener->userHasLoggedIn($user);
	}

}
