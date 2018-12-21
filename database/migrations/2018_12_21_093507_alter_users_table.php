<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('experience')->default(0)->nullable();
            $table->integer('gold')->default(100)->nullable();
            $table->integer('life')->default(200)->nullable();
            $table->integer('damage')->default(50)->nullable();
            $table->integer('speed')->default(70)->nullable();
            $table->integer('agility')->default(60)->nullable();
            $table->integer('armour')->default(50)->nullable();
            $table->integer('energy')->default(40)->nullable();
            // 1 - pars
            $table->smallInteger('type')->default(1)->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
