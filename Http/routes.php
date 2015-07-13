<?php


/*
|--------------------------------------------------------------------------
| Kagi
|--------------------------------------------------------------------------
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
/*
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');
*/


// Resources


// Controllers


Route::group(['prefix' => 'kagi'], function() {
	Route::get('welcome', [
		'uses'=>'KagiController@welcome'
	]);
});


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


/*
Route::get('social/login', 'SocialAuthController@login');

Route::controllers([
	'auth' => 'kagiAuthController',
	'password' => 'KagiPasswordController',
]);

Route::group(['prefix' => 'auth'], function() {
	Route::get('confirm/{code}', 'kagiAuthController@getConfirm');
	Route::post('confirm/{code}', 'kagiAuthController@postConfirm');
});
*/

// API DATA


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function() {

// Resources

# Users
	Route::resource('users', 'UsersController');
	Route::get('getDelete/{id}', 'UsersController@getDelete');
# Roles
	Route::resource('roles', 'RolesController');
# Permissions
	Route::resource('permissions', 'PermissionsController');

// Controllers
// API DATA
	Route::get('api/users', array(
	//	'as'=>'api.users',
		'uses'=>'UsersController@data'
		));
	Route::get('api/roles', array(
	//	'as'=>'api.roles',
		'uses'=>'RolesController@data'
		));
	Route::get('api/permissions', array(
	//	'as'=>'api.permissions',
		'uses'=>'PermissionsController@data'
		));

});
// --------------------------------------------------------------------------
