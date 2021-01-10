@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($finishproduct, ['method' => 'PATCH', 'action' => ['Vouch\FinishproductController@update', $finishproduct->id], 'class' => 'form-horizontal']) !!}
        @include('vouch.finishproducts._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

