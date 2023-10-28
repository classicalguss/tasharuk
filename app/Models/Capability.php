<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Capability
 *
 * @property int $id
 * @property string $name
 * @property float $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Capability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Capability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Capability query()
 * @method static \Illuminate\Database\Eloquent\Builder|Capability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Capability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Capability whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Capability whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Capability whereWeight($value)
 * @mixin \Eloquent
 */
class Capability extends Model
{
    use HasFactory;
	protected $fillable = [
		'name',
		'weight',
		'is_visible'
	];

	protected static function booted(): void
	{
		static::deleted(function (Capability $capability) {
			$subcapabilityIds = Subcapability::where('capability_id')->get()->pluck('id');
			Indicator::whereIn('subcapability_id', $subcapabilityIds)->delete();
			Subcapability::whereCapabilityId($capability->id)->delete();
			SurveyCapabilityScore::whereCapabilityId($capability->id)->delete();
		});
	}

	public function subcapabilities()
	{
		return $this->hasMany(Subcapability::class);
	}
}
