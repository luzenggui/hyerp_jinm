@extends('navbarerp')

@section('main')
    <h1>添加原材料信息</h1>
    <hr/>
    
    {!! Form::open(['url' => 'vouch/materials', 'class' => 'form-horizontal']) !!}
        @include('vouch.materials._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
