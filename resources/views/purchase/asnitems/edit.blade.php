@extends('navbarerp')

@section('main')
    <h1>编辑</h1>
    <hr/>
    
    {!! Form::model($asnitem, ['method' => 'PATCH', 'action' => ['Purchase\AsnitemController@update', $asnitem->id], 'class' => 'form-horizontal']) !!}
        @include('purchase.asnitems._form', ['submitButtonText' => '保存'])
    {!! Form::close() !!}
    
    @include('errors.list')
@stop

