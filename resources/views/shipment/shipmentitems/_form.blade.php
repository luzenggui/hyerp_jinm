<div class="form-group">
    {!! Form::label('contract_number', '合同号(Contract No.):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('contract_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('purchaseorder_number', '订单号(Purchase Order No.):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('purchaseorder_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('qty_for_customer', '议付数量(Quantity for Customer):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('qty_for_customer', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount_for_customer', '议付金额(Amount for Customer):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('amount_for_customer', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('volume', '体积(Volume):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('volume', null, ['class' => 'form-control']) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('ship_mode', '发货方式:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('ship_mode', null, ['class' => 'form-control', 'placeholder' => 'CONSOLIDATION WAREHOUSE; DIRECT SHIPMENT.']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('ship_date', '发货日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::date('ship_date', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('delivery_date', '装运日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::date('delivery_date', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('estimated_arrival_date', '预计到达日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::date('estimated_arrival_date', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('shipper_name', '发货人:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('shipper_name', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('country_of_origin', '原产地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('country_of_origin', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as CHN.']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('country_of_destination', '目的地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('country_of_destination', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as VNM.']) !!}--}}
    {{--</div>--}}
{{--</div>--}}



{!! Form::hidden('shipment_id', $shipment_id, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

