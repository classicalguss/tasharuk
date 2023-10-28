<?php

namespace App\Models;

use App\Overridable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubCapability
 *
 * @property int $id
 * @property string $text
 * @property int $capability_id
 * @property float $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability whereCapabilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subcapability whereWeight($value)
 * @mixin \Eloquent
 */
class Subcapability extends Model
{
    use HasFactory;
	protected $fillable = [
		'capability_id',
		'name',
		'weight',
		'is_visible'
	];

	public function capability() {
		return $this->belongsTo(Capability::class);
	}

	public function indicators() {
		return $this->hasMany(Indicator::class);
	}

	protected static function booted(): void
	{
		static::deleted(function (Subcapability $subcapability) {
			Indicator::whereSubcapabilityId($subcapability->id)->delete();
		});
	}
}
