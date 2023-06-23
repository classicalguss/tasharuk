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
		'new_value'
	];
}
