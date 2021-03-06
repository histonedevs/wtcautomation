<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = [
            [
                'name' => "Yasir Hussain",
                'email' => 'yacirhussain@gmail.com',
                'password' => Hash::make('hello123'),
                'user_type' => 'admin',
            ],
            [
                'name' => "Fahim Sardar",
                'email' => 'fahim@gmail.com',
                'password' => Hash::make('hello123'),
                'user_type' => 'admin',
            ]
        ];
        foreach($members as $members){
            User::create($members);
        }
    }
}
