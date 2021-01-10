<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('fg_code', '代码:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('fg_code', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('type_name', '面料类别:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('type_name', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('fabrics', '面料:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('fabrics', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('hs_code', '海关编码:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('hs_code', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('memo', '备注:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('memo', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

