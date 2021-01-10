@extends('navbarerp')

@section('main')
    <h1>添加打卡记录</h1>
    <hr/>
    
    {!! Form::open(['url' => 'personal/checkrecords', 'class' => 'form-horizontal']) !!}
        @include('personal.checkrecords._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
                'inputdate'=>date('Y-m-d',time()),
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
