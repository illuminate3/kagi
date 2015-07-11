<?php

namespace App\Modules\Kagi\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Laracasts\Presenter\PresentableTrait;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {


	use Authenticatable, CanResetPassword, PresentableTrait, ShinobiTrait;


	protected $table = 'users';


// Presenter ---------------------------------------------------------------
	protected $presenter = 'App\Modules\Kagi\Http\Presenters\User';


// Translation Model -------------------------------------------------------
// Hidden ------------------------------------------------------------------
	protected $hidden = ['password', 'remember_token'];


// Fillable ----------------------------------------------------------------
	protected $fillable = [
		'name',
		'email',
		'password',
		'blocked',
		'banned',
		'confirmed',
		'activated',
		'activated_at',
		'last_login',
		'avatar',
		'confirmation_code'
		];


// Translated Columns ------------------------------------------------------
// Relationships -----------------------------------------------------------
// Functions ---------------------------------------------------------------


}
