@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($shipmentitem, ['method' => 'PATCH', 'action' => ['Shipment\ShipmentitemController@update', $shipmentitem->id], 'class' => 'form-horizontal']) !!}
        @include('shipment.shipmentitems._form', ['submitButtonText' => '保存(Save)'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

