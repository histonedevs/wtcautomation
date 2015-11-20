<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_id', false, true)->index();
            $table->integer('sale_order_id', false, true);
            $table->foreign('sale_order_id')
                ->references('id')->on('sale_orders')
                ->onDelete('cascade');
            $table->integer('product_id', false, true);
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->string('item_id', 45)->nullable();
            $table->integer('quantity_ordered')->nullable();
            $table->integer('quantity_shipped')->nullable();
            $table->string('currency', 10)->nullable();
            $table->double('item_price')->nullable();
            $table->double('item_discount')->nullable();
            $table->double('item_tax')->nullable();
            $table->double('shipping_price')->nullable();
            $table->double('shipping_discount')->nullable();
            $table->double('shipping_tax')->nullable();
            $table->double('giftwrap_price')->nullable();
            $table->double('giftwrap_tax')->nullable();
            $table->string('giftwrap_message')->nullable();
            $table->string('giftwrap_level')->nullable();
            $table->double('cod_fee')->nullable();
            $table->double('cod_fee_discount')->nullable();
            $table->string('price_designation', 15)->nullable();
            $table->timestamp('delivery_start_date')->nullable();
            $table->timestamp('delivery_end_date')->nullable();
            $table->string('promotion_ids')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sale_order_items');
    }
}
