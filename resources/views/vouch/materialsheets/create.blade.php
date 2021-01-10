@extends('navbarerp')

@section('main')
    <h1>添加成品表单信息</h1>
    <hr/>
    
    {!! Form::open(['url' => 'vouch/finishproductsheets', 'class' => 'form-horizontal']) !!}
        @include('vouch.finishproductsheets._form',
            [
                'submitButtonText' => '添加',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}

    
    @include('errors.list')
@stop
