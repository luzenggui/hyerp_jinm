@extends('navbarerp')

@section('main')
    <h1>添加用户角色</h1>
    <hr/>
    
    {!! Form::open(['url' => 'system/users/' . $user->id . '/roles/store', 'class' => 'form-horizontal']) !!}
        @include('system.userroles._form', ['submitButtonText' => '添加'])
    {!! Form::close() !!}    


    
    @include('errors.list')
@stop
