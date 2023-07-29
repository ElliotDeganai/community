<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        Post::truncate();

        $admin->posts()->saveMany(
            [
/*                 new Post([
                   'name' => 'France',
                   'slug' => 'france',
                   'excerpt' => 'This is the country 1 excerpt',
                   'body' => 'This is the france.',
                   'category_id' => 1,
                   'user_id' => $admin->id
               ]),
               new Post([
                   'name' => 'Italy',
                   'slug' => 'italie',
                   'excerpt' => 'This is the country 2 excerpt',
                   'body' => 'This is the Italy.',
                   'category_id' => 1,
                   'user_id' => $admin->id
               ]), */
/*                new Post([
                  'name' => 'Product 1',
                  'slug' => 'product-1',
                  'excerpt' => 'This is the product 1 excerpt',
                  'body' => 'The 1st product',
                  'category_id' => 4,
                  'user_id' => $admin->id
              ]),
              new Post([
                  'name' => 'Product 2',
                  'slug' => 'product 2',
                  'excerpt' => 'This is the product 2 excerpt',
                  'body' => 'The 2nd product',
                  'category_id' => 4,
                  'user_id' => $admin->id
              ]), */
                new Post([
                    'name' => 'Mentions Légales',
                    'slug' => 'mentions-legales',
                    'excerpt' => '',
                    'body' => '',
                    'category_id' => 3,
                    'user_id' => $admin->id
                ]),
                new Post([
                    'name' => 'Contact form - home',
                    'slug' => 'contact-form',
                    'excerpt' => '',
                    'body' => '',
                    'category_id' => 2,
                    'user_id' => $admin->id
                ]),
                new Post([
                    'name' => 'Footer - home',
                    'slug' => 'footer-home',
                    'excerpt' => '',
                    'body' => '',
                    'category_id' => 1,
                    'user_id' => $admin->id
                ]),
                new Post([
                    'name' => 'New Resources',
                    'slug' => 'new-resources',
                    'excerpt' => '',
                    'body' => '',
                    'category_id' => 3,
                    'user_id' => $admin->id
                ])
            ]
        );
    }
}
