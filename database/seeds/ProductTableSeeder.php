<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \DB::table("accounts")->whereUniqueId(100000)->first();

        $now = date('Y-m-d H:i:s');
        for($itr = 0; $itr < 10; $itr++) {
            DB::table('products')->insert([
                'unique_id' => rand(),
                'product_id_type' => 1,
                'user_id' => $user->id,
                'title' => str_random(10),
                'description' => str_random(20),
                'sku' => str_random(10),
                'product_id' => str_random(10),
                'asin' => 'B00TSUGXKE',
                'price' => 1200,
                'shipping_price' => 1200,
                'buybox_price' => 1200,
                'sales_rank' => 4,
                'stock' => 10,
                'open_date' => $now,
                'created_at' => $now,
                'updated_at' => $now,
                'active' => 1
            ]);
        }
    }
}
