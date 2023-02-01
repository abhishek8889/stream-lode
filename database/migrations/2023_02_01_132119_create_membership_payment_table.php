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
        Schema::create('membership_payment', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('inovice_id');
            $table->string('order_id');
            $table->string('membership_id');
            $table->string('membership_total_amount');
            $table->string('discount_coupon_name')->nullable();
            $table->string('discount_percentage_amount')->nullable();
            $table->string('payment_amount');
            $table->string('payment_status');
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
        Schema::dropIfExists('membership_payment');
    }
};
