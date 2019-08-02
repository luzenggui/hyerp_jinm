<div class="form-group">
    {!! Form::label('pohead_number', '采购订单:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        @if (isset($asnorder))
            {!! Form::text('pohead_number', $asnorder->pohead->number, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPurchaseorderModal', 'data-id' => 'vendor_id']) !!}
        @else
            {!! Form::text('pohead_number', null, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPurchaseorderModal']) !!}
        @endif
        {{--{!! Form::text('pohead_number', null, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPurchaseorderModal']) !!}--}}
        {!! Form::hidden('pohead_id', null, ['id' => 'pohead_id']) !!}
    </div>
</div>


<div id="items">
</div>

{!! Form::hidden('items_string', null, ['id' => 'items_string']) !!}


{{--<div class="form-group">--}}
    {{--{!! Form::label('shipper_name', '发货人:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('shipper_name', null, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('country_of_origin', '原产地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('country_of_origin', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as CHN.']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('country_of_destination', '目的地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('country_of_destination', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as VNM.']) !!}--}}
    {{--</div>--}}
{{--</div>--}}




{!! Form::hidden('asnshipment_id', $asnshipment_id, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

