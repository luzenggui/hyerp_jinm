@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        @if (Auth::user()->email === "admin@admin.com")
        <a href="reports/create" class="btn btn-sm btn-success">新建(New)</a>
        @endif
        {{--
        <div class="pull-right" style="padding-top: 4px;">
            <a href="{{ URL::to('system/depts') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{'部门管理', [], 'layouts'}}</a>
        </div>
        --}}
    </div>
    
    @if ($reports->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>名称(Name)</th>
                @if (!isset($readonly))
                    <th>模块</th>
                @endif
                <th>描述(Description)</th>
                <th>统计(Statistics)</th>
                @if (!isset($readonly))
                    <th width="120">操作</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>
                        {{ $report->name }}
                    </td>
                    @if (!isset($readonly))
                        <td>
                            {{ $report->module }}
                        </td>
                    @endif
                    <td>
                        {{ $report->descrip }}
                    </td>
                    <td>
                        <a href="{{ URL::to('/system/reports/'.$report->id.'/statistics/' . $report->autostatistics) }}" class="btn btn-success btn-sm" target="_blank">统计</a>
                    </td>
                    @if (!isset($readonly))
                    <td>
                        <a href="{{ URL::to('/system/reports/'.$report->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('reports.destroy', $report->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $reports->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    

@stop
