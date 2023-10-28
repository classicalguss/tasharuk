<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class OverrideCapability extends Model
{
    use HasFactory;
	protected $fillable = [
		'updated_model',
		'updated_column',
		'foreign_id',
		'stakeholder_id',
		'school_id',
		'new_value'
	];

	public static function getAllVisibilityOverrides(int $schoolId, int $stakeholderId)
	{
		return OverrideCapability::whereUpdatedColumn('is_visible')
			->whereIn('stakeholder_id', [$stakeholderId, 0])
			->whereIn('school_id', [$schoolId, 0])
			->orderBy('school_id')->orderBy('stakeholder_id')->get();
	}

	public function getModelOverrides(Collection $models, int $schoolId, int $stakeholderId)
	{
		$objectName = Str::lower((new \ReflectionClass($models[0]))->getShortName());
		$allOverrides = OverrideCapability::where([
			'updated_model' => $objectName,
		])
			->whereIn('stakeholder_id', [$stakeholderId, 0])
			->whereIn('school_id', [$schoolId, 0])
			->orderBy('school_id')->orderBy('stakeholder_id')->get();
		$allOverrides = $allOverrides->groupBy('foreign_id');
		foreach ($models as $model) {
			if (isset($allOverrides[$model->id])) {
				$overrides = $allOverrides[$model->id];
				foreach ($overrides as $override) {
					$updatedColumn = $override->updated_column;
					$newValue = $override->new_value;
					if (ctype_digit($newValue))
						$newValue = (int)$newValue;
					$model->$updatedColumn = $newValue;
				}
			}
		}
		return $models;
	}
}
