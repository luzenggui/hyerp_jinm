@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($purchaseorder, ['method' => 'PATCH', 'action' => ['Purchaseorderc\PurchaseordercController@update', $purchaseorder->id], 'class' => 'form-horizontal']) !!}
        @include('purchaseorderc.purchaseordercs._form',
            [
                'submitButtonText' => '保存',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

