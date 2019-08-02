@extends('navbarerp')

@section('main')

    {!! Form::model($poitem, ['class' => 'form-horizontal']) !!}
    @include('purchaseorderc.poitemcs._form',
        [
            'submitButtonText' => '-',
            'attr' => 'readonly',
            'btnclass' => 'hidden',
        ])
    {!! Form::close() !!}

@endsection