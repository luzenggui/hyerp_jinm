@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($finishproductsheet, ['method' => 'PATCH', 'action' => ['Vouch\FinishproductsheetController@update', $finishproductsheet->id], 'class' => 'form-horizontal']) !!}
        @include('vouch.finishproductsheets._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

