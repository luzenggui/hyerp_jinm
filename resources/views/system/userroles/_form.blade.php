<div class="form-group">
    {!! Form::label('name', '姓名:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('name', $user->name, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('role_id', '角色:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::select('role_id', $roleList, null, ['class' => 'form-control']) !!}
    </div>
</div>


{!! Form::hidden('user_id', $user->id, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>

