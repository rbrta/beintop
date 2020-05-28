<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('999999999')
        ]);

        DB::table('users')->insertOrIgnore([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456789')
        ]);

        DB::table('categories')->insertOrIgnore(['name' => 'Тарифы max']);
        DB::table('categories')->insertOrIgnore(['name' => 'Тарифы optimal']);
        DB::table('categories')->insertOrIgnore(['name' => 'Тарифы mini']);

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '1000',
                'periodindays' => 15,
                'price' => 5590,
                'likes' => 1000,
                'posts' => 30,
                'views' => 3000,
                'bonus_comments' => "10-15",
                'bonus_posts' => 10
            ]
        );   

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '2000',
                'periodindays' => 60,
                'price' => 5590,
                'likes' => 1000,
                'posts' => 30,
                'views' => 3000,
                'bonus_comments' => "10-15",
                'bonus_posts' => 10
            ]
        );  

        DB::table('orders')->insertOrIgnore(
            ['user_id' => 1, 'service_id' => '1' ]
        );  
    }
}
