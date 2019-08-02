<div class="form-group">
    {!! Form::label('quantity_shipped', '发货数量:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('quantity_shipped', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('gross_weight', '毛重:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('gross_weight', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('gross_unit', '毛重单位:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('gross_unit', null, ['class' => 'form-control']) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('fabric_width', '宽度:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('fabric_width', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('fabric_unit', '宽度单位:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('fabric_unit', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('qa_status', '质量状态:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('qa_status', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('net_weight', '净重:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('net_weight', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('net_unit', '净重单位:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('net_unit', null, ['class' => 'form-control']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('ucc_number', 'UCC编号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('ucc_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('roll_number', '卷号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('roll_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('remark', '备注:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::textarea('remark', null, ['class' => 'form-control', 'rows' => 3]) !!}
    </div>
</div>



{{--<div class="form-group">--}}
    {{--{!! Form::label('color_desc3', '颜色3:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('color_desc3', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('color_desc4', '颜色4:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('color_desc4', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('color_desc5', '颜色5:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('color_desc5', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('quantity_per_color', '每种颜色数量:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('quantity_per_color', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('shipment_date', '发货日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::date('shipment_date', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{!! Form::hidden('asnpackaging_id', $asnpackaging_id, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

