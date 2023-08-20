<?php

namespace App\Models;

use App\Models\Scopes\SchoolScope;
use App\Traits\SchoolFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory, SchoolFilterable;
	public function school() {
		return $this->belongsTo(School::class);
	}
	public function stakeholder() {
		return $this->belongsTo(Stakeholder::class);
	}

	public function answers()
	{
		return $this->hasMany(SurveyAnswer::class);
	}

	public function indicator() {
		return $this->belongsTo(Indicator::class);
	}

	protected $casts = [
		'created_at' => 'datetime:Y-m-d H:i',
	];

	public static function generateInvitationToken($email) {
		return substr(md5(rand(0, 9) . $email . time()), 0, 32);
	}

	public function currentCapability()
	{
		return Capability::where('id', '>', $this->indicator->subcapability->capability_id)->first();
	}

	public function currentSubcapability($capabilityId, $first = false)
	{
		$builder = Subcapability::where([
			'capability_id' => $capabilityId
		]);
		if ($first)
			$builder->where('id', '>', 0);
		else
			$builder->where('id', '>', $this->indicator->subcapability_id);
		return $builder->first();
	}

	public static function getFirstCapability(School $school, Stakeholder $stakeholder) {

		$overrides = OverrideCapability::where([
			'updated_model' => 'capability',
		])
			->whereIn('stakeholder_id', [$stakeholder->id, 0])
			->whereIn('school_id', [$school->id, 0])
			->whereT
			->orderBy('school_id')->orderBy('stakeholder_id')->get();
	}

	public function currentIndicator($subcapabilityId, $first = false)
	{
		$builder = Indicator::where([
			'subcapability_id' => $subcapabilityId,
		]);
		if ($first)
			$builder->where('id', '>', 0);
		else
			$builder->where('id', '>', $this->indicator_id);
		return $builder->first();
	}

	public function getNextIndicator()
	{
		$indicator = $this->currentIndicator($this->indicator->subcapability_id);
		if (!$indicator) {
			$subcapability = $this->currentSubcapability($this->indicator->subcapability->capability_id);
			if (!$subcapability) {
				$capability = $this->currentCapability();
				if (!$capability)
				{
					$schoolScore = new SurveyScore();
					$schoolScore->generateScores($this);
					$this->status = 'completed';
					$this->completed_at = now();
					$this->save();
					return;
				}
				$subcapability = $this->currentSubcapability($capability->id, true);
			}
			$indicator = $this->currentIndicator($subcapability->id, true);
		}
		$this->indicator_id = $indicator->id;
		$this->save();
	}
}
