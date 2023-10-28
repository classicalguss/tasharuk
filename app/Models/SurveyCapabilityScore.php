<?php

namespace App\Models;

use App\Traits\SchoolFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyCapabilityScore extends Model
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
			$average = SurveyCapabilityScore::whereStakeholderId($stakeholder->id)->pluck('score')->average() / 100;
			$overallScore += $average * $stakeholder['weight'];
		}

		return round($overallScore);
	}


}
