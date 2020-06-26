<?php

use Illuminate\Support\Carbon;
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
            'password' => bcrypt('999999999'),
            'usertype' => 'admin',
            'email_verified_at' => Carbon::now(),
        ]);


        DB::table('categories')->insertOrIgnore(['name' => 'maxi']);
        DB::table('categories')->insertOrIgnore(['name' => 'optimal']);
        DB::table('categories')->insertOrIgnore(['name' => 'mini']);

    // ================ mini 30 ======================
        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 3,
                'name' => '1000',
                'periodindays' => 30,
                'price' => 1990,
                'likes' => 1000,
                'posts' => 15,
                'views' => 3000,
                'bonus' => '10-15 комментариев на 5 постов в тему публикации',
            ]
        );   

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 3,
                'name' => '2000',
                'periodindays' => 30,
                'price' => 5990,
                'likes' => 2000,
                'posts' => 15,
                'views' => 6000,
                'bonus' => '15-20 комментариев на 5 постов в тему публикации',
            ]
        );

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 3,
                'name' => '4000',
                'periodindays' => 30,
                'price' => 11490,
                'likes' => 4000,
                'posts' => 15,
                'views' => 10000,
                'bonus' => '20-25 комментариев на 5 постов в тему публикации'
            ]
        );

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 3,
                'name' => '8000',
                'periodindays' => 30,
                'price' => 21990,
                'likes' => 8000,
                'posts' => 15,
                'views' => 30000,
                'bonus' => '25-30 комментариев на 5 постов в тему публикации'
            ]
        ); 

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 3,
                'name' => '10000',
                'periodindays' => 30,
                'price' => 24990,
                'likes' => 10000,
                'posts' => 15,
                'views' => 30000,
                'bonus' => '30-35 комментариев на 5 постов в тему публикации'
            ]
        ); 


    // ================ max 30 ======================
        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '1000',
                'periodindays' => 30,
                'price' => 2990,
                'likes' => 1000,
                'posts' => 30,
                'views' => 3000,
                'bonus' => '10-15 комментариев на 5 постов в тему публикации',
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
                'bonus' => '15-20 комментариев на 5 постов в тему публикации',
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
                'bonus' => '20-25 комментариев на 5 постов в тему публикации'
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
                'bonus' => '25-30 комментариев на 5 постов в тему публикации'
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
                'bonus' => '30-35 комментариев на 5 постов в тему публикации'
            ]
        ); 

    //================max60=========================

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '1000',
                'periodindays' => 60,
                'price' => 5590,
                'likes' => 1000,
                'posts' => 30,
                'views' => 3000,
                'bonus' => "10-15 комментариев на 10 постов в тему публикации",
            ]
        );

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '2000',
                'periodindays' => 60,
                'price' => 12990,
                'likes' => 2000,
                'posts' => 60,
                'views' => 6000,
                'bonus' => "15-20 комментариев на 10 постов в тему публикации",
            ]
        );  

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '4000',
                'periodindays' => 60,
                'price' => 25990,
                'likes' => 4000,
                'posts' => 60,
                'views' => 10000,
                'bonus' => "20-25 комментариев на 10 постов в тему публикации",
            ]
        );  

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '8000',
                'periodindays' => 60,
                'price' => 46990,
                'likes' => 8000,
                'posts' => 60,
                'views' => 30000,
                'bonus' => "25-30 комментариев на 10 постов в тему публикации",
            ]
        ); 

        DB::table('services')->insertOrIgnore(
            [
                'category_id' => 1,
                'name' => '10000',
                'periodindays' => 60,
                'price' => 54990,
                'likes' => 10000,
                'posts' => 60,
                'views' => 30000,
                'bonus' => "30-35 комментариев на 10 постов в тему публикации",
            ]
        );

        //=========================================

         
    }
}
