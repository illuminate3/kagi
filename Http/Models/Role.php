<?php

namespace App\Modules\Kagi\Http\Domain\Models;

use Illuminate\Database\Eloquent\Model;

use Laracasts\Presenter\PresentableTrait;
use Caffeinated\Shinobi\Traits\ShinobiTrait;


class Role extends Model {


	use PresentableTrait, ShinobiTrait;


	protected $table = 'roles';


// Presenter ---------------------------------------------------------------
	protected $presenter = 'App\Modules\Kagi\Http\Presenters\Role';


// Translation Model -------------------------------------------------------
// Hidden ------------------------------------------------------------------
//	protected $hidden = ['password', 'remember_token'];


// Fillable ----------------------------------------------------------------
	protected $fillable = ['name', 'slug', 'description'];


// Translated Columns ------------------------------------------------------
// Relationships -----------------------------------------------------------
// Functions ---------------------------------------------------------------


}
