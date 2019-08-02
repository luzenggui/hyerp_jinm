@extends('navbarerp')

@section('main')
    <h1>查看(View)</h1>
    <hr/>

    {!! Form::model($shipment, ['class' => 'form-horizontal']) !!}
        @include('shipment.shipments._form',
            [
                'attr' => 'readonly',
                'btnclass' => 'hidden',
                'submitButtonText' => '保存(Save)',
            ]
        )
    {!! Form::close() !!}

    @include('errors.list')
@stop
