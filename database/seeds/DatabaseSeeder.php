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
            'full_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('999999999')
        ]);

        DB::table('users')->insertOrIgnore([
            'full_name' => 'User',
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
                'periodindays' => 30,
                'price' => 2990,
                'likes' => 1000,
                'posts' => 30,
                'views' => 3000,
                'bonus_comments' => "10-15",
                'bonus_posts' => 5
            ]
        );   

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '2000',
                'periodindays' => 30,
                'price' => 6990,
                'likes' => 2000,
                'posts' => 30,
                'views' => 6000,
                'bonus_comments' => "15-20",
                'bonus_posts' => 5
            ]
        );  

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '4000',
                'periodindays' => 30,
                'price' => 13990,
                'likes' => 4000,
                'posts' => 30,
                'views' => 10000,
                'bonus_comments' => "15-20",
                'bonus_posts' => 5
            ]
        );  

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '8000',
                'periodindays' => 30,
                'price' => 25990,
                'likes' => 8000,
                'posts' => 30,
                'views' => 30000,
                'bonus_comments' => "25-30",
                'bonus_posts' => 5
            ]
        ); 

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '10000',
                'periodindays' => 30,
                'price' => 30990,
                'likes' => 10000,
                'posts' => 30,
                'views' => 30000,
                'bonus_comments' => "30-35",
                'bonus_posts' => 5
            ]
        ); 

        //=========================================

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '1000',
                'periodindays' => 60,
                'price' => 5590,
                'likes' => 1000,
                'posts' => 30,
                'views' => 3000,
                'bonus_comments' => "10-15",
                'bonus_posts' => 5
            ]
        ); 

        //=========================================

        DB::table('orders')->insertOrIgnore(
            ['user_id' => 1, 'service_id' => '1' ]
        );  
    }
}
