<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);

        Page::truncate();

        $admin->pages()->saveMany(
            [
                new Page([
                    'title' => 'Home',
                    'url' => '/',
                    'description' => 'Home page',
                    'user_id' => 1
                ]),
                new Page([
                    'title' => 'News',
                    'url' => '/news',
                    'description' => 'News page',
                    'user_id' => 1
                ]),
                new Page([
                    'title' => 'Shop',
                    'url' => '/shop',
                    'description' => 'eCommerce page',
                    'user_id' => 1
                ]),
                new Page([
                    'title' => 'Free Downloads',
                    'url' => '/free-downloads',
                    'description' => 'Free downloads page',
                    'user_id' => 1
                ]),
                new Page([
                    'title' => 'About',
                    'url' => '/about',
                    'description' => 'About us page',
                    'user_id' => 1
                ]),
                new Page([
                    'title' => 'FAQ',
                    'url' => '/faq',
                    'description' => 'FAQ page',
                    'user_id' => 1
                ]),
                new Page([
                    'title' => 'Product',
                    'url' => '/product',
                    'description' => 'Page for the product details',
                    'user_id' => 1
                ])
            ]
        );
    }
}
