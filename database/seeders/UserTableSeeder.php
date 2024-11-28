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
            'password' => bcrypt('password'),
            ///'team' => 'paris'
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@laracms.fr',
            'password' => bcrypt('password'),
            //'team' => 'paris'
        ]);

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@laracms.fr',
            'password' => bcrypt('password'),
            //'team' => 'paris'
        ]);

        $elliot = User::create([
            'name' => 'Elliot',
            'email' => 'edeganai@gmail.com',
            'password' => bcrypt("password"),
            //'team' => 'paris'0
        ]);

        $soifia = User::create([
            'name' => 'Soifia',
            'email' => 'atikisoifia@gmail.com',
            'password' => bcrypt('password'),
            //'team' => 'paris'
        ]);

        $client2 = User::create([
            'name' => 'Edwige',
            'email' => 'edwigedeganai@hotmail.com',
            'password' => bcrypt("password"),
            //'team' => 'paris'
        ]);

        $client3 = User::create([
            'name' => 'Escola',
            'email' => 'escolad@hotmail.fr',
            'password' => bcrypt("password")
        ]);

        /*$client4 = User::create([
            'name' => 'Eric',
            'email' => 'ericdeganai@gmail.com',
            'password' => bcrypt('b,xW(raFd.]{Ncn*B2;}yS')
        ]);

        $client5 = User::create([
            'name' => 'Evrard',
            'email' => 'evrard-deganai@orange.fr',
            'password' => bcrypt('Tn3AVG&;>c6:[p/v.hk_4`')
        ]);

        $client6 = User::create([
            'name' => 'Karine',
            'email' => 'feikofil@hotmail.fr',
            'password' => bcrypt('GKW,fH-q7?"{sEvD_3ac$[')
        ]);

        $client7 = User::create([
            'name' => 'Cécilia',
            'email' => 'cecilia-ouato@live.fr',
            'password' => bcrypt('cq;@}&:SaQv7~5]2fDu%yG')
        ]);

        $client8 = User::create([
            'name' => 'Jennifer',
            'email' => 'ouato-jennifer@live.fr',
            'password' => bcrypt('N%A8(uPY.fWEZjF*)sx[`g')
        ]);

        $client9 = User::create([
            'name' => 'Patrick',
            'email' => 'Axel.ouato@gmail.com',
            'password' => bcrypt("L'~Ga./:PBcK^bQ+%sr7fC")
        ]); */
/*
        $client9 = User::create([
            'name' => 'Han M',
            'email' => 'henri.meiche@gmail.com',
            'password' => bcrypt('!HanPIrI56G48TD'),
            'team' => 'paris'
        ]);

        $client10 = User::create([
            'name' => 'Leah',
            'email' => 'leahb90@hotmail.com',
            'password' => bcrypt('^@8*EOsC17vlF16'),
            'team' => 'swiss'
        ]);

        $client11 = User::create([
            'name' => 'You',
            'email' => 'you.bocoum@gmail.com',
            'password' => bcrypt('enOeW36Fni3GE8%'),
            'team' => 'paris'
        ]);

        $client12 = User::create([
            'name' => 'Clélia',
            'email' => 'bonin.clelia.janis@gmail.com',
            'password' => bcrypt('J9X&e*n*0VFOo1%'),
            'team' => 'lux'
        ]);

        $client13 = User::create([
            'name' => 'Ben',
            'email' => 'Benjamin.telga@gmail.com',
            'password' => bcrypt('wWMf2qFc610Q4!p'),
            'team' => 'lux'
        ]); */
        $dev->roles()->attach($devRole);
        $admin->roles()->attach($adminRole);
        $editor->roles()->attach($editorRole);
        $elliot->roles()->attach($editorRole);
        $soifia->roles()->attach($editorRole);
          $client2->roles()->attach($editorRole);
        $client3->roles()->attach($editorRole);
        /*$client4->roles()->attach($editorRole);
        $client5->roles()->attach($editorRole);
        $client6->roles()->attach($editorRole);
        $client7->roles()->attach($editorRole);
        $client8->roles()->attach($editorRole);
        $client9->roles()->attach($editorRole); */
/*         $client10->roles()->attach($clientRole);
        $client11->roles()->attach($clientRole);
        $client12->roles()->attach($clientRole);
        $client13->roles()->attach($clientRole); */
    }
}
