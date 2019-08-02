@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($poitem, ['method' => 'PATCH', 'action' => ['Purchase\PoitemController@update', $poitem->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.poitems._form',
            [
                'submitButtonText' => '保存',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

