@extends('navbarerp')

@section('main')
    <h1>添加成品资料</h1>
    <hr/>
    
    {!! Form::open(['url' => 'vouch/finishproducts', 'class' => 'form-horizontal']) !!}
        @include('vouch.finishproducts._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
