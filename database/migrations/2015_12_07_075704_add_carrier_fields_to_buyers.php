<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarrierFieldsToBuyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->string("carrier")->nullable();
            $table->string("phone_type")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn("carrier");
            $table->dropColumn("phone_type");
        });
    }
}
