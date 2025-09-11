<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\info;
use function Laravel\Prompts\table;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminUser = [
            'first_name'     => 'Super',
            'middle_name'    => 'Admin',
            'last_name'      => 'Admin',
            'full_name'      => 'Super Admin',
            'username'       => 'Super Admin',
            'email'          => 'superadmin@gmail.com',
            'password'       => bcrypt('12345678'),
            'mobile_number'  => '1234567890',
            'department'     => 'Super Admin',
            'status'         => 1,
        ];

        // Create or update super admin user using DB::table to avoid enum casting issues
        $existingUser = DB::table('users')->where('email', $superAdminUser['email'])->first();
        
        if ($existingUser) {
            DB::table('users')->where('email', $superAdminUser['email'])->update($superAdminUser);
            $superAdminUser = User::where('email', $superAdminUser['email'])->first();
        } else {
            $superAdminUser['created_at'] = now();
            $superAdminUser['updated_at'] = now();
            $userId = DB::table('users')->insertGetId($superAdminUser);
            $superAdminUser = User::find($userId);
        }

        // Get or create role
        $role = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'web']
        );

        // Attach all permissions
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        // Assign role to super admin
        $superAdminUser->assignRole($role);

        // Verify email
        DB::table('users')->where('id', $superAdminUser->id)->update([
            'email_verified_at' => now()
        ]);

        $action = $superAdminUser->wasRecentlyCreated ? 'created' : 'updated';
        info("Super Admin user {$action} successfully.");

        table([
            ['Name', $superAdminUser->first_name . ' ' . $superAdminUser->last_name],
            ['Email', $superAdminUser->email],
            ['Password', '12345678'],
        ]);
    }
}