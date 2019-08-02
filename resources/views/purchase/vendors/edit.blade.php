@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($vendor, ['method' => 'PATCH', 'action' => ['Purchase\VendorController@update', $vendor->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.vendors._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

