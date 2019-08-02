@extends('navbarerp')
@section('title', '排料申请')
@section('main')

    <div class="panel-heading">
        <a href="/development/fabricdischarges/create" class="btn btn-sm btn-success">新建</a>
    </div>

    <div class="panel-body">
        {!! Form::label('cntuserlabel1', '在你前面还有', ['class' => 'control-label h3']) !!}
        {!! Form::label('0', $cntuser, ['class' => 'control-label h1']) !!}
        {{--<label for="cntuserlabel2" class="control-label h1">{{ $cntuser }}</label>--}}
{{--        {{ Form::label('cntuserlabel4', "0", ['class' => 'control-label h1']) }}--}}
        {!! Form::label('cntuserlabel3', '位排队,请耐心等待', ['class' => 'control-label h3']) !!}

        {!! Form::open(['url' => '/development/fabricdischarges/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}

        <div class="form-group-sm">
            {!! Form::select('status', [0 => '未完成', 1 => '已完成'], null, ['class' => 'form-control', 'placeholder' => '--申请状态--']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}
    @if ($fabricdischarges->count())

    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>编号</th>
                <th>部门</th>
                <th>联系人</th>
                <th>联系人电话</th>
                <th>款号</th>
                <th>版号</th>
                <th style="width: 50px">时效</th>
                <th style="width: 100px">提交日期</th>
                <th>创建人</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fabricdischarges as $fabricdischarge)
                <tr>
                    <td>
                        {{ $fabricdischarge->id }}
                    </td>
                    <td>
                        {{ $fabricdischarge->department }}
                    </td>
                    <td>
                        {{ $fabricdischarge->contactor }}
                    </td>
                    <td>
                        {{ $fabricdischarge->contactor_tel }}
                    </td>
                    <td>
                        {{ $fabricdischarge->style }}
                    </td>
                    <td>
                        {{ $fabricdischarge->version }}
                    </td>
                    <td>
                        {{ $fabricdischarge->status }}
                    </td>
                    <td>
                        {{ $fabricdischarge->applydate }}
                    </td>
                    <td>
                        {{ $fabricdischarge->createname }}
                    </td>
                    <td>
                        @can('fabricdischarge_finish')
                        {!! Form::open(array('url' => 'development/fabricdischarges/' . $fabricdischarge->id . '/finish',  'onsubmit' => 'return confirm("确定完成此记录?");')) !!}
                        {!! Form::submit( $fabricdischarge->flag == 1 ? '已完成' : '完成',['class'=>'btn btn-warning btn-sm pull-left', $fabricdischarge->flag == 1 ? 'disabled' : 'abled'])!!}
                        {!! Form::close() !!}
                        @endcan
                        <a href="{{ URL::to('/development/fabricdischarges/'.$fabricdischarge->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('fabricdischarges.destroy', $fabricdischarge->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm pull-left']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>


    </table>
    {!! $fabricdischarges->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif

    </div>

@stop
