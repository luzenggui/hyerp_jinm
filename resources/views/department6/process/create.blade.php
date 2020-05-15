@extends('navbarerp')

@section('main')
    <h1>添加加工资料</h1>
    <hr/>
    
    {!! Form::open(['url' => 'department6/process', 'class' => 'form-horizontal']) !!}
        @include('department6.process._form', ['submitButtonText' => '添加(Add)', 'attr' => '','btnclass' => 'btn btn-primary',])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
