<?php

namespace App\Models;

use App\Traits\SchoolFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolStakeholderWeight extends Model
{
    use HasFactory, SchoolFilterable;
	public $guarded = ['id'];

	public static function getStakeholderWeights() {
		$stakeholderWeights = SchoolStakeholderWeight::get();
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
		return $stakeholders;
	}
}
