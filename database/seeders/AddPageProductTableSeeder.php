<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageField;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddPageProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        //PageSection::truncate();

/*         $admin->pages()->saveMany(
            [
                new Page([
                    'title' => 'Product',
                    'url' => '/product',
                    'description' => 'Page for the product details',
                    'user_id' => 1
                ])
            ]
        );

        $admin->pageSections()->saveMany(
            [
                new PageSection([
                    'name' => 'Product',
                    'description' => 'Product details section',
                    'page_id' => 7
                ]),
            ]
        ); */

        $admin->pageFields()->saveMany(
            [
/*                 new PageField([
                    'name' => 'Product Name',
                    'description' => 'Product Name',
                    'page_section_id' => 9
                ]),
                new PageField([
                    'name' => 'Product Description',
                    'description' => 'Product Description',
                    'page_section_id' => 9
                ]),
                new PageField([
                    'name' => 'Product Image',
                    'description' => 'Product Image',
                    'page_section_id' => 9
                ]),
                new PageField([
                    'name' => 'Product Price',
                    'description' => 'Product Price',
                    'page_section_id' => 9
                ]), */
                new PageField([
                    'name' => 'Product Long Description',
                    'description' => 'Product Long Description',
                    'page_section_id' => 9
                ]),
                new PageField([
                    'name' => 'Product Audio',
                    'description' => 'Product Audio',
                    'page_section_id' => 9
                ]),
            ]);
    }
}
