<?php

namespace App\Models;

use Arr;
use Illuminate\Database\Eloquent\Model;

class SurveyScore extends Model
{
	public function generateScores(Survey $survey): void
	{
		$subcapabilitiesScores = [];
		$capabilityScores = [];
		$capabilities = Capability::all();
		$capabilities = (new OverrideCapability())->getModelOverrides($capabilities, $survey->school_id, $survey->stakeholder_id);
		$capabilities = $capabilities->keyBy('id');
		$subcapabilities = Subcapability::all();
		$subcapabilities = (new OverrideCapability())->getModelOverrides($subcapabilities, $survey->school_id, $survey->stakeholder_id);
		$subcapabilities = $subcapabilities->keyBy('id');

		foreach ($survey->answers as $answer) {
			$subcapability = $answer->indicator->subcapability;
			if (!isset($subcapabilitiesScores[$subcapability->id]))
				$subcapabilitiesScores[$subcapability->id] = [$answer->score];
			else
				$subcapabilitiesScores[$subcapability->id][] = $answer->score;
		}

		foreach ($subcapabilitiesScores as $key => $scores) {

			$subcapabilityScore = new SurveySubcapabilityScore();
			$subcapabilityScore->survey_id = $survey->id;
			$subcapabilityScore->school_id = $survey->school_id;
			$subcapabilityScore->stakeholder_id = $survey->stakeholder_id;
			$subcapabilityScore->subcapability_id = $key;
			$score = (array_sum($scores) / count($scores)) * 20;
			$subcapabilityScore->score = $score;
			$subcapabilityScore->save();

			$capabilityId = $subcapabilities[$key]->capability_id;
			$weightedScore = $score / 100 * $subcapabilities[$key]->weight;
			if (isset($capabilityScores[$capabilityId]))
				$capabilityScores[$capabilityId] += $weightedScore;
			else
				$capabilityScores[$capabilityId] = $weightedScore;
		}

		$surveyTotalScore = 0;
		foreach ($capabilityScores as $key => $score) {
			$capabilityScore = new SurveyCapabilityScore();
			$capabilityScore->survey_id = $survey->id;
			$capabilityScore->school_id = $survey->school_id;
			$capabilityScore->stakeholder_id = $survey->stakeholder_id;
			$capabilityScore->capability_id = $key;
			$capabilityScore->score = round($score, 1);
			$surveyTotalScore += $score / 100 * $capabilities[$key]->weight;
			$capabilityScore->save();
		}

		$surveyScore = new SurveyScore();
		$surveyScore->score = $surveyTotalScore;
		$surveyScore->survey_id = $survey->id;
		$surveyScore->stakeholder_id = $survey->stakeholder_id;
		$surveyScore->save();

		$survey->status = 'completed';
		$survey->save();
	}
}