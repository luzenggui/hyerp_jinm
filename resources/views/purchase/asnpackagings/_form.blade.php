{{--<div class="form-group">--}}
    {{--{!! Form::label('poitem_id', '物料:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::select('poitem_id', $poitemList, null, ['class' => 'form-control', 'placeholder' => '--选择物料--']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('poitemroll_numbers', '卷号:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--@if (isset($asnpackaging))--}}
            {{--{!! Form::text('poitemroll_numbers', $asnpackaging->asnitems, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPoitemrollModal', 'data-poitem_id' => $asnpackaging->poitem_id]) !!}--}}
        {{--@else--}}
            {{--{!! Form::text('poitemroll_numbers', null, ['class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#selectPoitemrollModal']) !!}--}}
        {{--@endif--}}
        {{--{!! Form::hidden('poitemroll_values', null, ['id' => 'poitemroll_values']) !!}--}}
    {{--</div>--}}
{{--</div>--}}

<div id="items">
</div>

{!! Form::hidden('items_string', null, ['id' => 'items_string']) !!}

{{--<div class="form-group">--}}
    {{--{!! Form::label('country_of_destination', '目的地:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
        {{--{!! Form::text('country_of_destination', null, ['class' => 'form-control', 'placeholder' => 'ISO Controy Number, Such as VNM.']) !!}--}}
    {{--</div>--}}
{{--</div>--}}




{!! Form::hidden('asnorder_id', $asnorder_id, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
    </div>
</div>

