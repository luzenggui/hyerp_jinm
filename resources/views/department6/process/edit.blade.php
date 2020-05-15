@extends('navbarerp')

@section('main')
    <h1>编辑(Edit)</h1>
    <hr/>
    
    {!! Form::model($process, ['method' => 'PATCH', 'action' => ['Department6\ProcessController@update', $process->id], 'class' => 'form-horizontal']) !!}
        @include('department6.process._form', ['submitButtonText' => '保存(Save)','attr' => '','btnclass' => 'btn btn-primary',])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

