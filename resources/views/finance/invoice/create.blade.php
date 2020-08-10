@extends('navbarerp')

@section('main')
    <h1>添加发票记录</h1>
    <hr/>
    
    {!! Form::open(['url' => 'finance/invoice', 'class' => 'form-horizontal']) !!}
        @include('finance.invoice._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
