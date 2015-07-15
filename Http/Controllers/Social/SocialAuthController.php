<?php

namespace App\Modules\kagi\Http\Controllers\Social;

use App\Http\Controllers\Controller;

use Caffeinated\Shinobi\Traits\ShinobiTrait;

//use App\Modules\Kagi\Http\Repositories\RegistrarRepository;
use App\Http\Models\User;
use App\Modules\Kagi\Http\Models\User as KagiUser;
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
//			Guard $auth,
//			RegistrarRepository $registrar_repo,
			KagiUser $kagi_user,
			User $user,
			UserRepository $user_repo
		)
	{
//		$this->auth = $auth;
//		$this->registrar_repo = $registrar_repo;
		$this->kagi_user = $kagi_user;
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

		$check = $this->user_repo->checkUserExists($user->email);

		if ($check == null) {

			$this->user_repo->createSocialUser($user);

			$get_user_info = $this->user_repo->checkUserExists($user->email);
			$user = $this->kagi_user->find($get_user_info->id);
			$user->syncRoles([Config::get('kagi.default_role')]);

			\Event::fire(new \ProfileWasCreated($get_user_info));

		}

		if ( Auth::attempt(['email' => $check->email, 'password' => $check->email]) ) {
			Auth::loginUsingId($check->id);
			$this->user_repo->touchLastLogin($check->email);
//dd(Auth::user());

			Flash::success(trans('kotoba::auth.success.login'));
//			return redirect(Config::get('kagi.new_user_return_path'));
			return redirect()->intended(Config::get('kagi.new_user_return_path'));
		}

		Flash::success(trans('kotoba::auth.error.login'));
		return redirect('social/login');

	}


}
