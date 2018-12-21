<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experience')->default(0)->nullable();
            $table->integer('gold')->default(100)->nullable();
            $table->integer('life')->default(200)->nullable();
            $table->integer('demage')->default(50)->nullable();
            $table->integer('speed')->default(70)->nullable();
            $table->integer('agility')->default(60)->nullable();
            $table->integer('armour')->default(50)->nullable();
            $table->integer('energy')->default(40)->nullable();
            $table->integer('gold')->default(10)->nullable();

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
        Schema::dropIfExists('items');
    }
}
