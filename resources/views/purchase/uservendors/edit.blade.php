@extends('navbarerp')

@section('main')
    <h1>编辑(Edit)</h1>
    <hr/>
    
    {!! Form::model($uservendor, ['method' => 'PATCH', 'action' => ['Purchase\UservendorController@update', $uservendor->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.uservendors._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

