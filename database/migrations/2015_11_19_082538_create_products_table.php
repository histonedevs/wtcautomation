<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_id', false, true)->index();
            $table->integer('product_id_type');
            $table->integer('user_id', false, true);
            $table->foreign('user_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
            $table->string('title');
            $table->mediumText('description');
            $table->string('sku');
            $table->string('product_id', 20);
            $table->string('fnsku')->nullable();
            $table->string('asin', 30);
            $table->string('condition', 40)->nullable();
            $table->string('sub_condition', 40)->nullable();
            $table->string('fulfilment_channel', 20)->nullable();
            $table->string('image_url')->nullable();
            $table->double('cost')->nullable();
            $table->double('price')->nullable();
            $table->double('shipping_price')->nullable();
            $table->double('buybox_price')->nullable();

            $table->integer('sales_rank')->nullable();
            $table->integer('stock')->nullable();
            $table->timestamp('open_date')->nullable();
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
        Schema::drop('products');
    }
}
