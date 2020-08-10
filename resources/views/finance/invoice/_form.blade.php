<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('invno', '发票号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('invno', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('departno', '部门:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('departno', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('customer', '客户:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('customer', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('invdate', '日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('invdate', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('maker', '制单人:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('maker', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('productname', '品名:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('productname', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('pono', '合同号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('pono',  null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('factory', '生产工厂:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('factory', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('destination', '目的港:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('destination', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('shipdate', '出运日:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('shipdate', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('verification_no', '核销单号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('verification_no', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('shipcompany', '船公司:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('shipcompany', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('shipno', '运单号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('shipno', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('paymethod', '结汇方式:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('paymethod', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('quantity', '数量:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('quantity', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('payamount_jintex', 'PMJ/JINTEX收钱金额:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('payamount_jintex', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('payamount_wuxi', 'WUXI收钱金额:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('payamount_wuxi', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('fore_paydate', '预计收汇日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('fore_paydate', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('paydate', '收汇日:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('paydate', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('freight', '运费(RMB):', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('freight', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('remark', '备注:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('remark', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

