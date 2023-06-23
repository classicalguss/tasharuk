<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use function response;
use function view;

class UserController extends Controller
{
	/**
	 * Redirect to user-management view.
	 *
	 */
	public function UserManagement()
	{
		return view('pages.users');
	}

	public function show(User $user)
	{
		return view('pages.users.view', ['user' => $user]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$columns = [
			0 => 'name',
			1 => 'school.name'
		];
		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $request->input('order.0.column');
		$dir = $request->input('order.0.dir');

		$totalData = User::count();
		$totalFiltered = $totalData;

		if (empty($request->input('search.value'))) {
			$users = User::offset($start)
				->with('roles_all', 'school')
				->limit($limit);
		} else {
			$search = $request->input('search.value');

			$users = User::with('roles_all', 'school')->where('id', 'LIKE', "%{$search}%")
				->orWhere('name', 'LIKE', "%{$search}%")
				->orWhere('email', 'LIKE', "%{$search}%")
				->offset($start)
				->limit($limit);

			$totalFiltered = User::where('id', 'LIKE', "%{$search}%")
				->orWhere('name', 'LIKE', "%{$search}%")
				->orWhere('email', 'LIKE', "%{$search}%")
				->count();
		}

		if (!is_null($order) && $dir) {
			$order = $columns[$order];
			$users->orderBy($order, $dir);
		}

		return response()->json([
			'draw' => intval($request->input('draw')),
			'code' => 200,
			'recordsFiltered' => $totalFiltered,
			'data' => $users->get(),
			'recordsTotal' => $totalData
		]);
	}


}