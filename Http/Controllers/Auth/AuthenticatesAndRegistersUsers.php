<?php

namespace App\Modules\kagi\Http\Controllers\Auth;


trait AuthenticatesAndRegistersUsers
{

	use AuthenticatesUsers, RegistersUsers {
		AuthenticatesUsers::redirectPath insteadof RegistersUsers;
	}

}
