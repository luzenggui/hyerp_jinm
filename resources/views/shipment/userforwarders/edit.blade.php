@extends('navbarerp')

@section('main')
    <h1>编辑(Edit)</h1>
    <hr/>
    
    {!! Form::model($userforwarder, ['method' => 'PATCH', 'action' => ['Shipment\UserforwarderController@update', $userforwarder->id], 'class' => 'form-horizontal']) !!}
        @include('shipment.userforwarders._form', ['submitButtonText' => '保存(Save)'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

