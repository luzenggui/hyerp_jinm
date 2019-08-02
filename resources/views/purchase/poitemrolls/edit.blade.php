@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($poitemroll, ['method' => 'PATCH', 'action' => ['Purchase\PoitemrollController@update', $poitemroll->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.poitemrolls._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

