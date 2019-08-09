@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($fabricdischarge, ['method' => 'PATCH', 'action' => ['Development\FabricdischargeController@update', $fabricdischarge->id], 'class' => 'form-horizontal']) !!}
        @include('development.fabricdischarges._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

