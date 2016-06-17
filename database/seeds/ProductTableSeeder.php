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
        $now = date('Y-m-d H:i:s');
        DB::table('products')->insert([
            'unique_id' => 1,
            'product_id_type' => 1,
            'user_id' => 1,
            'title' => str_random(10),
            'description' => str_random(20),
            'sku' => str_random(10),
            'product_id' => str_random(10),
            'asin' => str_random(10),
            'price' => 1200,
            'shipping_price' => 1200,
            'buybox_price' => 1200,
            'sales_rank' => 4,
            'stock' => 10,
            'open_date' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
