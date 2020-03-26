@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($checkrecord, ['method' => 'PATCH', 'action' => ['Personal\CheckRecordController@update', $checkrecord->id], 'class' => 'form-horizontal']) !!}
        @include('personal.checkrecords._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

