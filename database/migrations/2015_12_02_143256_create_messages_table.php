<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->foreign('user_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');

            $table->string('recipient');
            $table->integer('campaign_id', false, true);
            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
                ->onDelete('cascade');

            $table->string('text');
            $table->boolean('sent');
            $table->timestamp('visited_at');
            $table->string('error');

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
        Schema::drop('messages');
    }
}