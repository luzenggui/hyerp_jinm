@extends('navbarerp')

@section('main')
    <h1>添加Shipment</h1>
    <hr/>

    {!! Form::open(['url' => 'purchase/asnshipments/store', 'class' => 'form-horizontal']) !!}
    @include('purchase.asnshipments._form', ['submitButtonText' => '添加'])
    {!! Form::close() !!}

    @include('errors.list')
@stop
