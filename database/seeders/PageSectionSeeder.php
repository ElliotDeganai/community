<?php

namespace Database\Seeders;

use App\Models\PageSection;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        PageSection::truncate();

        $admin->pageSections()->saveMany(
            [
                new PageSection([
                    'name' => 'Products',
                    'description' => 'Product section',
                    'page_id' => 1
                ]),
                new PageSection([
                    'name' => 'They talk about us',
                    'description' => 'They talk about us video section',
                    'page_id' => 1
                ]),
                new PageSection([
                    'name' => 'Carousel',
                    'description' => 'Carousel section',
                    'page_id' => 1
                ]),
                new PageSection([
                    'name' => 'News',
                    'description' => 'News section',
                    'page_id' => 2
                ]),
                new PageSection([
                    'name' => 'Products',
                    'description' => 'Product section',
                    'page_id' => 3
                ]),
                new PageSection([
                    'name' => 'Free Download',
                    'description' => 'Free product section',
                    'page_id' => 4
                ]),
                new PageSection([
                    'name' => 'FAQ Section',
                    'description' => 'FAQ Section',
                    'page_id' => 5
                ]),
                new PageSection([
                    'name' => 'About Section',
                    'description' => 'About Section',
                    'page_id' => 6
                ]),
                new PageSection([
                    'name' => 'Product',
                    'description' => 'Product details section',
                    'page_id' => 7
                ]),
            ]
        );
    }
}
