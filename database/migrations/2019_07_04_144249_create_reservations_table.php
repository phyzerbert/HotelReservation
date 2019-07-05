<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('visitor_phone_number')->nullable();
            $table->date('visit_date')->nullable();
            $table->string('id_number')->nullable();
            $table->string('passport_id')->nullable();
            $table->string('passport_image')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->integer('hotel_id')->nullable();
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->integer('room_type')->nullable();
            $table->text('note')->nullable();
            $table->integer('om_status')->default(0);
            $table->integer('om_id')->nullable();
            $table->dateTime('om_date')->nullable();
            $table->integer('gm_status')->default(0);
            $table->integer('gm_id')->nullable();
            $table->dateTime('gm_date')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
