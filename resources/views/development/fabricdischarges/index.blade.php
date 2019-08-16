@extends('navbarerp')
@section('title', '排料申请')
@section('main')

    <div class="panel-heading">
        <a href="/development/fabricdischarges/create" class="btn btn-sm btn-success">新建</a>
    </div>

    <div class="panel-body">
        {{--{!! Form::label('cntuserlabel1', '在你前面还有', ['class' => 'control-label h3']) !!}--}}
        {{--{!! Form::label('0', $cntuser, ['class' => 'control-label h1']) !!}--}}
        {{--<label for="cntuserlabel2" class="control-label h1">{{ $cntuser }}</label>--}}
{{--        {{ Form::label('cntuserlabel4', "0", ['class' => 'control-label h1']) }}--}}
        {{--{!! Form::label('cntuserlabel3', '位排队,请耐心等待', ['class' => 'control-label h3']) !!}--}}

        {!! Form::open(['url' => '/development/fabricdischarges/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}

        <div class="form-group-sm">
            {!! Form::select('status1', [0 => '未制版', 1 => '已制版'], null, ['class' => 'form-control', 'placeholder' => '--制版状态--']) !!}
            {!! Form::select('status2', [0 => '未排料', 1 => '已排料'], null, ['class' => 'form-control', 'placeholder' => '--排料状态--']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

    @if ($fabricdischarges->count())

    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:100px">等待数</th>
                <th>编号</th>
                <th>部门</th>
                <th>联系人</th>
                <th style="width:100px">联系人电话</th>
                <th>款号</th>
                <th>版号</th>
                <th style="width: 50px">时效</th>
                <th style="width: 100px">提交日期</th>
                <th style="width: 150px">创建人</th>
                <th>制版状态</th>
                <th>排料状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fabricdischarges as $fabricdischarge)
                <tr>
                    <td>
                        @if($fabricdischarge->flag2<>0)
                            {{""}}
                        @else
                            {{ $fabricdischarge->getnumber($fabricdischarge->id) }}
                        @endif
                    </td>
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
                        @if($fabricdischarge->flag1==0)
                            {{"未制版"}}
                        @elseif($fabricdischarge->flag1==1)
                            {{"已制版"}}
                        @endif
                    </td>
                    <td>
                        @if($fabricdischarge->flag2==0)
                            {{"未排料"}}
                        @elseif($fabricdischarge->flag2==1)
                            {{"已排料"}}
                        @endif
                    </td>
                    <td>
                        @can('fabricdischarge_finish')

                         {{--{!! Form::open(array('url' => 'development/fabricdischarges/' . $fabricdischarge->id . '/finish',  'onsubmit' => 'return confirm("确定完成此记录?");')) !!}--}}
                         {!! Form::submit( $fabricdischarge->flag1 == 1 ? '已制版' : '制版',['class'=>'btn btn-warning btn-sm pull-left ','data-toggle' => 'modal', 'data-target' => '#inputNumModal','data-type'=>'num1', 'data-frabricid'=>$fabricdischarge->id,$fabricdischarge->flag1 == 1 ? 'disabled' : 'abled'])!!}
                         {{--{!! Form::text('num1', null, ['class' => ' pull-left ','size'=>'5px','placeholder'=>'数量','id'=>'num1']) !!}--}}
                         {{--{!! Form::close() !!}--}}

                         {{--{!! Form::open(array('url' => 'development/fabricdischarges/' . $fabricdischarge->id . '/finish2', 'onsubmit' => 'return confirm("确定完成此记录?");')) !!}--}}
                         {!! Form::submit( $fabricdischarge->flag2 == 1 ? '已排料' : '排料',['class'=>'btn btn-warning btn-sm pull-left', 'data-toggle' => 'modal', 'data-target' => '#inputNumModal','data-type'=>'num2', 'data-frabricid'=>$fabricdischarge->id,$fabricdischarge->flag2 == 1 ? 'disabled' : 'abled'])!!}

                          {{--{!! Form::close() !!}--}}
                        @endcan
                        <a href="{{ URL::to('/development/fabricdischarges/'.$fabricdischarge->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('fabricdischarges.destroy', $fabricdischarge->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm pull-left']) !!}
                        {!! Form::close() !!}
                        <a href="{{ URL::to('/development/fabricdischarges/'.$fabricdischarge->id . '/export') }}" class="btn btn-success btn-sm pull-left">导出</a>
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
    @include('development.fabricdischarges._inputnummodal')
@stop

@section('script')
    @include('development.fabricdischarges._inputnumjs')
@endsection