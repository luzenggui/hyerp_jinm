<div class="form-group">
    {!! Form::label('invoiceno', '发票编号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('invoiceno', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contractno', '合同编号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('contractno', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('code', '代码:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if(isset($materialsheet->materialcode))
            {!! Form::text('code', $materialsheet->materialcode->code, ['class' => 'form-control', $attr,'readonly' => 'true']) !!}
        @else
            {!! Form::text('code', null, ['class' => 'form-control', $attr,'readonly' => 'true']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('ch_name', '品名:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if(isset($materialsheet->materialcode))
            {!! Form::text('ch_name', $materialsheet->materialcode->name, ['class' => 'form-control', $attr,'readonly' => 'true']) !!}
        @else
            {!! Form::text('ch_name', null, ['class' => 'form-control', $attr,'readonly' => 'true']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('en_name', '品名/Name:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if(isset($materialsheet->materialcode))
            {!! Form::text('en_name', $materialsheet->materialcode->en_name, ['class' => 'form-control', $attr,'readonly' => 'true']) !!}
        @else
            {!! Form::text('en_name', null, ['class' => 'form-control', $attr,'readonly' => 'true']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('qty', '数量:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('qty', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount', '金额:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('amount', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

