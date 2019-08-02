@extends('navbarerp')

@section('main')
    <h1>添加ASN</h1>
    <hr/>
    
    {!! Form::open(['url' => 'purchase/asns', 'class' => 'form-horizontal']) !!}
        @include('purchase.asns._form', ['submitButtonText' => '添加'])
    {!! Form::close() !!}

    @include('purchase.purchaseorders._selectpoheadmodal')
    
    @include('errors.list')
@endsection

@section('script')
    @component('purchase.purchaseorders._selectpoheadjs')

    @endcomponent


@endsection