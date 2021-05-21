<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('ruc', 11)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('email')->nullable();
            $table->integer('levels');
            $table->longText('description')->nullable();
            $table->string('image');
            $table->string('logo');
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
        Schema::dropIfExists('hotel');
    }
}
