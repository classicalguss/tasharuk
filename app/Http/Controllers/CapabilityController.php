<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCapabilityRequest;
use App\Http\Requests\UpdateCapabilityRequest;
use App\Models\Capability;
use App\Models\CapabilityImport;
use App\Models\OverrideCapability;
use App\Models\School;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CapabilityController extends Controller
{
	public function CapabilityManagement() {
		return view('pages.capabilities', [
			'stakeholders' => Stakeholder::all(),
			'schools' => School::all()
		]);
	}

	public function import(Request $request) {
		Excel::import(new CapabilityImport(), $request->file('excel'));
	}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$capabilities = Capability::all();
		$stakeholderId = $request->get('stakeholder_id');
		$schoolId = $request->get('school_id');
		foreach ($capabilities as $capability) {

			$overrides = OverrideCapability::where([
				'updated_model' => 'capability',
				'foreign_id' => $capability->id,
			])
				->whereIn('stakeholder_id', [$stakeholderId, 0])
				->whereIn('school_id', [$schoolId, 0])
				->orderBy('school_id')->orderBy('stakeholder_id')->get();

			foreach ($overrides as $override) {
				$updatedColumn = $override->updated_column;
				$newValue = $override->new_value;
				if (ctype_digit($newValue))
					$newValue = (int)$newValue;
				$capability->$updatedColumn = $newValue;
			}
		}
		return response()->json([
			'data' => $capabilities
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCapabilityRequest $request)
    {
        Capability::create([
			'name' => $request->post('name'),
			'weight' => 0,
			'is_visible' => false
		]);
		return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Capability $capability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Capability $capability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCapabilityRequest $request, Capability $capability)
    {
		$stakeholderId = $request->post('stakeholder_id');
		$schoolId = $request->post('school_id');
		if ($schoolId || $stakeholderId)
			foreach ($request->validated() as $key => $value) {
				OverrideCapability::updateOrCreate([
					'updated_model' => 'capability',
					'updated_column' => $key,
					'foreign_id' => $capability->id,
					'stakeholder_id' => $stakeholderId,
					'school_id' => $schoolId
				],[
					'new_value' => $value
				]);
			}
		else
			$capability->update($request->validated());

		if ($request->post('response') == 'full-reload')
			return redirect()->back();

		return response()->noContent();
    }

	public function updateWeights(Request $request) {
		$weights = $request->post('weights');
		$stakeholderId = $request->post('stakeholder_id');
		$schoolId = $request->post('school_id');
		foreach ($weights as $key => $value) {
			if ($schoolId || $stakeholderId) {
				OverrideCapability::updateOrCreate([
					'updated_model' => 'capability',
					'updated_column' => 'weight',
					'foreign_id' => $key,
					'stakeholder_id' => $stakeholderId,
					'school_id' => $schoolId
				],[
					'new_value' => $value
				]);
			} else {
				Capability::whereId($key)->update(['weight' => $value]);
			}
		}
		return response()->noContent();
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capability $capability)
    {
		$capability->delete();
		return response()->noContent();
    }
}
