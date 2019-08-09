<div class="form-group">
    {{--<div class="col-xs-2 col-sm-2">部门:</div>--}}
    {!! Form::label('department', '部门:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::select('department', array('一部' => '一部', '二部' => '二部', '三部' => '三部', '五部' => '五部', '六部' => '六部', '八部' => '八部','九部' => '九部'),null, ['class' => 'form-control', 'placeholder' => '--请选择--', $attr]) !!}
    </div>

    {!! Form::label('contactor', '联系人:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('contactor', isset($fabricdischarge->contactor) ? $fabricdischarge->contactor: Auth()->user()->name, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('contactor_tel', '联系人电话:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('contactor_tel', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('style', '款号:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('style', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('version', '版号:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('version', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('applydate', '日期:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::date('applydate', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('status', '时效:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::select('status', array( '正常' => '正常','紧急' => '紧急',), ['class' => 'form-control',  'placeholder' => '--请选择--',$attr]) !!}
    </div>

    {!! Form::label('style_des', '款式描述:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('style_des', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('fabric_specification', '面料成分规格:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('fabric_specification', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('weight', '克重:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('weight', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>



<div class="form-group">
    {!! Form::label('width', '有效门幅:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('width', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('lattice_cycle', '格子循环:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-8 col-sm-4'>
        {!! Form::text('lattice_cycle', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('requirement', '对格对条要求:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('requirement', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('fabric_shrikage_grain', '面料缩率 经向:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('fabric_shrikage_grain',isset($fabricdischarge->fabric_shrikage_grain) ? $fabricdischarge->fabric_shrikage_grain: '2'  , ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('fabric_shrikage_zonal', '面料缩率 纬向:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-4 col-sm-4'>
        {!! Form::text('fabric_shrikage_zonal', isset($fabricdischarge->fabric_shrikage_grain) ? $fabricdischarge->fabric_shrikage_grain: '2', ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('quantity', '数量:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-8 col-sm-4'>
        {!! Form::text('quantity', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('size_allotment', '尺码搭配:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::text('size_allotment', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('XXS', 'XXS:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('XXS', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('XS', 'XS:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('XS', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('S', 'S:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('S', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('M', 'M:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('M', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('L', 'L:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('L', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('XL', 'XL:', ['class' => 'col-xs-2 col-sm-2 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('XL', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('XXL', 'XXL:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('XXL', null, ['class' => 'form-control', $attr]) !!}
    </div>

    {!! Form::label('XXXL', 'XXXL:', ['class' => 'col-xs-1 col-sm-1 control-label']) !!}
    <div class='col-xs-1 col-sm-1'>
        {!! Form::text('XXXL', null, ['class' => 'form-control', $attr]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('note', '排料及用料记录:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
    <div class='col-xs-8 col-sm-10'>
        {!! Form::textarea('note', null, ['class' => 'form-control ', $attr,'rows' => 3]) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>

