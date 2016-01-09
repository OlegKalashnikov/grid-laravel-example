<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_companies', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->integer('company_id')->nullable();

            $table->foreign('company_id')->references('id')->on('user_companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('company_id');
        });

        Schema::drop('user_companies');
    }
}
