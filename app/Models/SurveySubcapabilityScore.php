<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySubcapabilityScore extends Model
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
}
