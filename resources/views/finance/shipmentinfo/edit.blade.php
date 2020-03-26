@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($shipmentinfo, ['method' => 'PATCH', 'action' => ['Finance\ShipmentinfoController@update', $shipmentinfo->id], 'class' => 'form-horizontal']) !!}
        @include('finance.shipmentinfo._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

