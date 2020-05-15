@extends('navbarerp')

@section('main')
    <h1>编辑(Edit)</h1>
    <hr/>
    
    {!! Form::model($ingredient, ['method' => 'PATCH', 'action' => ['Department6\IngredientController@update', $ingredient->id], 'class' => 'form-horizontal']) !!}
        @include('department6.ingredient._form', ['submitButtonText' => '保存(Save)','attr' => '','btnclass' => 'btn btn-primary',])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

