<section class="payment_gateway_options" id="gateway_{{$payment_gateway['id']}}">
    <h4>@lang("ManageAccount.paypal_settings")</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[apiKey]', trans("ManageAccount.paypal_secret_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[apiKey]', $account->getGatewayConfigVal($payment_gateway['id'], 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('publishableKey', trans("ManageAccount.paypal_publishable_key"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[publishableKey]', $account->getGatewayConfigVal($payment_gateway['id'], 'publishableKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>
