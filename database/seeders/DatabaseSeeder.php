<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TariffsSeeder::class,
            UserAdminSeeder::class,
        ]);
        \App\Models\User::factory(100)->create();

    }
}
