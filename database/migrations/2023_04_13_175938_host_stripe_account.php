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
        Schema::create('host_stripe_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('host_id');
            $table->string('stripe_account_num');
            $table->string('linked_bank_acc_num');
            $table->string('acc_routing_number');
            $table->string('account_holder_name');
            $table->string('account_holder_email');
            $table->string('business_phone');
            $table->string('business_site');
            $table->string('country');
            $table->string('bank_region');
            $table->string('region_currency');
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
        Schema::dropIfExists('host_stripe_accounts');
    }
};
