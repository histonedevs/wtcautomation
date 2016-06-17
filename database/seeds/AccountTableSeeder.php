<?php

use Illuminate\Database\Seeder;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('accounts')->insert([
            'unique_id' => 1,
            'name' => str_random(10),
            'first_name' => str_random(10),
            'last_name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
