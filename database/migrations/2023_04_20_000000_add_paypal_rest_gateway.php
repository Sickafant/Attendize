<?php

use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AddPayPalRestGateway extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $paypal = DB::table('payment_gateways')->where('provider_name', 'PayPal_Rest')->first();

        if ($paypal) {
            $paypal->update([
                'admin_blade_template'    => 'ManageAccount.Partials.PayPal',
                'checkout_blade_template' => 'Public.ViewEvent.Partials.PaymentPayPal'
            ]);
        } else {
            DB::table('payment_gateways')->insert(
                [
                    'provider_name'           => 'PayPal_Rest',
                    'provider_url'            => 'https://www.paypal.com',
                    'is_on_site'              => 0,
                    'can_refund'              => 0,
                    'name'                    => 'PayPal_Rest',
                    'default'                 => 0,
                    'admin_blade_template'    => 'ManageAccount.Partials.PayPal',
                    'checkout_blade_template' => 'Public.ViewEvent.Partials.PaymentPayPal'
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $paypal = PaymentGateway::where('name', 'PayPal_Rest')->first();

        if ($paypal) {
            // Set the Paypal gateway relationship to null to avoid errors when removing it
            Order::where('payment_gateway_id', $paypal->id)->update(['payment_gateway_id' => null]);
            Log::info('Removed');

            $paypal->delete();
        }

    }
}
