<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Indicator
 *
 * @property int $id
 * @property string $text
 * @property int $sub_capability_id
 * @property float $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator whereSubCapabilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indicator whereWeight($value)
 * @mixin \Eloquent
 */
class Indicator extends Model
{
    use HasFactory;
	protected $fillable = [
		'text',
		'highly_effective',
		'effective',
		'satisfactory',
		'needs_improvement',
		'does_not_meet_standard',
		'subcapability_id',
		'is_visible'
	];

	public function subcapability()
	{
		return $this->belongsTo(Subcapability::class);
	}
}
