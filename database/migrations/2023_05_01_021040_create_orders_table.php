<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('prefix');
            $table->bigInteger('field_id');
            $table->bigInteger('user_id');
            $table->bigInteger('boots_id')->nullable();
            $table->bigInteger('balls_id')->nullable();
            $table->string('name');
            $table->string('booking_time');
            $table->integer('duration');
            $table->date('booking_date');
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
        Schema::dropIfExists('orders');
    }
}
