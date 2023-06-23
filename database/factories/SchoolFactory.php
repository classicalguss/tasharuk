<?php

namespace Database\Factories;

use Bezhanov\Faker\ProviderCollectionHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$faker = \Faker\Factory::create();
		ProviderCollectionHelper::addAllProvidersTo($faker);
		$name = $faker->secondarySchool;
		return [
			'name' => $name,
			'name_ar' => '',
			'logo' => '',
			'students_number_range' => '5000',
			'country' => $faker->countryCode,
		];
    }
}
