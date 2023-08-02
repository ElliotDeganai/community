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
            'name' => 'Developper',
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

        $client1 = User::create([
            'name' => 'Client',
            'email' => 'client@laracms.fr',
            'password' => bcrypt('password')
        ]);

        $client2 = User::create([
            'name' => 'Elliot',
            'email' => 'edeganai@gmail.com',
            'password' => bcrypt('Hw5R7XQ7!5c8r#p')
        ]);

        $client3 = User::create([
            'name' => 'Soifia',
            'email' => 'atikisoifia@gmail.com',
            'password' => bcrypt('QHB1t!%54CD8mku')
        ]);

        $client4 = User::create([
            'name' => 'Luc',
            'email' => 'Veu.lucie@yahoo.com',
            'password' => bcrypt('kR2L43!B%HP^ge^')
        ]);

        $client5 = User::create([
            'name' => 'Papa Polka',
            'email' => 'aurelienbkc@gmail.com',
            'password' => bcrypt('@O*Jav2q86ec7Jh')
        ]);

        $client6 = User::create([
            'name' => 'Julie meu amor',
            'email' => 'Juliebenhamou1987@gmail.com',
            'password' => bcrypt('!%3YY%6iD%e8Z&8')
        ]);

        $client7 = User::create([
            'name' => 'Julia',
            'email' => 'jparanhos0@gmail.com',
            'password' => bcrypt('73P759T2lTvm^El')
        ]);

        $client8 = User::create([
            'name' => 'Debora',
            'email' => 'deboracarvalhopinto@gmail.com',
            'password' => bcrypt('*2FqX7ak06Q6r##')
        ]);

        $client9 = User::create([
            'name' => 'Han M',
            'email' => 'henri.meiche@gmail.com',
            'password' => bcrypt('!HanPIrI56G48TD')
        ]);

        $client10 = User::create([
            'name' => 'Leah',
            'email' => 'leahb90@hotmail.com',
            'password' => bcrypt('^@8*EOsC17vlF16')
        ]);

        $client11 = User::create([
            'name' => 'You',
            'email' => 'you.bocoum@gmail.com',
            'password' => bcrypt('enOeW36Fni3GE8%')
        ]);

        $client12 = User::create([
            'name' => 'Clélia',
            'email' => 'bonin.clelia.janis@gmail.com',
            'password' => bcrypt('J9X&e*n*0VFOo1%')
        ]);

        $client13 = User::create([
            'name' => 'Ben',
            'email' => 'Benjamin.telga@gmail.com',
            'password' => bcrypt('wWMf2qFc610Q4!p')
        ]);
        $dev->roles()->attach($devRole);
        $admin->roles()->attach($adminRole);
        $editor->roles()->attach($editorRole);
        $client1->roles()->attach($clientRole);
        $client2->roles()->attach($clientRole);
        $client3->roles()->attach($clientRole);
        $client4->roles()->attach($clientRole);
        $client5->roles()->attach($clientRole);
        $client6->roles()->attach($clientRole);
        $client7->roles()->attach($clientRole);
        $client8->roles()->attach($clientRole);
        $client9->roles()->attach($clientRole);
        $client10->roles()->attach($clientRole);
        $client11->roles()->attach($clientRole);
        $client12->roles()->attach($clientRole);
        $client13->roles()->attach($clientRole);
    }
}
