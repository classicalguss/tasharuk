<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\Indicator;
use App\Models\School;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyScore;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Str;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
		$surveyAverageTime = Survey::selectRaw('avg(timestampdiff(DAY, created_at, completed_at)) as average')
			->whereStatus('completed')->first()->average;

		$surveyStats = Survey::selectRaw('count(id) as number_of_surveys, status')
			->groupBy('status')
			->get();

		$surveyStats = array_column($surveyStats->toArray(), 'number_of_surveys', 'status');
		$surveyStats = [
			'Completed' => $surveyStats['completed'] ?? 0,
			'In progress' => $surveyStats['progress'] ?? 0,
			'Not started' => $surveyStats['not_started'] ?? 0,
		];

		$surveys = Survey::all();
		$surveyIds = $surveys->pluck('id');

		$surveyScores = SurveyScore::whereIn('survey_id', $surveyIds)->with('capability', 'survey')->get();
		$capabilityScores = [];
		$stakeholdersScores = [];
		//Preparing Array
		foreach ($surveyScores as $score)
		{
			if (!isset($capabilityScores[$score->capability->name]))
				$capabilityScores[$score->capability->name] = [$score->score];
			else
				$capabilityScores[$score->capability->name][] = $score->score;

			if (!isset($stakeholdersScores[$score->survey->stakeholder->name]))
				$stakeholdersScores[$score->survey->stakeholder->name] = [];

			if (!isset($stakeholdersScores[$score->survey->stakeholder->name][$score->capability->name]))
				$stakeholdersScores[$score->survey->stakeholder->name][$score->capability->name] = [$score->score];
			else
				$stakeholdersScores[$score->survey->stakeholder->name][$score->capability->name][] = $score->score;
		}

		//Preparing Averages
		//Overall School Averages
		$capabilityAverages = [];
		foreach ($capabilityScores as $key => $scores) {
			$capabilityAverages[$key] = round(array_sum($scores) / count($scores));
		}

		//Stakeholders Averages
		$stakeholdersAverages = [];
		foreach ($stakeholdersScores as $stakeholder => $capabilitiesScores)
		{
			$stakeholder = Str::snake($stakeholder);
			if (!isset($stakeholdersAverages[$stakeholder]))
				$stakeholdersAverages[$stakeholder] = [];

			foreach ($capabilitiesScores as $capability => $scores) {
				$stakeholdersAverages[$stakeholder][$capability] = round(array_sum($scores) / count($scores));
			}
		}

		return view('pages.dashboard', [
			'schools' => School::all(),
			'surveyAvgTime' => (int) $surveyAverageTime.' days',
			'usersCount' => User::count(),
			'schoolsCount' => School::count(),
			'surveyStats' => $surveyStats,
			'capabilitiesPerformance' => $capabilityAverages,
			'stakeholdersAverages' => $stakeholdersAverages
		]);
    }
}
