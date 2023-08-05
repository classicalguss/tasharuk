<?php

namespace App\Traits;

trait SchoolFilterable
{
	protected static function booted()
	{
		static::addGlobalScope(new AgeScope);
	}
}