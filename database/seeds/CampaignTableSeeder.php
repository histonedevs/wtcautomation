<?php

use Illuminate\Database\Seeder;

class CampaignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('campaigns')->insert([
            'name' => str_random(10),
            'user_id' => 1,
            'product_id' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
