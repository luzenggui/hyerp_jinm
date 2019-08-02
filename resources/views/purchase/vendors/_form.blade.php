<div class="form-group">
    {!! Form::label('number', '编号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('number', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', '名称:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('name', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


{{--<div class="form-group">--}}
    {{--{!! Form::label('term_id', '付款方式:') !!}--}}
    {{--{!! Form::select('term_id', $termList, null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('shipvia', '承运商:') !!}--}}
    {{--{!! Form::text('shipvia', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('vendtype_id', '供应商类型:') !!}--}}
    {{--{!! Form::select('vendtype_id', $vendtypeList, null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('contact_name1', '联系人1:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('contact_name1', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contact_phone1', '联系电话1:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('contact_phone1', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contact_name2', '联系人2:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('contact_name2', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contact_phone2', '联系电话2:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('contact_phone2', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('addr_id', '地址:') !!}--}}
    {{--{!! Form::select('addr_id', $addrList, null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

