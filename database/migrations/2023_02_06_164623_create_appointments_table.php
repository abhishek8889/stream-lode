<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->host_id();
            $table->string('title');
            $table->date('start');
            $table->date('end');
            $table->string('duration_in_minutes');
            $table->string('total_duration');
            $table->string('video_call_status');
            $table->string('meeting_charges'); 
            $table->string('currency'); 
            $table->string('stripe_payment_intent');
            $table->string('stripe_client_secret');
            $table->integer('status');
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
        Schema::dropIfExists('appointments');
    }
};
