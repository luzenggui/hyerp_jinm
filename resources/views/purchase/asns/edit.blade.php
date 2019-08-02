@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($asn, ['method' => 'PATCH', 'action' => ['Purchase\AsnController@update', $asn->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.asns._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}

    @include('purchase.purchaseorders._selectpoheadmodal')

    @include('errors.list')
@endsection

@section('script')
    @component('purchase.purchaseorders._selectpoheadjs')

    @endcomponent

@endsection
