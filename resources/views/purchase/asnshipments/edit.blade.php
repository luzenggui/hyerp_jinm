@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($asnshipment, ['method' => 'PATCH', 'action' => ['Purchase\AsnshipmentController@update', $asnshipment->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.asnshipments._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

