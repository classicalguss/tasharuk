<?php

namespace App\Models;

use App\Traits\SchoolFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyScore extends Model
{
    use HasFactory, SchoolFilterable;

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

	public function capability()
	{
		return $this->belongsTo(Capability::class);
	}

	public static function getOverallScore(): float|int
	{
		$stakeholders = SchoolStakeholderWeight::getStakeholderWeights();
		$overallScore = 0;
		foreach ($stakeholders as $stakeholder) {
			$average = SurveyScore::whereStakeholderId($stakeholder->id)->pluck('score')->average() / 100;
			$overallScore += $average * $stakeholder['weight'];
		}

		return round($overallScore);
	}

	public function generateScores(Survey $survey) {
		$subcapabilitiesScores = [];
		$capabilityScores = [];
		foreach ($survey->answers as $answer)
		{
			$subcapability = $answer->indicator->subcapability;
			if (!isset($subcapabilitiesScores[$subcapability->id]))
				$subcapabilitiesScores[$subcapability->id] = [$answer->score];
			else
				$subcapabilitiesScores[$subcapability->id][] = $answer->score;
		}

		$capabilities = Capability::all();
		foreach ($capabilities as $capability)
			foreach ($capability->subcapabilities as $subcapability) {
				$subcapabilityScores = $subcapabilitiesScores[$subcapability->id];
				$subcapabilityAverage = array_sum($subcapabilityScores) / count($subcapabilityScores);

				$surveySubcapabilityScore = new SurveySubcapabilityScore();
				$surveySubcapabilityScore->score = $subcapabilityAverage;
				$surveySubcapabilityScore->survey_id = $survey->id;
				$surveySubcapabilityScore->subcapability_id = $subcapability->id;
				$surveySubcapabilityScore->school_id = $survey->school_id;
				$surveySubcapabilityScore->stakeholder_id = $survey->stakeholder_id;
				$surveySubcapabilityScore->save();

				if (isset($capabilityScores[$capability->id]))
					$capabilityScores[$capability->id] += $subcapabilityAverage / 5 * $subcapability->weight;
				else
					$capabilityScores[$capability->id] = $subcapabilityAverage / 5 * $subcapability->weight;
			}

		foreach ($capabilityScores as $key => $score) {
			$surveyScore = new  SurveyScore();
			$surveyScore->survey_id = $survey->id;
			$surveyScore->capability_id = $key;
			$surveyScore->score = $score;
			$surveyScore->school_id = $survey->school_id;
			$surveyScore->stakeholder_id = $survey->stakeholder_id;
			$surveyScore->save();
		}
	}
}
