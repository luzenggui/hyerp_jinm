@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($purchaseorder, ['method' => 'PATCH', 'action' => ['Purchase\PurchaseorderController@update', $purchaseorder->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.purchaseorders._form',
            [
                'submitButtonText' => '保存',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
    {!! Form::close() !!}
    
    @include('errors.list')

    @include('purchase.vendors._selectvendormodal')
@endsection

@section('script')
    @include('purchase.vendors._selectvendorjs')
@endsection
