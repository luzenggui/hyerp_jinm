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
    {!! Form::label('code', '成品代码:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if (isset($finishproductsheet->finishproductcode))
            {!! Form::text('code', $finishproductsheet->finishproductcode->name, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @else
            {!! Form::text('code', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('type_name', '类别:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if (isset($finishproductsheet->finishproductcode))
            {!! Form::text('type_name', $finishproductsheet->finishproductcode->type_name, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @else
            {!! Form::text('type_name', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('fabrics', '面料:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if (isset($finishproductsheet->finishproductcode))
            {!! Form::text('fabrics', $finishproductsheet->finishproductcode->fabrics, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @else
            {!! Form::text('fabrics', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('hs_code', '海关代码:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        @if (isset($finishproductsheet->finishproductcode))
            {!! Form::text('hs_code', $finishproductsheet->finishproductcode->hs_code, ['class' => 'form-control', 'readonly' => 'true']) !!}
        @else
            {!! Form::text('hs_code', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
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
    {!! Form::label('unitprice', 'PI单价:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('unitprice', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount', 'PI金额:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('amount', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('cmunitprice', 'CM单价:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('cmunitprice', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('cmamount', 'CM金额:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('cmamount', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

