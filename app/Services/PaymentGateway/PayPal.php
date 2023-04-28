<?php

namespace Services\PaymentGateway;

use Log;

class PayPal
{

    const GATEWAY_NAME = 'PayPal_Rest';

    private $transaction_data;

    private $gateway;

    private $extra_params = ['paypalToken', 'payKey'];

    public function __construct($gateway)
    {
        $this->gateway = $gateway;
        $this->options = [];
    }

    private function createTransactionData($order_total, $order_email, $event)
    {

        Log::info("createTransactionData: event data == " . print_r($event, true) . "\n");
        $returnUrl = route('showEventCheckoutPaymentReturn', [
            'event_id' => $event->id,
            'txn_id' => $event->id,
            'is_payment_successful' => 1,
        ]);
        $cancelUrl = route('showEventCheckoutPaymentReturn', [
            'event_id' => $event->id,
            'txn_id' => $event->id,
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

    public function completeTransaction($data)
    {
        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];
        // Once the transaction has been approved, we need to complete it.
        $transaction = $this->gateway->completePurchase(array(
            'payer_id'             => $payerId ? $payerId : $this->options['PayerID'],
            'transactionReference' => $paymentId ? $paymentId : $this->options['paymentId'],
        ));

        $response = $transaction->send();

        if ($response->isSuccessful()) {
            // The customer has successfully paid.
            Log::info("success response to transaction send == " . print_r($response, true) . "\n");
        } else {
            // There was an error returned by completePurchase().  You should
            // check the error code and message from PayPal, which may be something
            // like "card declined", etc.
            Log::error("response to transaction send == " . print_r($response, true) . "\n");
        }
        return $response;
    }


    public function getAdditionalData($response)
    {
        Log::info("getAdditionalData: retrievable data == " . print_r($response, true) . "\n");
        return [];
    }

    public function storeAdditionalData()
    {
        return true;
    }

    public function refundTransaction($order, $refund_amount, $refund_application_fee)
    {
        Log::info("refundTransaction: order data == " . print_r($order, true) . "\n");
        Log::info("refundTransaction: refund_amount data == " . print_r($refund_amount, true) . "\n");
        Log::info("refundTransaction: refund_application_fee data == " . print_r($refund_application_fee, true) . "\n");

        $request = $this->gateway->refund([
            'currency' => $event->currency->code,
            'transactionReference' => $order->transaction_id,
            'amount' => number_format((float)$refund_amount, 2, '.', ''),
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
