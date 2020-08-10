@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($invoice, ['method' => 'PATCH', 'action' => ['Finance\InvoiceController@update', $invoice->id], 'class' => 'form-horizontal']) !!}
        @include('finance.invoice._form',
        [
            'submitButtonText' => '保存',
            'attr' => '',
            'btnclass' => 'btn btn-primary',
        ])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

