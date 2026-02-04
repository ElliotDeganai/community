<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parameters;

class ParametersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parameters::create([
            'site_name'       => 'ED Community',
            'email'           => 'contact@ed-factory.com',
            'phone'           => '+41 76 284 45 43 / +33 6 16 21 14 47',
            'mobile'          => '+41 76 284 45 43 / +33 6 16 21 14 47',
            'city'            => 'Nyon',
            'postal_code'     => '1260',
            'country'         => 'Suisse',
            'logo'            => 'logos/logo.png'
        ]);
    }
}
