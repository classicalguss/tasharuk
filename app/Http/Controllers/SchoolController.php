<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\Indicator;
use App\Models\School;
use App\Models\SchoolStakeholderWeight;
use App\Models\Stakeholder;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use App\Models\SurveySubcapabilityScore;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		if (!$request->expectsJson())
			return view('pages.schools');

		$columns = [
			0 => 'name',
		];
		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $request->input('order.0.column');
		$dir = $request->input('order.0.dir');

		$totalData = School::count();
		$totalFiltered = $totalData;

		if (empty($request->input('search.value'))) {
			$schools = School::offset($start)
				->with(['owner', 'admins'])
				->limit($limit);
		} else {
			$search = $request->input('search.value');

			$schools = School::where('name', 'LIKE', "%{$search}%")
				->offset($start)
				->with(['owner', 'admins'])
				->limit($limit);

			$totalFiltered = School::where('name', 'LIKE', "%{$search}%")
				->count();
		}

		if (!is_null($order) && $dir) {
			$order = $columns[$order];
			$schools->orderBy($order, $dir);
		}

		return response()->json([
			'draw' => intval($request->input('draw')),
			'code' => 200,
			'recordsFiltered' => $totalFiltered,
			'data' => $schools->get(),
			'recordsTotal' => $totalData
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$validated = $request->validate([
			'name' => 'required'
		]);
		School::create($validated);
		toastr()->success('School created successfully');
		return redirect()->back();
    }

	public function generateReport(School $school)
	{
		$capabilities = Capability::whereId(1)->get();
		$surveyIds = Survey::whereSchoolId($school->id)->get()->pluck('id');

		$surveyScores = SurveyScore::selectRaw('capability_id, round(avg(score), 2) as average')
			->whereIn('survey_id', $surveyIds)->groupBy('capability_id')->get()->toArray();
		$surveyScores = array_column($surveyScores, 'average', 'capability_id');

		$surveySubcapabilitiesScore = SurveySubcapabilityScore::selectRaw('subcapability_id, avg(score) as average')
			->whereIn('survey_id', $surveyIds)->groupBy('subcapability_id')->get()->toArray();
		$subcapabilitiesScores = array_column($surveySubcapabilitiesScore, 'average', 'subcapability_id');

		$stakeholders = Stakeholder::all();
		$indicatorStakeholdersAverages = [];
		foreach ($stakeholders as $stakeholder) {
			$stakeholderCompletedSurveys = Survey::whereStatus('completed')
				->whereStakeholderId($stakeholder->id)
				->get()
				->pluck('id');

			$indicatorAverages = SurveyAnswer::selectRaw('indicator_id, avg(score) as average')
				->whereIn('survey_id', $stakeholderCompletedSurveys)->groupBy('indicator_id')->get()->toArray();
			$indicatorAverages = array_column($indicatorAverages, 'average', 'indicator_id');

			foreach ($indicatorAverages as $indicatorId => $average) {

				$indicatorStakeholdersAverages[$indicatorId][$stakeholder->id] = round($average, 2);
			}
		}
		logger($subcapabilitiesScores);

		return view('pages.schools.report', [
			'school' => $school,
			'capabilities' => $capabilities,
			'subcapabilitiesScores' => $subcapabilitiesScores,
			'stakeholders' => $stakeholders,
			'indicatorStakeholdersAverages' => $indicatorStakeholdersAverages,
			'surveyScores' => $surveyScores
		]);
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
		$validated = $request->validate([
			'name' => 'required'
		]);
		$school->update($validated);
		toastr()->success('School updated successfully');
		return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
		School::whereId($school->id)->delete();
		toastr()->success('School deleted successfully');
		return response()->noContent();
    }

	public function storeStakeholderWeights(School $school, Request $request) {
		$weights = $request->post('weights');
		$schoolId = $request->post('school_id');
		foreach ($weights as $key => $value) {
			SchoolStakeholderWeight::updateOrCreate([
				'school_id' => $schoolId,
				'stakeholder_id' => $key,
				'weight' => $value
			]);
		}
		return response()->noContent();
	}

	public function updateStakeholderWeights(School $school, Request $request) {
		$stakeholderWeights = SchoolStakeholderWeight::whereSchoolId($school->id)->get();
		$stakeholders = Stakeholder::all();

		//Only show updated stakeholder weights if they have the same stakeholder ids
		if ($stakeholderWeights->pluck('stakeholder_id')->sort() == $stakeholders->pluck('id')->sort()) {
			$stakeholderWeights = array_column($stakeholderWeights->toArray(), 'weight', 'stakeholder_id');
			foreach ($stakeholders as &$stakeholder) {
				$stakeholder['weight'] = $stakeholderWeights[$stakeholder->id];
			}
		} else {
			foreach ($stakeholders as &$stakeholder) {
				$stakeholder['weight'] = intval(100/count($stakeholders));
			}
		}

		if ($request->expectsJson()) {
			return [
				'data' => $stakeholders
			];
		}

		return view('pages.schools.updateStakeholderWeights', [
			'stakeholders' => $stakeholders
		]);

	}
}
