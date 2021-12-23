<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new User();
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('123456789');
        $admin->is_admin = true;
        $admin->save();

    }
}
