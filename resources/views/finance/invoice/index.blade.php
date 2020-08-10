@extends('navbarerp')

@section('title', '发票信息')

@section('main')
    <div class="panel-heading">
        <a href="/finance/invoice/create" class="btn btn-sm btn-success">新建</a>
        <a href="/finance/invoice/import" class="btn btn-sm btn-success">导入</a>
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

        {!! Form::open(['url' => '/finance/invoice/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::text('invno', null, ['class' => 'form-control', 'placeholder' => '发票号']) !!}
            {!! Form::text('departno', null, ['class' => 'form-control', 'placeholder' => '部门']) !!}
            {!! Form::text('customer', null, ['class' => 'form-control', 'placeholder' => '客户']) !!}

            {!! Form::label('invstartdatelabel', '日期:', ['class' => 'control-label']) !!}
            {!! Form::date('s_invdate', null, ['class' => 'form-control']) !!}
            {!! Form::label('invdatelabelto', '-', ['class' => 'control-label']) !!}
            {!! Form::date('e_invdate', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($invoices->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>发票号</th>
                    <th>部门</th>
                    <th style="width: 300px">客户</th>
                    <th>日期</th>
                    <th>PMJ/JINTEX收钱金额</th>
                    <th>WUXI收钱金额</th>
                    <th>预计收汇日期</th>
                    <th>收汇日</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>
                            {{ $invoice->invno }}
                        </td>
                        <td>
                            {{ $invoice->departno }}
                        </td>
                        <td>
                            {{ $invoice->customer }}
                        </td>
                        <td>
                            {{ $invoice->invdate }}
                        </td>
                        <td>
                            {{ $invoice->payamount_jintex }}
                        </td>
                        <td>
                            {{ $invoice->payamount_wuxi }}
                        </td>
                        <td>
                            {{ $invoice->fore_paydate }}
                        </td>
                        <td>
                            {{ $invoice->paydate }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/finance/invoice/'.$invoice->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('invoice.destroy', $invoice->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $invoices->setPath('/finance/invoice')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
