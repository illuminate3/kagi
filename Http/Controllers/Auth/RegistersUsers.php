<?php

namespace App\Modules\kagi\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
		$validator = $this->validator($request->all());

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		Auth::login($this->create($request->all()));

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

		$confirmedCode = $this->registrar->confirmCode($code);

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
		$user = $this->registrar->confirmEmail($request->email);

		if ( $user != null) {
			$this->registrar->confirmUser($user);
			$this->registrar->activateUser($user);

			Flash::success( trans('kotoba::auth.success.login') );
			return redirect($this->redirectPath());
		} else {

			Flash::error( trans('kotoba::auth.error.email') );
			return redirect('auth/confirm/'.$code)
				->withInput($request->only('email'));
		}

	}


}
