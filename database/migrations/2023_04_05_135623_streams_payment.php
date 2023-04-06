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
        //
        Schema::create('streams_payment', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id');
            $table->string('stripe_payment_intent');
            $table->string('subtotal');
            $table->string('discount_coupon_name');
            $table->string('discount_amount');
            $table->string('total');
            $table->string('status');
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
        //
        Schema::dropIfExists('streams_payment');
    }
};
