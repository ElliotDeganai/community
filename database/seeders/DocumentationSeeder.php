<?php

namespace Database\Seeders;

use App\Models\Documentation;
use App\Models\User;
use Faker\Documentor;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        Documentation::truncate();

        $admin->pages()->saveMany(
            [
/*                 new Documentation([
                    'name' => 'Name',
                    'description' => 'The country name',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 1
                ]),
                new Documentation([
                    'name' => 'Summary',
                    'description' => 'The country summary',
                    'type' => 'html',
                    'user_id' => $admin->id,
                    'category_id' => 1
                ]),
                new Documentation([
                    'name' => 'Population',
                    'description' => 'The country population',
                    'type' => 'numeric',
                    'user_id' => $admin->id,
                    'category_id' => 1
                ]),
                new Documentation([
                    'name' => 'Independance',
                    'description' => 'The independance day',
                    'type' => 'date',
                    'user_id' => $admin->id,
                    'category_id' => 1
                ]),
                new Documentation([
                    'name' => 'Test image',
                    'description' => 'test image',
                    'type' => 'image',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]),
                new Documentation([
                    'name' => 'Test gallery',
                    'description' => 'test',
                    'type' => 'gallery',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]),
                new Documentation([
                    'name' => 'Test carousel',
                    'description' => 'test',
                    'type' => 'carousel',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]), */
                new Documentation([
                    'name' => 'Subject',
                    'description' => 'Subject',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 3
                ]),
                new Documentation([
                    'name' => 'Body',
                    'description' => 'Body',
                    'type' => 'html',
                    'user_id' => $admin->id,
                    'category_id' => 3
                ]),
                new Documentation([
                    'name' => 'Send_to',
                    'description' => 'Receiving email',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 3
                ]),
                new Documentation([
                    'name' => 'From_to',
                    'description' => 'From to email',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 3
                ]),
                new Documentation([
                    'name' => 'Title',
                    'description' => 'Title',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 1
                ]),
                new Documentation([
                    'name' => 'Body',
                    'description' => 'Body',
                    'type' => 'html',
                    'user_id' => $admin->id,
                    'category_id' => 1
                ]),
                new Documentation([
                    'name' => 'Site Title',
                    'description' => 'Site Title',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 2
                ]),
                new Documentation([
                    'name' => 'Logo',
                    'description' => 'Site logo on the footer',
                    'type' => 'image',
                    'user_id' => $admin->id,
                    'category_id' => 2
                ]),
                new Documentation([
                    'name' => 'Name',
                    'description' => 'Product name',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]),
                new Documentation([
                    'name' => 'Description',
                    'description' => 'Product description',
                    'type' => 'html',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]),
                new Documentation([
                    'name' => 'Image',
                    'description' => 'The product image',
                    'type' => 'image',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]),
                new Documentation([
                    'name' => 'Price',
                    'description' => 'The product price',
                    'type' => 'price',
                    'user_id' => $admin->id,
                    'category_id' => 4
                ]),
                new Documentation([
                    'name' => 'Name',
                    'description' => 'The video name',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 7
                ]),
                new Documentation([
                    'name' => 'URL',
                    'description' => 'The video url',
                    'type' => 'text',
                    'user_id' => $admin->id,
                    'category_id' => 7
                ])
            ]
        );
    }
}
