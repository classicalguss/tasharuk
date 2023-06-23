<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
	public function school() {
		return $this->belongsTo(School::class);
	}
	public function stakeholder() {
		return $this->belongsTo(Stakeholder::class);
	}

	public function capability() {
		return $this->belongsTo(Capability::class);
	}

	public function subcapability() {
		return $this->belongsTo(Subcapability::class);
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
}
