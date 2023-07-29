<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\DocValue;
use App\Models\User;

class DocValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        DocValue::truncate();
        new DocValue([
            'value_text' => 'Mentions Légales',
            'post_id' => $admin->id,
            'user_id' => $admin->id,
            'category_id' => 6
        ])



    }
}
