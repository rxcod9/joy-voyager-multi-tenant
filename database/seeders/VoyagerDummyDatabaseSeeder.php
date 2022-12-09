<?php

namespace Database\Seeders;

use Database\Seeders\DomainsTableSeeder;
use Database\Seeders\TenantsTableSeeder;
use Illuminate\Database\Seeder;

class VoyagerDummyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            PagesTableSeeder::class,
            TranslationsTableSeeder::class,
            TenantsTableSeeder::class,
            DomainsTableSeeder::class,
            PermissionRoleTableSeeder::class,
        ]);
    }
};
