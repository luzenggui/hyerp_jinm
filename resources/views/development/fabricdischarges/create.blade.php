@extends('navbarerp')

@section('main')
    <h1>添加排料申请</h1>
    <hr/>
    
    {!! Form::open(['url' => 'development/fabricdischarges', 'class' => 'form-horizontal']) !!}
        @include('development.fabricdischarges._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
