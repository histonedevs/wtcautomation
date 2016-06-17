<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegativeResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negative_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id', false, true);
            $table->foreign('message_id')
                ->references('id')->on('messages')
                ->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->text('reason');
            $table->text('suggestion');
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
        Schema::drop('negative_responses');
    }
}
