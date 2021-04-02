@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($nxshipment, ['method' => 'PATCH', 'action' => ['Finance\nxshipmentController@update', $nxshipment->id], 'class' => 'form-horizontal']) !!}
        @include('finance.nxshipment._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

