<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCapabilityRequest;
use App\Http\Requests\UpdateCapabilityRequest;
use App\Models\Capability;
use App\Models\OverrideCapability;
use App\Models\Subcapability;
use Illuminate\Http\Request;

class SubcapabilityController extends Controller
{
	public function SubcapabilitiesManagement(Capability $capability) {
		return view('pages.subcapabilities', [
			'capability' => $capability
		]);
	}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Capability $capability)
    {
		$stakeholderId = $request->get('stakeholder_id');
		$subcapabilities = Subcapability::whereCapabilityId($capability->id)->get();
		foreach ($subcapabilities as $subcapability) {

			$overrides = OverrideCapability::where([
				'updated_model' => 'subcapability',
				'foreign_id' => $subcapability->id,
				'stakeholder_id' => $stakeholderId
			])->get();
			foreach ($overrides as $override) {
				$updatedColumn = $override->updated_column;
				$newValue = $override->new_value;
				if (ctype_digit($newValue))
					$newValue = (int)$newValue;
				$subcapability->$updatedColumn = $newValue;
			}
		}
		return response()->json([
			'data' => $subcapabilities
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
    public function store(StoreCapabilityRequest $request, Capability $capability)
    {
		Subcapability::create([
			'name' => $request->post('name'),
			'capability_id' => $capability->id,
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
    public function update(UpdateCapabilityRequest $request, Capability $capability, Subcapability $subcapability)
    {
		$stakeholderId = $request->post('stakeholder_id');
		if ($stakeholderId)
			foreach ($request->validated() as $key => $value) {
				OverrideCapability::updateOrCreate([
					'updated_model' => 'subcapability',
					'updated_column' => $key,
					'foreign_id' => $subcapability->id,
					'stakeholder_id' => $stakeholderId
				],[
					'new_value' => $value
				]);
			}
		else
			$subcapability->update($request->validated());
		if ($request->post('response') == 'full-reload')
			return redirect()->back();

		return response()->noContent();
    }

	public function updateWeights(Request $request) {
		$stakeholderId = $request->post('stakeholder_id');
		$weights = $request->post('weights');
		foreach ($weights as $key => $value) {
			if ($stakeholderId) {
				OverrideCapability::updateOrCreate([
					'updated_model' => 'subcapability',
					'updated_column' => 'weight',
					'foreign_id' => $key,
					'stakeholder_id' => $stakeholderId
				],[
					'new_value' => $value
				]);
			} else {
				Subcapability::whereId($key)->update(['weight' => $value]);
			}
		}
		return response()->noContent();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Capability $capability, Subcapability $subcapability)
	{
		Subcapability::whereId($subcapability->id)->delete();
		return response()->noContent();
	}
}
