@extends('navbarerp')

@section('title', '移动端考勤信息')

@section('main')
    <div class="panel-heading">
        <a href="/personal/checkrecords/create" class="btn btn-sm btn-success">新建</a>
        <a href="/personal/checkrecords/import" class="btn btn-sm btn-success">导入</a>
        <a href="/personal/checkrecords/datasync" class="btn btn-sm btn-success">生成数据</a>
{{--        {!! Form::button('导出', [url('personal/checkrecords/export'),'class' => 'btn btn-success btn-sm', 'id' => 'btnExport']) !!}--}}
        {{--<a href="/personal/checkrecords/export" class="btn btn-sm btn-success">导出</a>--}}
        {!! Form::open(['url' => '/personal/checkrecords/export', 'class' => 'pull-right form-inline']) !!}
        <div class="form-group-sm">
            @foreach($inputs as $key=>$value)
                {!! Form::hidden($key, $value) !!}
            @endforeach
            {!! Form::submit('导出', ['class' => 'btn btn-success btn-sm ']) !!}
        </div>
        {!! Form::close() !!}

    </div>

    <div class="panel-body">
        {{--{!! Form::open(['url' => '/shipment/salarysheet/export', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('Export', ['class' => 'btn btn-default btn-sm']) !!}--}}
        {{--{!! Form::close() !!}--}}

        {!! Form::open(['url' => '/personal/checkrecords/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::label('checkrecord_datestartlabel', '登记日期:', ['class' => 'control-label']) !!}
            {!! Form::date('checkrecord_datestart', null, ['class' => 'form-control']) !!}
            {!! Form::label('checkrecord_datelabelto', '-', ['class' => 'control-label']) !!}
            {!! Form::date('checkrecord_dateend', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($checkrecords->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:100px">填报日期</th>
                    <th style="width:100px">姓名</th>
                    <th style="width:100px">联系方式</th>
                    <th style="width:100px">所属部门</th>
                    <th>当前所在位置</th>
                    <th style="width:100px">当日温度</th>
                    <th style="width:100px">本人是否有以下症状</th>
                    <th style="width:100px">家人是否有以下症状</th>
                    <th style="width:100px">其他情况</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($checkrecords as $checkrecord)
                    <tr>
                        <td>
                            {{ $checkrecord->inputdate }}
                        </td>
                        <td>
                            {{ $checkrecord->name }}
                        </td>
                        <td>
                            {{ $checkrecord->telno }}
                        </td>
                        <td>
                            {{ $checkrecord->department }}
                        </td>
                        <td>
                            {{ $checkrecord->address }}
                        </td>
                        <td>
                            {{ $checkrecord->temperature }}
                        </td>
                        <td>
                            {{ $checkrecord->stuation_self }}
                        </td>
                        <td>
                            {{ $checkrecord->stuation_family }}
                        </td>
                        <td>
                            {{ $checkrecord->other_note }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/personal/checkrecords/'.$checkrecord->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('checkrecords.destroy', $checkrecord->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $checkrecords->setPath('/personal/checkrecords')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
