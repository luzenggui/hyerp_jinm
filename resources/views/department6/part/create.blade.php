@extends('navbarerp')

@section('main')
    <h1>添加部位资料</h1>
    <hr/>
    
    {!! Form::open(['url' => 'department6/part', 'class' => 'form-horizontal']) !!}
        @include('department6.part._form', ['submitButtonText' => '添加(Add)', 'attr' => '','btnclass' => 'btn btn-primary',])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
