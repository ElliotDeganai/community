<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $admin = User::find(1);

            Category::truncate();

            $admin->pages()->saveMany(
                [
/*                     new Category([
                        'name' => 'Country',
                        'description' => 'The country.',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'Activity',
                        'description' => 'The activities for a country.',
                        'user_id' => $admin->id,
                        'category_id' => 1
                    ]),
                    new Category([
                        'name' => 'Places',
                        'description' => 'The best places in the country.',
                        'user_id' => $admin->id,
                        'category_id' => 1
                    ]),
                    new Category([
                        'name' => 'Test',
                        'description' => '',
                        'user_id' => $admin->id
                    ]), */
                    new Category([
                        'name' => 'Footers',
                        'description' => '',
                        'type' => 'settings',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'Contact Forms',
                        'description' => '',
                        'type' => 'contacts',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'Text',
                        'description' => '',
                        'type' => 'settings',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'VST Product',
                        'description' => 'VST product to be sold',
                        'type' => 'custom',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'Free Download',
                        'description' => 'Free download page',
                        'type' => 'custom',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'News',
                        'description' => 'News to display on the blog',
                        'type' => 'custom',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'They talk about us',
                        'description' => 'They talk about us',
                        'type' => 'custom',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'FAQ',
                        'description' => 'FAQ',
                        'type' => 'custom',
                        'user_id' => $admin->id
                    ]),
                    new Category([
                        'name' => 'About',
                        'description' => 'About us',
                        'type' => 'custom',
                        'user_id' => $admin->id
                    ])
                ]
            );
        }
}}
