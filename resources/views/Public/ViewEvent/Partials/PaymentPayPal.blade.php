<form class="online_payment" action="<?php echo route('postCreateOrder', ['event_id' => $event->id]); ?>" method="post" id="paypal-payment-form">
    <div class="form-row">
        <label for="card-element">
            @lang("Public_ViewEvent.paypal_credit_or_debit_card")
        </label>
        <div id="card-element">

        </div>

        <div id="card-errors" role="alert"></div>
    </div>
    {!! Form::token() !!}

    <input class="btn btn-lg btn-success card-submit" style="width:100%;" type="submit" value="@lang("Public_ViewEvent.complete_payment")">

</form>
<script type="text/javascript" src="https://www.paypal.com/sdk/js?client-id=<?php echo $account_payment_gateway->config['clientId']; ?>&components=buttons&vault=true&intent=subscription"></script>
<script type="text/javascript">

    var paypal = PayPal('<?php echo $account_payment_gateway->config['clientId']; ?>');
    var elements = paypal.elements();

    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var card = elements.create('card',  {hidePostalCode: true, style: style});

    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });


</script>
<style type="text/css">

    .PayPalElement {
        box-sizing: border-box;

        height: 40px;

        padding: 10px 12px;

        border: 1px solid #e0e0e0 !important;
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
        margin-bottom: 20px;
    }

    .PayPalElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .PayPalElement--invalid {
        border-color: #fa755a;
    }

    .PayPalElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

</style>
