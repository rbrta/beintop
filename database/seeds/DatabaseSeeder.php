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

        DB::table('categories')->insertOrIgnore([
            'name' => 'Тарифы max',
            'name' => 'Тарифы optimal',
            'name' => 'Тарифы mini',
        ]);
    }
}
