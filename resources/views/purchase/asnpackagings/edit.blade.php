@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($asnpackaging, ['method' => 'PATCH', 'action' => ['Purchase\AsnpackagingController@update', $asnpackaging->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.asnpackagings._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}

    @include('errors.list')

    @include('purchase.poitemrolls._selectpoitemrollmodal', ['poitem_id' => $asnpackaging->poitem_id])
@endsection

@section('script')
    @include('purchase.poitemrolls._selectpoitemrolljs')
@endsection
