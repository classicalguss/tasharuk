<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
	/**
	 * Redirect to user-management view.
	 *
	 */
	public function SchoolManagement()
	{
		return view('pages.schools');
	}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$limit = $request->input('length');
		$start = $request->input('start');

		$schools = School::offset($start)
			->with(['owner', 'admins'])
			->limit($limit)
			->get();

		return response()->json([
			'code' => 200,
			'data' => $schools,
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
    }
}
