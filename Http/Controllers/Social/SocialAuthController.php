<?php

namespace App\Modules\kagi\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use Caffeinated\Shinobi\Traits\ShinobiTrait;

use App\Modules\Kagi\Http\Models\User;
use App\Modules\Kagi\Http\Repositories\UserRepository;

use Auth;
use Config;
use Flash;
use Socialite;
use Validator;


class SocialAuthController extends Controller
{


	use ShinobiTrait;

	private $auth;


	public function __construct(
			User $user,
			UserRepository $user_repo
		)
	{
		$this->user = $user;
		$this->user_repo = $user_repo;
// middleware
		$this->middleware('guest');
	}


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
//dd($user);

// OAuth Two Providers
		$token = $user->token;

/*
// OAuth One Providers
		$token = $user->token;
		$tokenSecret = $user->tokenSecret;

// All Providers
		$social_id = $user->getId();
		$social_nick = $user->getNickname();
		$social_name = $user->getName();
		$social_email = $user->getEmail();
		$social_avatar = $user->getAvatar();
*/

		$check = $this->user_repo->getUserInfo($user->email);

		if ($check == null) {

			$this->user_repo->createSocialUser($user);

			$new_user = $this->user_repo->getUserInfo($user->email);
			$new_user = $this->user->find($new_user->id);
			$new_user->syncRoles([Config::get('kagi.default_role')]);

//			\Event::fire(new \ProfileWasCreated($new_user));

		}

		$login_user = $this->user_repo->getUserInfo($user->email);
		if ( Auth::attempt(['email' => $login_user->email, 'password' => $login_user->email]) ) {
			Auth::loginUsingId($login_user->id);
			$this->user_repo->touchLastLogin($login_user->email);
//dd(Auth::user());

			Flash::success(trans('kotoba::auth.success.login'));
			return redirect()->intended(Config::get('kagi.new_user_return_path'));
		}

		return redirect('social/login');

	}


}
