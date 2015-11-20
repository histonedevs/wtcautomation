<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_id', false, true)->index();
            $table->integer('user_id', false, true);
            $table->foreign('user_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
            $table->integer('buyer_id', false, true)->nullable();
            $table->foreign('buyer_id')
                ->references('id')->on('buyers')
                ->onDelete('cascade');
            $table->string('amazon_order_id', 24);
            $table->string('order_status', 15);
            $table->string('fulfillment_channel', 20);
            $table->string('sales_channel', 20);
            $table->string('carrier', 30)->nullable();
            $table->string('tracking_number', 60)->nullable();
            $table->timestamp('purchased_at');
            $table->timestamp('last_updated_at');
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
        Schema::drop('sale_orders');
    }
}
