<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('inputdate', '填报日期:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('inputdate', isset($inputdate) ? $inputdate:null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('name', '姓名:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('name', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('telno', '联系方式:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('telno', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('department', '部门:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('department', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('address', '地址:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-9 col-sm-9'>
        {!! Form::text('address', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('temperature', '当日温度:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('temperature',  null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('stuation_self', '本人是否有以下症状:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('stuation_self', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('stuation_family', '家人是否有以下症状:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('stuation_family', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('other_note', '其他情况:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('other_note', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

