@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($material, ['method' => 'PATCH', 'action' => ['Vouch\MaterialController@update', $material->id], 'class' => 'form-horizontal']) !!}
        @include('vouch.materials._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

