<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrandingFieldsToAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string("company_name")->nullable();
            $table->string("contact_person")->nullable();
            $table->string("website")->nullable();
            $table->string("logo")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn("company_name");
            $table->dropColumn("contact_person");
            $table->dropColumn("website");
            $table->dropColumn("logo");
        });
    }
}
