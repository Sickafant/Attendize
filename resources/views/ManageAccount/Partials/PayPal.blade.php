<section class="payment_gateway_options" id="gateway_{{$payment_gateway['id']}}">
    <h4>@lang("ManageAccount.paypal_settings")</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[secret]', trans("ManageAccount.paypal_secret_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[secret]', $account->getGatewayConfigVal($payment_gateway['id'], 'secret'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('clientId', trans("ManageAccount.paypal_client_id"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[clientId]', $account->getGatewayConfigVal($payment_gateway['id'], 'clientId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[testMode]', trans("ManageAccount.paypal_test_mode"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[testMode]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'testMode'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>
