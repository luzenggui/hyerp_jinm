@extends('navbarerp')

@section('main')
    <h1>添加报表</h1>
    <hr/>
    
    {!! Form::open(['url' => 'system/reports', 'class' => 'form-horizontal']) !!}
        @include('system.reports._form', ['submitButtonText' => '添加'])
    {!! Form::close() !!}
    
    
@stop