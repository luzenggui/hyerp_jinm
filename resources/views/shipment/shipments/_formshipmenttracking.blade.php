<div class="form-group">
    {!! Form::label('invoice_number', '发票号(Invoice No.):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('invoice_number', null, ['class' => 'form-control', 'readonly']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('customer_name', '客户名称(Customer Name):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('customer_name', null, ['class' => 'form-control', 'readonly']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('container_number', '集装箱号(Container No.):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('container_number', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('bill_no', '提单/FCR号(Bill No.):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('bill_no', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('customs_no', '关单号(Customs No.):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('customs_no', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ship_company', '船公司(Ship Company):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('ship_company', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('freight_charge_usd', '运费（USD）(Freight Charge):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('freight_charge_usd', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('booking_date', 'BOOKING Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('booking_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('bc_date', 'BC Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('bc_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('shippingdocs_date', 'SHIPPING DOCS Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('shippingdocs_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('uploading_date', 'UPLOADING Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('uploading_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('truck_eta_djibouti_date', 'TRUCK ETA DJIBOUTI Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('truck_eta_djibouti_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('cutoff_date', 'CUT OFF Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('cutoff_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('etd', 'ETD djibouti Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('etd', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('eta_transport_date', 'ETA TRANSPORT Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('eta_transport_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('etd_transport_date', 'ETD TRANSPORT Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('etd_transport_date', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('eta', 'ETA DES PORT Date:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::date('eta', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('forwarder_comment', 'Forwarder Comment:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('forwarder_comment', null, ['class' => 'form-control']) !!}
    </div>
</div>

<?php $types = ['BC', 'BL']; ?>
@foreach($types as $type)
    <div class="form-group">
        {!! Form::label($type, $type . ':', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
        <div class='col-xs-8 col-sm-10'>
            @if (isset($shipment) && null != $shipment->shipmentattachments->where('type', $type)->first())
                <a href="{!! Storage::url($shipment->shipmentattachments->where('type', $type)->first()->path) !!}" target="_blank">{{ $shipment->shipmentattachments->where('type', $type)->first()->filename }}</a> <br>
            @endif
            {!! Form::file($type) !!}
        </div>
    </div>
@endforeach

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

