<?php

namespace App\Modules\kagi\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Flash;
use Theme;


trait RegistersUsers
{

	use RedirectsUsers;


	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return Theme::View('kagi::auth.register');
	}


	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
//dd($request);
		$validator = $this->validator($request->all());
//dd($validator);

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

//		Auth::login($this->create($request->all()));
		$this->registrar_repo->create($request->all());

		Flash::warning(trans('kotoba::email.success.sent'));
		return redirect($this->redirectPath());
	}


/*
|--------------------------------------------------------------------------
| Confirm Users
|--------------------------------------------------------------------------
*/

	/**
	 * Attempt to confirm account with code
	 *
	 * @param  string $code
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getConfirm($code)
	{
//dd($code);

		$confirmedCode = $this->registrar_repo->confirmCode($code);

		if ( $confirmedCode == true ) {
//			Flash::success( trans('kotoba::auth.success.confirmation') );
			return View('kagi::auth.confirm')->with(compact("code"));
		} else {
			Flash::error( trans('kotoba::auth.error.confirmation') );
			return View('kagi::auth.confirm')->with(compact("code"));
		}
	}


	/**
	 * Attempt to confirm account with email and then change confirmed status
	 *
	 * @param  string $code
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postConfirm(
		Request $request,
		$code
		)
	{
//dd($code);
		$user = $this->registrar_repo->confirmEmail($request->email);
//dd($user);

		if ( $user != null) {
			$this->registrar_repo->confirmUser($user);
			$this->registrar_repo->activateUser($user);

			Flash::success( trans('kotoba::auth.success.login') );
			return redirect($this->redirectPath());
		} else {

			Flash::error( trans('kotoba::auth.error.email') );
			return redirect('auth/confirm/'.$code)
				->withInput($request->only('email'));
		}

	}


}
