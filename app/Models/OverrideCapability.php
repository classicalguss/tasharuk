<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

	public function getModelOverrides(string $updatedModel, int $schoolId, int $stakeholderId)
	{
		return OverrideCapability::where([
			'updated_model' => $updatedModel,
		])
			->whereIn('stakeholder_id', [$stakeholderId, 0])
			->whereIn('school_id', [$schoolId, 0])
			->orderBy('school_id')->orderBy('stakeholder_id')->get();
	}
}
