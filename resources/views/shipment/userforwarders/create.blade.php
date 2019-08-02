@extends('navbarerp')

@section('main')
    <h1>添加货代(Add User Forwarder)</h1>
    <hr/>
    
    {!! Form::open(['url' => 'shipment/userforwarders', 'class' => 'form-horizontal']) !!}
        @include('shipment.userforwarders._form', ['submitButtonText' => '添加(Add)'])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
