<?php

namespace Services\PaymentGateway;
use Log;

class PayPal
{

    CONST GATEWAY_NAME = 'PayPal_Rest';

    private $transaction_data;

    private $gateway;

    private $extra_params = ['paypalToken','payKey'];

    public function __construct($gateway)
    {
        $this->gateway = $gateway;
        $this->options = [];
    }

    private function createTransactionData($order_total, $order_email, $event)
    {
        $returnUrl = route('showEventCheckoutPaymentReturn', [
            'event_id' => $event->id,
            'is_payment_successful' => 1,
        ]);
        $cancelUrl = route('showEventCheckoutPaymentReturn', [
            'event_id' => $event->id,
            'is_payment_successful' => 0,
        ]);

        $this->transaction_data = [
            'amount' => $order_total,
            'currency' => $event->currency->code,
            'description' => 'Order for customer: ' . $order_email,
            'receipt_email' => $order_email,
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'confirm' => true
        ];

        return $this->transaction_data;
    }

    public function startTransaction($order_total, $order_email, $event)
    {

        $this->createTransactionData($order_total, $order_email, $event);
        $transaction = $this->gateway->purchase($this->transaction_data);
        $response = $transaction->send();
        $data = $response->getData();
        Log::info("Gateway purchase response data == " . print_r($data, true) . "\n");

        return $response;
    }

    public function getTransactionData()
    {
        return $this->transaction_data;
    }

    public function extractRequestParameters($request)
    {
        foreach ($this->extra_params as $param) {
            if (!empty($request->get($param))) {
                $this->options[$param] = $request->get($param);
            }
        }
    }

    public function completeTransaction($data) {

        if ($response->isRedirect()) {

            session()->push('ticket_order_' . $event_id . '.transaction_data',
                            $gateway->getTransactionData() + $data);

            Log::info("Redirect url: " . $response->getRedirectUrl());

            $return = [
                'status'       => 'success',
                'redirectUrl'  => $response->getRedirectUrl(),
                'message'      => 'Redirecting to ' . $ticket_order['payment_gateway']->provider_name
            ];

            // GET method requests should not have redirectData on the JSON return string
            if($response->getRedirectMethod() == 'POST') {
                $return['redirectData'] = $response->getRedirectData();
            }

            return response()->json($return);
        } else {
            // display error to customer
            return response()->json([
                'status'  => 'error',
                'message' => $response->getMessage(),
            ]);
        }
    }

    public function getAdditionalData($response){

        $additionalData['extra'] = 'nothing yet';
        return $additionalData;
    }

    public function storeAdditionalData()
    {
        return true;
    }

    public function refundTransaction($order, $refund_amount, $refund_application_fee)
    {

        $request = $this->gateway->refund([
            'transactionReference' => $order->transaction_id,
            'amount' => $refund_amount,
            'refundApplicationFee' => $refund_application_fee
        ]);

        $response = $request->send();

        if ($response->isSuccessful()) {
            $refundResponse['successful'] = true;
        } else {
            $refundResponse['successful'] = false;
            $refundResponse['error_message'] = $response->getMessage();
        }

        return $refundResponse;
    }
}
