@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($asnorder, ['method' => 'PATCH', 'action' => ['Purchase\AsnorderController@update', $asnorder->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.asnorders._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}

    @include('errors.list')

    @include('purchase.purchaseorders._selectpoheadmodal')
@endsection

@section('script')
    @include('purchase.purchaseorders._selectpoheadjs')
@endsection
