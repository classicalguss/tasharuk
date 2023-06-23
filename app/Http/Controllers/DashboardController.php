<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
		return view('pages.dashboard', [
			'usersCount' => User::count(),
			'schoolsCount' => School::count()
		]);
    }
}
