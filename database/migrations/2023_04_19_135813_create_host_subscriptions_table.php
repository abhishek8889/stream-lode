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
        Schema::create('host_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_subscription_id');
            $table->string('subscription_name');
            $table->string('membership_id');
            $table->string('host_id');
            $table->string('interval');
            $table->string('interval_count');
            $table->string('start_on');
            $table->string('next_invoice_generate_on');
            $table->string('subscription_status'); // pause , active , past_due , canceled
            $table->string('membership_payment_id'); // current membership_payment id
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
        Schema::dropIfExists('host_subscriptions');
    }
};
