<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = User::create([
            'full_name' => 'Manager 1',
            'email' => 'manager1@gmail.com',
            'password' => Hash::make('password'),
            'usertype' => User::USERTYPE_MANAGER
        ]);

        User::create([
            'full_name' => 'Manager 2',
            'email' => 'manager2@gmail.com',
            'password' => Hash::make('password'),
            'usertype' => User::USERTYPE_MANAGER
        ]);

        User::create([
            'full_name' => 'Manager 3',
            'email' => 'manager3@gmail.com',
            'password' => Hash::make('password'),
            'usertype' => User::USERTYPE_MANAGER
        ]);

        //users//
        for($i = 1; $i <10; $i++){
            User::create([
                'full_name' => "User $i",
                'email' => "user_$i@gmail.com",
                'password' => Hash::make('password'),
                'manager' => $manager->id,
            ]);
        }
    }
}
