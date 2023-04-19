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
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[username]', trans("ManageAccount.paypal_username"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[username]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'username'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[password]', trans("ManageAccount.paypal_password"), ['class'=>'control-label ']) !!}
                {!! Form::text('paypal[password]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'password'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('paypal[signature]', trans("ManageAccount.paypal_signature"), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[signature]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'signature'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('paypal[brandName]', trans("ManageAccount.branding_name"), array('class'=>'control-label ')) !!}
                    {!! Form::text('paypal[brandName]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'brandName'),[ 'class'=>'form-control'])  !!}
                    <div class="help-block">
                        @lang("ManageAccount.branding_name_help")
                    </div>
                </div>
            </div>
        </div>
</section>
