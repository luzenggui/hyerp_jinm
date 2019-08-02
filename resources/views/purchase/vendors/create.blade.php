@extends('navbarerp')

@section('main')
    <h1>添加供应商</h1>
    <hr/>
    
    {!! Form::open(['url' => 'purchase/vendors', 'class' => 'form-horizontal']) !!}
        @include('purchase.vendors._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
