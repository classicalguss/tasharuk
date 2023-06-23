<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\Stakeholder;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
	/**
	 * Redirect to user-management view.
	 *
	 */
	public function StakeholderManagement()
	{
		return view('pages.stakeholders');
	}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
		return response()->json([
			'code' => 200,
			'data' => Stakeholder::all()
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
		logger("should create here");
		Stakeholder::create([
			'name' => $request->post('name'),
		]);
		return redirect()->back();
	}

    /**
     * Display the specified resource.
     */
    public function show(Stakeholder $stakeholder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stakeholder $stakeholder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stakeholder $stakeholder)
    {
		$validated = $request->validate([
			'name' => 'string'
		]);
		$stakeholder->update($validated);
		return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stakeholder $stakeholder)
    {
		$stakeholder->delete();
		return response()->noContent();
    }
}
