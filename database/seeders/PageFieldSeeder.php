<?php

namespace Database\Seeders;

use App\Models\PageField;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        PageField::truncate();

        $admin->pageFields()->saveMany(
            [
                new PageField([
                    'name' => 'Product Name',
                    'description' => 'Product Name',
                    'page_section_id' => 1
                ]),
                new PageField([
                    'name' => 'Product Price',
                    'description' => 'Product price',
                    'page_section_id' => 1
                ]),
                new PageField([
                    'name' => 'Product Image',
                    'description' => 'Product image',
                    'page_section_id' => 1
                ]),
                new PageField([
                    'name' => 'Video Name',
                    'description' => 'Video Name',
                    'page_section_id' => 2
                ]),
                new PageField([
                    'name' => 'Video URL',
                    'description' => 'Video URL',
                    'page_section_id' => 2
                ]),
                new PageField([
                    'name' => 'Product Name',
                    'description' => 'Product Name',
                    'page_section_id' => 3
                ]),
                new PageField([
                    'name' => 'Product Description',
                    'description' => 'Product Description',
                    'page_section_id' => 3
                ]),
                new PageField([
                    'name' => 'Product Image',
                    'description' => 'Product Image',
                    'page_section_id' => 3
                ]),
                new PageField([
                    'name' => 'Product Price',
                    'description' => 'Product Price',
                    'page_section_id' => 3
                ]),
                new PageField([
                    'name' => 'News Name',
                    'description' => 'News Name',
                    'page_section_id' => 4
                ]),
                new PageField([
                    'name' => 'News Description',
                    'description' => 'News Description',
                    'page_section_id' => 4
                ]),
                new PageField([
                    'name' => 'News Image',
                    'description' => 'News Image',
                    'page_section_id' => 4
                ]),
                new PageField([
                    'name' => 'News URL',
                    'description' => 'News URL',
                    'page_section_id' => 4
                ]),
                new PageField([
                    'name' => 'Product Name',
                    'description' => 'Product Name',
                    'page_section_id' => 5
                ]),
                new PageField([
                    'name' => 'Product Description',
                    'description' => 'Product Description',
                    'page_section_id' => 5
                ]),
                new PageField([
                    'name' => 'Product Image',
                    'description' => 'Product Image',
                    'page_section_id' => 5
                ]),
                new PageField([
                    'name' => 'Product Price',
                    'description' => 'Product Price',
                    'page_section_id' => 5
                ]),
                new PageField([
                    'name' => 'Free Download Name',
                    'description' => 'Free Download Name',
                    'page_section_id' => 6
                ]),
                new PageField([
                    'name' => 'Free Download Description',
                    'description' => 'Free Description',
                    'page_section_id' => 6
                ]),
                new PageField([
                    'name' => 'Free Download Image',
                    'description' => 'Free Download Image',
                    'page_section_id' => 6
                ]),
                new PageField([
                    'name' => 'Free Download URL',
                    'description' => 'Free Download URL',
                    'page_section_id' => 6
                ]),
                new PageField([
                    'name' => 'FAQ Name',
                    'description' => 'FAQ Name',
                    'page_section_id' => 7
                ]),
                new PageField([
                    'name' => 'FAQ Description',
                    'description' => 'FAQ Description',
                    'page_section_id' => 7
                ]),
                new PageField([
                    'name' => 'About Name',
                    'description' => 'About Name',
                    'page_section_id' => 8
                ]),
                new PageField([
                    'name' => 'About Description',
                    'description' => 'About Description',
                    'page_section_id' => 8
                ]),
                new PageField([
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
                ]),
            ]);
        //
    }
}
