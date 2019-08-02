@extends('navbarerp')

@section('main')
    <h1>添加用户供应商关系</h1>
    <hr/>
    
    {!! Form::open(['url' => 'purchase/uservendors', 'class' => 'form-horizontal']) !!}
        @include('purchase.uservendors._form', ['submitButtonText' => '添加'])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
