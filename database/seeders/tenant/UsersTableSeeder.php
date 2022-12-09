<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $role = Role::where('name', 'admin')->firstOrFail();

            User::create([
                'name'           => tenant('name') ?? 'Admin',
                'email'          => Str::slug(tenant('slug')) . '-' . config('seed.admin.email', 'admin@admin.com'),
                'password'       => bcrypt(config('seed.admin.password', 'password')),
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
            ]);
        }
    }
};
