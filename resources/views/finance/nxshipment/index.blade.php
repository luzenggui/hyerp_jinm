@extends('navbarerp')

@section('title', '出运明细信息')

@section('main')
    <div class="panel-heading">
        <a href="/finance/shipmentinfo/create" class="btn btn-sm btn-success">新建</a>
        <a href="/finance/shipmentinfo/import" class="btn btn-sm btn-success">导入</a>
{{--        {!! Form::button('导出', [url('personal/checkrecords/export'),'class' => 'btn btn-success btn-sm', 'id' => 'btnExport']) !!}--}}
        {{--<a href="/personal/checkrecords/export" class="btn btn-sm btn-success">导出</a>--}}
        {{--{!! Form::open(['url' => '/finance/packinfo/export', 'class' => 'pull-right form-inline']) !!}--}}
        {{--<div class="form-group-sm">--}}
            {{--@foreach($inputs as $key=>$value)--}}
                {{--{!! Form::hidden($key, $value) !!}--}}
            {{--@endforeach--}}
            {{--{!! Form::submit('导出', ['class' => 'btn btn-success btn-sm ']) !!}--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}
    </div>

    <div class="panel-body">
        {{--{!! Form::open(['url' => '/shipment/salarysheet/export', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('Export', ['class' => 'btn btn-default btn-sm']) !!}--}}
        {{--{!! Form::close() !!}--}}

        {!! Form::open(['url' => '/finance/shipmentinfo/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::text('t_pono', null, ['class' => 'form-control', 'placeholder' => '合同号']) !!}
            {!! Form::text('t_invoiceno', null, ['class' => 'form-control', 'placeholder' => '发票号']) !!}
            {!! Form::text('t_department', null, ['class' => 'form-control', 'placeholder' => '部门']) !!}
            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($shipmentinfos->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>部门</th>
                    <th style="width: 300px">客户</th>
                    <th>发票号</th>
                    <th>合同号</th>
                    <th>报关数量</th>
                    <th>报关金额</th>
                    <th>议付数量</th>
                    <th>议付金额</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shipmentinfos as $shipmentinfo)
                    <tr>
                        <td>
                            {{ $shipmentinfo->department }}
                        </td>
                        <td>
                            {{ $shipmentinfo->custname }}
                        </td>
                        <td>
                            {{ $shipmentinfo->invoiceno }}
                        </td>
                        <td>
                            {{ $shipmentinfo->pono }}
                        </td>
                        <td>
                            {{ $shipmentinfo->qty_bg }}
                        </td>
                        <td>
                            {{ $shipmentinfo->amount_bg }}
                        </td>
                        <td>
                            {{ $shipmentinfo->qty_yf }}
                        </td>
                        <td>
                            {{ $shipmentinfo->amount_yf }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/finance/shipmentinfo/'.$shipmentinfo->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('shipmentinfo.destroy', $shipmentinfo->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $shipmentinfos->setPath('/finance/shipmentinfo')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
