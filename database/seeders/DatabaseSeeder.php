<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App;
use App\Models\School;
use App\Models\User;
use App\Models\WebsiteMetrics;
use Database\Factories\SchoolFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
		DB::table('schools')->truncate();
		DB::table('users')->truncate();
		DB::table('model_has_permissions')->truncate();
		DB::table('model_has_roles')->truncate();
		DB::table('permissions')->truncate();
		DB::table('role_has_permissions')->truncate();
		DB::table('roles')->truncate();
		$superAdminUser = User::create([
			'name' => 'Mohammed Yousef',
			'email' => 'mohammed.yousef@tasharuk.com',
			'email_verified_at' => now(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'two_factor_secret' => null,
			'two_factor_recovery_codes' => null,
			'remember_token' => Str::random(10),
			'profile_photo_path' => null,
			'school_id' => 1,
		]);
		$adminUser = User::create([
			'name' => 'Ghassan Barghouti',
			'email' => 'barghouti_since88@hotmail.com',
			'email_verified_at' => now(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'two_factor_secret' => null,
			'two_factor_recovery_codes' => null,
			'remember_token' => Str::random(10),
			'profile_photo_path' => null,
			'school_id' => 1,
		]);
		$adminSchool = School::create([
			'name' => 'Tasharuk',
			'owner_id' => $superAdminUser->id
		]);
		$superAdminRole = Role::create(['name' => 'Super Admin']);
		$adminRole = Role::create(['name' => 'Admin']);

		$superAdminPermission = Permission::create(['name' => 'Add super admin']);
		$adminPermission = Permission::create(['name' => 'Add school']);

		$superAdminRole->syncPermissions([$superAdminPermission, $adminPermission]);
		$adminRole->syncPermissions([$superAdminPermission]);

		$superAdminUser->assignRole($superAdminRole);
		$adminUser->assignRole($adminRole);

		if (App::environment('local')) {
			$ownerUsers = User::factory(25)
				->sequence(fn (Sequence $sequence) => ['school_id' => ($sequence->index % 25) + 1])
				->create();

			$minId = $ownerUsers[0]->id;
			School::factory(25)
				->sequence(fn (Sequence $sequence) => ['owner_id' => $sequence->index+$minId])
				->create();
		}

		$schoolAdminRole = Role::create(['name' => 'School Owner']);
		$adminRole = Role::create(['name' => 'School Admin']);
		$studentRole = Role::create(['name' => 'Student']);
		$schoolAdminPermission = Permission::create(['name' => 'Add school admin']);
		$schoolAdminRole->syncPermissions([$schoolAdminPermission]);
		if (App::environment('local')) {
			foreach ($ownerUsers as $ownerUser) {
				$ownerUser->assignRole($schoolAdminRole);
				$ownerUser->save();
			}
			$otherAdmins = User::factory(50)->create();
			foreach ($otherAdmins as $admin) {
				$admin->assignRole($adminRole);
			}

			$normalUsers = User::factory(100)->create();
			foreach ($normalUsers as $admin) {
				$admin->assignRole($studentRole);
			}
		}

		$websiteMetrics = new WebsiteMetrics();
		$websiteMetrics->num_of_visitors = 0;
		$websiteMetrics->save();

		DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}