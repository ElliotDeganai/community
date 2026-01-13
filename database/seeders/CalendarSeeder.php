<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('roles')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'client');
            })
            ->get();

        foreach ($users as $user) {
            if (!$user->isClient()) {
                Calendar::create([
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
