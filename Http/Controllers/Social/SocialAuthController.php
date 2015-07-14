<?php

namespace App\Modules\kagi\Http\Controllers\Social;

use App\Http\Controllers\Controller;

use App\Modules\kagi\Http\Controllers\Auth\ThrottlesLogins;
use App\Modules\kagi\Http\Controllers\Auth\AuthenticatesAndRegistersUsers;

use App\Modules\Kagi\Http\Repositories\RegistrarRepository;
use App\Modules\Kagi\Http\Models\User;
use App\Modules\Kagi\Http\Repositories\UserRepository;

use Config;
use Socialite;
use Validator;


class SocialAuthController extends Controller
{


	public function __construct(
			RegistrarRepository $registrar_repo,
			UserRepository $user_repo
		)
	{
		$this->registrar_repo = $registrar_repo;
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

		$check_if_exists = $this->registrar_repo->checkUserExists($social_name, $social_email);

		if ($check_if_exists == null) {
			$this->registrar_repo->createSocialUser($social_name, $social_email);
		}

use Caffeinated\Shinobi\Models\Role as shinobiRole;
		shinobiRole $shinobiRole,

$check_again = $this->checkUserExists($name, $email);
$user = $this->user->find($check_again->id);

$user->syncRoles([Config::get('kagi.default_role')]);

\Event::fire(new \ProfileWasCreated($check_again));
\Event::fire(new \EmployeeWasCreated($check_again));

return $user;

} else {
//dd($check);
$this->touchLastLogin($check->id);



dd('good');




// 		return redirect('/');
// 		$this->auth->login($user, true);
// 		return $listener->userHasLoggedIn($user);
	}


}
