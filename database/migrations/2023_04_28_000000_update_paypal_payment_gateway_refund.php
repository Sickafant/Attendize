<?php

use Illuminate\Database\Migrations\Migration;

class UpdatePayPalPaymentGatewayRefund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_gateways')
            ->where('name', 'PayPal_Rest')
            ->update(['can_refund' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
