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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('dob');
            $table->string('personal_contact');
            $table->string('city');
            $table->string('line1');
            $table->string('state');
            $table->string('ssn');
            $table->string('postal_code');
            $table->string('email');
            $table->string('business_phone');
            $table->string('mcc');
            $table->string('country');
            $table->string('account_holder_name');
            $table->string('bank_acc_number');
            $table->string('acc_routing_num');
            $table->string('bank_acc_region');
            $table->string('region_currency');
            $table->string('active_status');
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
