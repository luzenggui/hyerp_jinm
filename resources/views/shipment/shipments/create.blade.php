@extends('navbarerp')

@section('main')
    <h1>添加出运单(Add Shipment Order)</h1>
    <hr/>
    
    {!! Form::open(['url' => 'shipment/shipments', 'class' => 'form-horizontal', 'files' => true]) !!}
        @include('shipment.shipments._form',
            [
                'attr' => '',
                'btnclass' => 'btn btn-primary',
                'submitButtonText' => '添加(Add)',
            ]
        )
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
