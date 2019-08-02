@extends('navbarerp')

@section('main')
    <h1>导入卷</h1>
    <hr/>
    
    {!! Form::open(['url' => 'purchase/purchaseorders/' . $pohead_id . '/storeimportpacking', 'class' => 'form-horizontal', 'files' => true]) !!}
    <div class="form-group">
        {!! Form::label('file', '选择Excel文件:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
        <div class='col-xs-8 col-sm-10'>
            <div class="row">
                {!! Form::file('file', []) !!}
            </div>
        </div>

        {{ Form::hidden('pohead_id', $pohead_id) }}

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('导入', ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
