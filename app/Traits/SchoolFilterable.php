<?php

namespace App\Traits;

use App\Models\Scopes\SchoolScope;

trait SchoolFilterable
{
	protected static function booted()
	{
		if (request()->get('school_id')) {
			static::addGlobalScope(new SchoolScope(request()->get('school_id')));
		}
		if (request()->post('school_id')) {
			static::addGlobalScope(new SchoolScope(request()->post('school_id')));
		}
	}
}