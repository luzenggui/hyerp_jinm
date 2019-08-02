{{--<div class="form-group">--}}
    {{--{!! Form::label('interchange_datetime', '传输时间:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::datetime('interchange_datetime', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('interchange_control_number', '传输控制号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('interchange_control_number', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('test_indicator', '测试标记:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {{--{!! Form::text('test_indicator', null, ['class' => 'form-control', 'placeholder' => 'T: Test Data; P: Production Data']) !!}--}}
        @if (isset($asn))
            {!! Form::select('test_indicator', array('T' => 'T -- Test Data', 'P' => 'P -- Production Data'), null, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @else
            {!! Form::select('test_indicator', array('T' => 'T -- Test Data', 'P' => 'P -- Production Data'), 'P', ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @endif
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('data_interchange_datetime', '数据交换时间:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::datetime('data_interchange_datetime', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('transaction_set_control_no', '交易控制号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('transaction_set_control_no', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('asn_number', 'ASN编号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('asn_number', null, ['class' => 'form-control', 'placeholder' => '10 characters']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('gross_weight', '毛重:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::text('gross_weight', $asn->asnshipments->first()->gross_weight, ['class' => 'form-control']) !!}
        @else
            {!! Form::text('gross_weight', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('gross_unit', '单位:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::text('gross_unit', $asn->asnshipments->first()->gross_unit, ['class' => 'form-control']) !!}
        @else
            {!! Form::text('gross_unit', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('transportation_type_code', '运输类型:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {{--{!! Form::text('transportation_type_code', $asn->asnshipments->first()->transportation_type_code, ['class' => 'form-control', 'placeholder' => 'A: Air; S: Sea; L: Land']) !!}--}}
            {!! Form::select('transportation_type_code', array('A' => 'A -- Air', 'S' => 'S -- Sea', 'L' => 'L -- Land'), $asn->asnshipments->first()->transportation_type_code, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @else
            {{--{!! Form::text('transportation_type_code', null, ['class' => 'form-control', 'placeholder' => 'A: Air; S: Sea; L: Land']) !!}--}}
            {!! Form::select('transportation_type_code', array('A' => 'A -- Air', 'S' => 'S -- Sea', 'L' => 'L -- Land'), 'S', ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('ref_bm_identification', '运单号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::text('ref_bm_identification', $asn->asnshipments->first()->ref_bm_identification, ['class' => 'form-control']) !!}
        @else
            {!! Form::text('ref_bm_identification', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('ref_va_identification', '运输工具号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::text('ref_va_identification', $asn->asnshipments->first()->ref_va_identification, ['class' => 'form-control']) !!}
        @else
            {!! Form::text('ref_va_identification', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('ship_mode', '发货方式:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
{{--            {!! Form::text('ship_mode', $asn->asnshipments->first()->ship_mode, ['class' => 'form-control', 'placeholder' => 'CONSOLIDATION WAREHOUSE; DIRECT SHIPMENT.']) !!}--}}
            {!! Form::select('ship_mode', array('CONSOLIDATION WAREHOUSE' => 'CONSOLIDATION WAREHOUSE', 'DIRECT SHIPMENT' => 'DIRECT SHIPMENT'), $asn->asnshipments->first()->ship_mode, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @else
{{--            {!! Form::text('ship_mode', null, ['class' => 'form-control', 'placeholder' => 'CONSOLIDATION WAREHOUSE; DIRECT SHIPMENT.']) !!}--}}
            {!! Form::select('ship_mode', array('CONSOLIDATION WAREHOUSE' => 'CONSOLIDATION WAREHOUSE', 'DIRECT SHIPMENT' => 'DIRECT SHIPMENT'), 'DIRECT SHIPMENT', ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('ship_date', '发货日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::date('ship_date', $asn->asnshipments->first()->ship_date, ['class' => 'form-control']) !!}
        @else
            {!! Form::date('ship_date', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('delivery_date', '装运日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::date('delivery_date', $asn->asnshipments->first()->delivery_date, ['class' => 'form-control']) !!}
        @else
            {!! Form::date('delivery_date', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('estimated_arrival_date', '预计到达日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
            {!! Form::date('estimated_arrival_date', $asn->asnshipments->first()->estimated_arrival_date, ['class' => 'form-control']) !!}
        @else
            {!! Form::date('estimated_arrival_date', null, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('shipper_name', '发货人:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
{{--            {!! Form::text('shipper_name', $asn->asnshipments->first()->shipper_name, ['class' => 'form-control']) !!}--}}
            {!! Form::select('shipper_name', array('JPTE' => 'JPTE', 'WUXIJINMAO' => 'WUXIJINMAO'), $asn->asnshipments->first()->shipper_name, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @else
{{--            {!! Form::text('shipper_name', null, ['class' => 'form-control']) !!}--}}
            {!! Form::select('shipper_name', array('JPTE' => 'JPTE', 'WUXIJINMAO' => 'WUXIJINMAO'), null, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('country_of_origin', '原产地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
{{--            {!! Form::text('country_of_origin', $asn->asnshipments->first()->country_of_origin, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as CHN.']) !!}--}}
            {!! Form::select('country_of_origin', array('CHN' => 'CHN', 'ETH' => 'ETH'), $asn->asnshipments->first()->country_of_origin, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @else
{{--            {!! Form::text('country_of_origin', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as CHN.']) !!}--}}
            {!! Form::select('country_of_origin', array('CHN' => 'CHN', 'ETH' => 'ETH'), null, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('country_of_destination', '目的地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if(isset($asn) &&  null != $asn->asnshipments->first())
{{--            {!! Form::text('country_of_destination', $asn->asnshipments->first()->country_of_destination, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as VNM.']) !!}--}}
            {!! Form::select('country_of_destination', array('VNM' => 'VNM', 'COK' => 'COK', 'ETH' => 'ETH', 'CHN' => 'CHN'), $asn->asnshipments->first()->country_of_destination, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @else
            {{--{!! Form::text('country_of_destination', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as VNM.']) !!}--}}
            {!! Form::select('country_of_destination', array('VNM' => 'VNM', 'COK' => 'COK', 'ETH' => 'ETH', 'CHN' => 'CHN'), null, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('pohead_number', '采购订单:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if (isset($asn) && null != $asn->asnshipments->first() && null != $asn->asnshipments->first()->asnorders->first())
            {!! Form::text('pohead_number', $asn->asnshipments->first()->asnorders->first()->pohead->number, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPurchaseorderModal', 'data-id' => 'vendor_id']) !!}
        @else
            {!! Form::text('pohead_number', null, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPurchaseorderModal']) !!}
        @endif
        {{--{!! Form::text('pohead_number', null, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPurchaseorderModal']) !!}--}}
        {!! Form::hidden('pohead_id', null, ['id' => 'pohead_id']) !!}
    </div>
</div>


{{--<div class="form-group">--}}
    {{--{!! Form::label('destination_country', '目的地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('destination_country', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('incoterms', '国际贸易术语:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('incoterms', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('incoterms_code', '国际贸易术语代码:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('incoterms_code', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('payment_days', '付款天数:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('payment_days', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}


{{--<div class="form-group">--}}
    {{--{!! Form::label('payment_term', '付款期限:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('payment_term', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('manufacturing_method', '生产方式:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('manufacturing_method', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('packing_instruction', '打包说明:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('packing_instruction', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('remark', '备注:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::textarea('remark', null, ['class' => 'form-control', 'rows' => 5]) !!}--}}
    {{--</div>--}}
{{--</div>--}}


{{--<div class="form-group">--}}
    {{--{!! Form::label('supplier_name', '供应商名称:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('supplier_name', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('supplier_code', '供应商代码:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('supplier_code', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('ship_to', '收货方:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('ship_to', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('factory_code', '收货方代码:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('factory_code', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('ship_to_address1', '收货地址1:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('ship_to_address1', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('ship_to_address2', '收货地址2:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('ship_to_address2', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('country_of_consignee', '收货国家:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('country_of_consignee', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('buyer_name', '买方名称:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('buyer_name', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('buyer_code', '买方代码:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('buyer_code', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('garment_customer_name', '服装客户名称:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('garment_customer_name', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('garment_customer_code', '服装客户代码:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('garment_customer_code', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('number_of_line_items', '订单项数量:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('number_of_line_items', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

