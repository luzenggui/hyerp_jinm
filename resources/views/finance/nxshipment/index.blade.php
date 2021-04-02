@extends('navbarerp')

@section('title', '内销出运明细信息')

@section('main')
    <div class="panel-heading">
        <a href="/finance/nxshipment/create" class="btn btn-sm btn-success">新建</a>
        <a href="/finance/nxshipment/import" class="btn btn-sm btn-success">导入</a>
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

        {!! Form::open(['url' => '/finance/nxshipment/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::text('invoice_number', null, ['class' => 'form-control', 'placeholder' => '运编号']) !!}
            {!! Form::text('contract_number', null, ['class' => 'form-control', 'placeholder' => '合同号']) !!}
            {!! Form::text('customer_name', null, ['class' => 'form-control', 'placeholder' => '客户']) !!}
            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($nxshipments->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>客人</th>
                    <th>运编号</th>
                    <th>合同号</th>
                    <th>出运日期</th>
                    <th>出运表单</th>
                    <th>出运金额</th>
                    <th>合计开票金额</th>
                    <th>合计收款</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($nxshipments as $nxshipment)
                    <tr>
                        <td>
                            {{ $nxshipment->customer_name }}
                        </td>
                        <td>
                            {{ $nxshipment->invoice_number }}
                        </td>
                        <td>
                            {{ $nxshipment->contract_number }}
                        </td>
                        <td>
                            {{ $nxshipment->cyrq }}
                        </td>
                        <td>
                            {{ $nxshipment->cybd }}
                        </td>
                        <td>
                            {{ $nxshipment->amount_shipments }}
                        </td>
                        <td>
                            {{ $nxshipment->amount_hjkp }}
                        </td>
                        <td>
                            {{ $nxshipment->amount_hjsk }}
                        </td>
                        <td>
                            {{ $nxshipment->note }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/finance/nxshipment/'.$nxshipment->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/nxshipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('nxshipment.destroy', $nxshipment->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $nxshipments->setPath('/finance/nxshipment')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
