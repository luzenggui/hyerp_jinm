<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('code', '代码:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('code', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('ch_name', '品名:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('ch_name', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('en_name', '品名/Name:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-10 col-sm-10'>
        {!! Form::text('en_name', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

