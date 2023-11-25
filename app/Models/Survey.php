<?php

namespace App\Models;

use App\Models\Scopes\SchoolScope;
use App\Traits\SchoolFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

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

	public function nextCapability(Capability $capability = null): ?Capability
	{
		$capabilityId = $capability ? $capability->id : 0;
		$capability = Capability::where('id', '>', $capabilityId)->orderBy('id')->first();
		if (!$capability)
			return null; //no more capabilities in the system

		$capability = (new OverrideCapability())->getModelOverrides(Collection::make([$capability]), $this->school_id, $this->stakeholder_id)->first();
		if (!$capability->is_visible)
			return $this->nextCapability($capability); //Capability should be hidden, go to next

		return $capability;
	}

	public function nextSubcapability(Capability $capability, Subcapability $subcapability = null)
	{
		$subcapabilityId = $subcapability ? $subcapability->id : 0;
		$subcapability = Subcapability::where('id', '>', $subcapabilityId)
			->whereCapabilityId($capability->id)
			->orderBy('id')->first();
		if (!$subcapability) {
			$capability = $this->nextCapability($capability);
			if (!$capability)
				return null;
			return $this->nextSubcapability($capability);
		}

		$subcapability = (new OverrideCapability())
			->getModelOverrides(Collection::make([$subcapability]), $this->school_id, $this->stakeholder_id)->first();
		if (!$subcapability->is_visible)
			return $this->nextSubcapability($capability, $subcapability);

		return $subcapability;
	}

	public function nextIndicator(Subcapability $subcapability, Indicator $indicator = null)
	{
		$indicatorId = $indicator ? $indicator->id : 0;
		$indicator = Indicator::where('id', '>', $indicatorId)
			->whereSubcapabilityId($subcapability->id)
			->orderBy('id')->first();
		if (!$indicator) {
			$subcapability = $this->nextSubcapability($subcapability->capability, $subcapability);
			if (!$subcapability)
				return null;
			return $this->nextIndicator($subcapability);
		}

		$indicator = (new OverrideCapability())
			->getModelOverrides(Collection::make([$indicator]), $this->school_id, $this->stakeholder_id)->first();
		if (!$indicator->is_visible)
			return $this->nextIndicator($subcapability, $indicator);

		return $indicator;
	}

	public function setNextIndicator()
	{
		$indicator = $this->getNextIndicator();
		if (is_null($indicator))
		{
			$schoolCapabilityScore = new SurveyScore();
			$schoolCapabilityScore->generateScores($this);
			$this->save();
		}
		$this->indicator_id = $indicator->id;
		$this->save();
	}

	public function initialize()
	{
		$capability = $this->nextCapability();
		$subcapability = $this->nextSubcapability($capability);
		$this->indicator_id = $this->nextIndicator($subcapability)->id;
	}
}
