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
            $table->string('stripe_payment_intent');
            $table->string('stripe_payment_method');
            $table->string('subtotal');
            $table->string('coupon_code');
            $table->string('discount_amount');
            $table->string('payment_id');
            $table->string('total');
            $table->string('appoinment_id');
            $table->string('currency');
            $table->string('host_id');
            $table->string('guest_id');
            $table->string('host_stripe_account_id');
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
