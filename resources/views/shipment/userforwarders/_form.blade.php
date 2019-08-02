<div class="form-group">
    {!! Form::label('user_id', '用户(User):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::select('user_id', $forwarderuserList, null, ['class' => 'form-control', 'placeholder' => '--Please Select--']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('forwarder', '货代(Forwarder):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::select('forwarder', $forwarderList, null, ['class' => 'form-control', 'placeholder' => '--Please Select--']) !!}
    </div>
</div>













<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

