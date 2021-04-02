@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($packinglist, ['method' => 'PATCH', 'action' => ['Shipment\PackinglistController@update', $packinglist->id], 'class' => 'form-horizontal']) !!}
        @include('shipment.packinglists._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

