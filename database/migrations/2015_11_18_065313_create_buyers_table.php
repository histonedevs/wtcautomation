<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_id', false, true)->index();
            $table->integer('user_id', false, true);
            $table->foreign('user_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_initial')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('zip', 30)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country', 50)->nullable();
            $table->integer('orders_count')->default(1);
            $table->integer('location_id', false, true)->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::drop('buyers');
    }
}
