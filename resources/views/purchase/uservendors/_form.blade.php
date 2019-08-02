<div class="form-group">
    {!! Form::label('user_id', '用户:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::select('user_id', $vendoruserList, null, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('vendor_id', '供应商:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::select('vendor_id', $vendorList, null, ['class' => 'form-control', 'placeholder' => '--请选择--']) !!}
    </div>
</div>











<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

