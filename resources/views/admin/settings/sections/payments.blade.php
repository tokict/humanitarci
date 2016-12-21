<div id="tab-payments" class="tab-pane active">
    <div class="panel-body">
        <label class="col-md-2">TAXES</label>
        <div class="col-md-2">
            <label>Payment provider tax</label>
        {{Form::number('payment_provider_tax', null, ['class' => 'form-control', 'step' => '0.01'])}}
        </div>
        <div class="col-md-2">
            <label>Bank tax</label>
            {{Form::number('payment_bank_tax', null, ['class' => 'form-control', 'step' => '0.01'])}}
        </div>
        <div class="col-md-2">
            <label>Platform expenses tax</label>
            {{Form::number('payment_platform_tax', null, ['class' => 'form-control', 'step' => '0.01'])}}
        </div>
    </div>
</div>