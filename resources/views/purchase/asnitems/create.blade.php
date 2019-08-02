@extends('navbarerp')

@section('main')
    <h1>添加Item</h1>
    <hr/>

    {!! Form::open(['url' => 'purchase/asnitems', 'class' => 'form-horizontal']) !!}
    @include('purchase.asnitems._form', ['submitButtonText' => '添加'])
    {!! Form::close() !!}

    @include('errors.list')
@stop
