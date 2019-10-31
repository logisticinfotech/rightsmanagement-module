<?php

namespace Modules\RightsManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\RightsManagement\Entities\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class MakeSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleInput = [
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
            'description' => 'Super Admin'
        ];
        $roleExists = Role::where('name', $roleInput['name'])->exists();

        if (!$roleExists) {
            $this->command->info("Creating role for Super Admin...");
            Role::create($roleInput);
            $this->command->info("Role Created!!!");
        } else {
            $this->command->info("Role exists for Super Admin.");
        }

        $admin = Admin::role($roleInput['name'])->get();

        if (!$admin->count()) {

            $userInput = [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456')
            ];

            $user = Admin::where('email', $userInput['email'])->first();
            if (!$user) {
                $this->command->info("Adding Super Admin...");
                $user = Admin::create($userInput);
                $this->command->info("Super Admin Added!!!");
            } else {
                $this->command->info("Super Admin already exits");
            }
            $user->assignRole($roleInput['name']);
        } else {
            $this->command->info("Super Admin Exists.");
        }
    }
}
