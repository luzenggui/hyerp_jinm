<div class="form-group">
    {!! Form::label('poitemc_material_code', '物料代码:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('poitemc_material_code', $poitem->poitemc->material_code, ['class' => 'form-control', $attr, 'readonly']) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('duedate', '到期日:') !!}--}}
    {{--{!! Form::input('date', 'duedate', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::label('quantity', '数量:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('quantity', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::label('qty_ordered', '数量:') !!}--}}
    {{--{!! Form::text('qty_ordered', '0.0', ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('unitprice', '单价:') !!}--}}
    {{--{!! Form::text('unitprice', '0.0', ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('comments', '备注:') !!}--}}
    {{--{!! Form::text('comments', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::label('freight', '运费:') !!}--}}
    {{--{!! Form::text('freight', '0.0', ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{!! Form::hidden('pohead_id', $headId, ['class' => 'form-control']) !!}

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

