<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyScore extends Model
{
    use HasFactory;

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

	public function capability()
	{
		return $this->belongsTo(Capability::class);
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
			$surveyScore->save();
		}
	}
}
