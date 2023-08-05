<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Notifications\UserInvited;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Notification;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

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
		if (!$request->expectsJson())
			return view('pages.users');

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

	public function update(User $user, Request $request)
	{
		$validated = $request->only(['school_id', 'role_id']);
		$user->update($validated);
		$role = Role::find($validated['role_id']);
		logger($role);
		$user->syncRoles($role);
		$user->save();
		toastr()->success('Updated Successfully');
		return redirect()->back();
	}

	public function toggleIsActive(User $user)
	{
		$user->is_active = !$user->is_active;
		toastr('User '.($user->is_active ? 'Activated' : 'Deactivated'));
		$user->save();
		return redirect()->back();
	}

	public function userInvite()
	{
		return view('pages.users.invite', [
			'schools' => School::all(),
			'roles' => Role::all()
		]);
	}
	public function inviteUser(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
			'school_id' => 'int',
			'role_id' => 'int'
		]);
		try {
			Notification::route('mail', $validated['email'])->notify(
				new UserInvited($validated['name'], $validated['email'], $validated['school_id'], $validated['role_id'])
			);
		} catch (Exception $exception) {
			toastr()->error('Oops. Something wrong happened while sending the email.');
		}

		toastr()->success('Invitation sent successfully');
		return redirect()->route('users.index');
	}

	public function invitationAccept(Request $request)
	{
		if (! $request->hasValidSignature()) {
			abort(401);
		}
		$request->session()->put('accept-invitation-prefilled-data', [
			'email' => $request->get('email'),
			'school_id' => $request->get('school_id'),
			'role_id' => $request->get('role_id')
		]);
		return view('pages.users.accept-invitation');
	}

	public function acceptInvitation(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'password' => ['required', 'string', new Password, 'confirmed']
		]);
		$prefilledData = $request->session()->get('accept-invitation-prefilled-data');
		$request->merge($prefilledData);
		$request->merge(['password' => Hash::make($request->input(['password']))]);
		$user = User::create($request->all());

		$role = Role::find($prefilledData['role_id']);
		$user->assignRole($role);
		Auth::login($user);
		return redirect('/');
	}

	public function destroy(User $user)
	{
		$user->delete();
		toastr()->success('User deleted sucessfully');
		return redirect(route('users.index'));
	}
}