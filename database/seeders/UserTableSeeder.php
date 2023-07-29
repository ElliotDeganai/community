<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devRole = Role::where('name', 'dev')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $clientRole = Role::where('name', 'client')->first();

        User::truncate();

        $dev = User::create([
            'name' => 'Dev',
            'email' => 'dev@laracms.fr',
            'password' => bcrypt('password')
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@laracms.fr',
            'password' => bcrypt('password')
        ]);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@laracms.fr',
            'password' => bcrypt('password')
        ]);

        $client = User::create([
            'name' => 'Client',
            'email' => 'client@laracms.fr',
            'password' => bcrypt('password')
        ]);
        $dev->roles()->attach($devRole);
        $admin->roles()->attach($adminRole);
        $editor->roles()->attach($editorRole);
        $client->roles()->attach($clientRole);
    }
}
