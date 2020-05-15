@extends('navbarerp')

@section('main')
    <h1>添加辅料资料</h1>
    <hr/>
    
    {!! Form::open(['url' => 'department6/ingredient', 'class' => 'form-horizontal']) !!}
        @include('department6.ingredient._form', ['submitButtonText' => '添加(Add)', 'attr' => '','btnclass' => 'btn btn-primary',])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
