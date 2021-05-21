<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('room_number');
            $table->integer('persons');
            $table->string('name', 30);
            $table->string('last_name', 30);
            $table->string('dni', 12)->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('email')->nullable();
            $table->dateTime('entry_date');
            $table->dateTime('departure_date');
            $table->longText('origin')->nullable();
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
