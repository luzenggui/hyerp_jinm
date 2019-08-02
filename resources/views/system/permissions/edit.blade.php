@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($permission, ['method' => 'PATCH', 'action' => ['System\PermissionController@update', $permission->id], 'class' => 'form-horizontal']) !!}
        @include('system.permissions._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

