<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_id', false, true)->index();
            $table->string('postal_code')->nullable()->index();
            $table->string('ward')->nullable();
            $table->string('sublocality_level_3')->nullable();
            $table->string('sublocality_level_2')->nullable();
            $table->string('sublocality_level_1')->nullable();
            $table->string('sublocality')->nullable();
            $table->string('locality')->nullable();
            $table->string('administrative_area_level_3')->nullable();
            $table->string('administrative_area_level_2')->nullable();
            $table->string('administrative_area_level_1')->nullable();
            $table->string('country')->nullable();
            $table->string('formatted_address')->nullable();
            $table->string('location_lat')->nullable();
            $table->string('location_lng')->nullable();
            $table->string('location_type')->nullable();
            $table->boolean('partial_match')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locations');
    }
}
