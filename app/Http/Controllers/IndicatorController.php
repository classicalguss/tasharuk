<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicatorRequest;
use App\Http\Requests\StoreCapabilityRequest;
use App\Http\Requests\UpdateCapabilityRequest;
use App\Models\Capability;
use App\Models\Indicator;
use App\Models\OverrideCapability;
use App\Models\Subcapability;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
	public function IndicatorsManagement(Subcapability $subcapability)
	{
		return view('pages.indicators', [
			'subcapability' => $subcapability,
			'capability' => $subcapability->capability
		]);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request, Subcapability $subcapability)
	{
		$stakeholderId = $request->get('stakeholder_id');
		$indicators = Indicator::whereSubcapabilityId($subcapability->id)->get();
		foreach ($indicators as $indicator) {

			$overrides = OverrideCapability::where([
				'updated_model' => 'indicator',
				'foreign_id' => $indicator->id,
				'stakeholder_id' => $stakeholderId
			])->get();
			foreach ($overrides as $override) {
				$updatedColumn = $override->updated_column;
				$newValue = $override->new_value;
				if (ctype_digit($newValue))
					$newValue = (int)$newValue;
				$indicator->$updatedColumn = $newValue;
			}
		}
		return response()->json([
			'data' => $indicators
		]);
	}

	public function update(Subcapability $subcapability, Indicator $indicator, Request $request)
	{
		$stakeholderId = $request->post('stakeholder_id');
		$safe = ['text', 'highly_effective', 'effective', 'satisfactory', 'needs_improvement', 'does_not_meet_standard', 'is_visible'];
		$validated = $request->only($safe);
		if ($stakeholderId) {
			foreach ($validated as $key => $value) {
				OverrideCapability::updateOrCreate([
					'updated_model' => 'indicator',
					'updated_column' => $key,
					'foreign_id' => $indicator->id,
					'stakeholder_id' => $stakeholderId
				], [
					'new_value' => $value
				]);
			}
		} else {
			$indicator->update($validated);
		}
		return response()->noContent();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(IndicatorRequest $request, Subcapability $subcapability)
	{
		$request->merge(['subcapability_id' => $subcapability->id]);
		Indicator::create($request->all());
		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Subcapability $subcapability, Indicator $indicator)
	{
		Indicator::whereId($indicator->id)->delete();
		return response()->noContent();
	}
}
