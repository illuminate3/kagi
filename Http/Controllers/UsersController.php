<?php
namespace App\Modules\Kagi\Http\Controllers;

use App\Modules\Kagi\Http\Domain\Models\User;
use App\Modules\Kagi\Http\Domain\Repositories\UserRepository;
use App\Modules\Kagi\Http\Domain\Repositories\RoleRepository;

use Illuminate\Http\Request;
use App\Modules\Kagi\Http\Requests\UserCreateRequest;
use App\Modules\Kagi\Http\Requests\UserUpdateRequest;
use App\Modules\Kagi\Http\Requests\DeleteRequest;

use Datatables;
use Flash;

class UsersController extends KagiController {

	/**
	 * The UserRepository instance.
	 *
	 * @var App\Repositories\UserRepository
	 */
	protected $user;

	/**
	 * The RoleRepository instance.
	 *
	 * @var App\Repositories\RoleRepository
	 */
	protected $role;

	/**
	 * Create a new UserController instance.
	 *
	 * @param  App\Repositories\UserRepository $user
	 * @param  App\Repositories\RoleRepository $role
	 * @return void
	 */
	public function __construct(
			UserRepository $user,
			RoleRepository $role
		)
	{
		$this->user = $user;
		$this->role = $role;

// middleware
		$this->middleware('admin');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View('kagi::users.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('kagi::users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\requests\UserCreateRequest $request
	 *
	 * @return Response
	 */
	public function store(
		UserCreateRequest $request
		)
	{
//dd($request);
		$this->user->store($request->all());
		Flash::success( trans('kotoba::account.success.create') );
		return redirect('admin/users');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
//dd($this->user->show($id));
		return View('kagi::users.show',  $this->user->show($id));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
//dd("edit");
		$modal_title = trans('kotoba::account.command.delete');
		$modal_body = trans('kotoba::account.ask.delete');
		$modal_route = 'admin.users.destroy';
		$modal_id = $id;
		$model = '$user';

		return View('kagi::users.edit',
			$this->user->edit($id),
				compact(
					'modal_title',
					'modal_body',
					'modal_route',
					'modal_id',
					'model'
			));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  App\requests\UserUpdateRequest $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(
		UserUpdateRequest $request,
		$id
		)
	{
//dd($request->password);
		$this->user->update($request->all(), $id);
		Flash::success( trans('kotoba::account.success.update') );
		return redirect('admin/users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(
		DeleteRequest $request,
		$id
		)
	{
		$user= User::find($id);
//dd($user);

		\Event::fire(new \ProfileWasDeleted($user));
		\Event::fire(new \EmployeeWasDeleted($user));

		$user->roles()->detach();
		$user->delete();

		Flash::success( trans('kotoba::account.success.delete') );
		return redirect('admin/users');
	}

	/**
	* Datatables data
	*
	* @return Datatables JSON
	*/
	public function data()
	{
//		$query = User::select(array('users.id','users.name','users.email','users.blocked','users.banned','users.confirmed','users.activated', 'users.created_at'))
//			->orderBy('users.email', 'ASC');
//		$query = User::select('id', 'name', 'email', 'blocked', 'banned', 'confirmed', 'activated', 'created_at')
//			->orderBy('name', 'ASC');
		$query = User::select('id', 'name', 'email', 'blocked', 'banned', 'confirmed', 'activated', 'created_at')
			->orderBy('users.email', 'ASC');
//dd($query);

		return Datatables::of($query)
//			->remove_column('id')

			-> edit_column(
				'blocked',
				'@if ($blocked=="1") <span class="glyphicon glyphicon-ok text-success"></span> @else <span class=\'glyphicon glyphicon-remove text-danger\'></span> @endif'
				)
			-> edit_column(
				'banned',
				'@if ($banned=="1") <span class="glyphicon glyphicon-ok text-success"></span> @else <span class=\'glyphicon glyphicon-remove text-danger\'></span> @endif'
				)
			-> edit_column(
				'confirmed',
				'@if ($confirmed=="1") <span class="glyphicon glyphicon-ok text-success"></span> @else <span class=\'glyphicon glyphicon-remove text-danger\'></span> @endif'
				)
			-> edit_column(
				'activated',
				'@if ($activated=="1") <span class="glyphicon glyphicon-ok text-success"></span> @else <span class=\'glyphicon glyphicon-remove text-danger\'></span> @endif'
				)

			->addColumn(
				'actions',
				'
					<a href="{{ URL::to(\'admin/users/\' . $id . \'/\' ) }}" class="btn btn-info btn-sm" >
						<span class="glyphicon glyphicon-search"></span>  {{ trans("kotoba::button.view") }}
					</a>
					<a href="{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
						<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
					</a>
				'
				)

			->make(true);
	}


}
