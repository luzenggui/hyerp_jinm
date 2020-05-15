@extends('navbarerp')

@section('main')
    <h1>编辑(Edit)</h1>
    <hr/>
    
    {!! Form::model($part, ['method' => 'PATCH', 'action' => ['Department6\PartController@update', $part->id], 'class' => 'form-horizontal']) !!}
        @include('department6.part._form', ['submitButtonText' => '保存(Save)','attr' => '','btnclass' => 'btn btn-primary',])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

