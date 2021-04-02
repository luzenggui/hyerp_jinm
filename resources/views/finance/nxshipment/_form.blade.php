<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('customer_name', '客人:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('customer_name', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('invoice_number', '运编号:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('invoice_number', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contract_number', '合同号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('contract_number', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('cyrq', '出运日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('cyrq', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('cybd', '出运表单:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('cybd', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('amount_shipments', '出运金额:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_shipments', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('amount_hjkp', '合计开票金额:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_hjkp',  null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('amount_hjsk', '合计收款:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_hjsk', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('note', '备注:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('note', null, ['class' => 'form-control', $attr]) !!}
    </div>


</div>

<div class="form-group">
    {!! Form::label('amount_kp1', '开票1#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_kp1', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_kp1', '开票日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_kp1', null, ['class' => 'form-control', $attr]) !!}
    </div>


</div>

<div class="form-group">
    {!! Form::label('amount_kp2', '开票2#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_kp2', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_kp2', '开票日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_kp2', null, ['class' => 'form-control', $attr]) !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('amount_kp3', '开票3#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_kp3', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_kp3', '开票日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_kp3', null, ['class' => 'form-control', $attr]) !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('amount_kp4', '开票4#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_kp4', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_kp4', '开票日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_kp4', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount_kp5', '开票5#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_kp5', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_kp5', '开票日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_kp5', null, ['class' => 'form-control', $attr]) !!}
    </div>

</div>


<div class="form-group">
    {!! Form::label('amount_sk1', '收款1#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_sk1', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_sk1', '收款日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_sk1', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount_sk2', '收款2#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_sk2', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_sk2', '收款日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_sk2', null, ['class' => 'form-control', $attr]) !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('amount_sk3', '收款3#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_sk3', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_sk3', '收款日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_sk3', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount_sk4', '收款4#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_sk4', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_sk4', '收款日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_sk4', null, ['class' => 'form-control', $attr]) !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('amount_sk5', '收款5#:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('amount_sk5', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('date_sk5', '收款日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('date_sk5', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('note1', '备注:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('note1', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

