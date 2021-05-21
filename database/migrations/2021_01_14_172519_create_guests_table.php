<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->integer('room_number');
            $table->string('name', 30);
            $table->string('last_name', 30);
            $table->string('dni', 12)->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('email')->nullable();
            $table->integer('persons'); //number of people
            $table->dateTime('entry_date');
            $table->dateTime('departure_date');
            $table->enum('status', ['hosped', 'retired'])->default('hosped');
            $table->longText('message')->nullable();
            $table->longText('origin')->nullable();
            $table->enum('via', ['hotel', 'web', 'call', 'whatsapp', 'facebook', 'other'])->default('hotel');
            $table->timestamps();

            $table->foreign('room_number')->references('number')->on('rooms')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
