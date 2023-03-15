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
        Schema::create('admin_discount_coupon', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name');
            $table->string('stripe_coupon_id');
            $table->string('discount_type');
            $table->string('amount_off')->nullable();
            $table->string('currency')->nullable();
            $table->string('percent_off')->nullable();
            $table->string('duration');
            $table->string('duration_in_months')->nullable();
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
        Schema::dropIfExists('admin_discount_coupon');
    }
};
