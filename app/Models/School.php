<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_ar
 * @property string $students_number_range
 * @property string $logo
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SchoolFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereStudentsNumberRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereUpdatedAt($value)
 * @property int $owner_id
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|School whereOwnerId($value)
 * @mixin \Eloquent
 */
class School extends Model
{
    use HasFactory;

	public function owner() {
		return $this->hasOne(User::class, 'id', 'owner_id');
	}

	public function users() {
		return $this->hasMany(User::class);
	}

	public function admins() {
		return $this->users()->whereRelation('roles', 'name', '=', 'School Admin')
			->orWhereRelation('roles', 'name', '=', 'Admin');
	}
}
