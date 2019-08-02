@extends('navbarerp')

@section('main')
    <h1>添加Shipment(Add Shipment Item)</h1>
    <hr/>

    {!! Form::open(['url' => 'shipment/shipmentitems', 'class' => 'form-horizontal']) !!}
    @include('shipment.shipmentitems._form', ['submitButtonText' => '添加(Add)'])
    {!! Form::close() !!}

    @include('errors.list')
@stop
