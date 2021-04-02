@extends('navbarerp')

@section('title', '宠物装箱信息')

@section('main')
    <div class="panel-heading">
        {{--<a href="/shipment/packinglists/create" class="btn btn-sm btn-success">新建</a>--}}
        {{--<a href="/shipment/packinglists/import" class="btn btn-sm btn-success">导入</a>--}}
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

        {!! Form::open(['url' => '/shipment/packinglists/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::text('fph', null, ['class' => 'form-control', 'placeholder' => '公司发票号']) !!}
            {!! Form::text('hth', null, ['class' => 'form-control', 'placeholder' => '合同号']) !!}

            {!! Form::label('startdate_vanning', '装箱日期:', ['class' => 'control-label']) !!}
            {!! Form::date('startdate_vanning', null, ['class' => 'form-control']) !!}
            {!! Form::label('enddatelabelto', '-', ['class' => 'control-label']) !!}
            {!! Form::date('enddate_vanning', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($packinglists->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>公司发票号</th>
                    <th>公司合同号</th>
                    <th>客人PO#</th>
                    <th>DPCI#</th>
                    <th>总数量</th>
                    <th>总箱数</th>
                    <th>体积</th>
                    <th>总毛重</th>
                    <th>总净重</th>
                    <th>箱型箱量</th>
                    <th>集装箱号</th>
                    <th>装箱日期</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($packinglists as $packinglist)
                    <tr>
                        <td>
                            {{ $packinglist->fph }}
                        </td>
                        <td>
                            {{ $packinglist->hth }}
                        </td>
                        <td>
                            {{ $packinglist->po }}
                        </td>
                        <td>
                            {{ $packinglist->dpci }}
                        </td>
                        <td>
                            {{ $packinglist->total_quantity }}
                        </td>
                        <td>
                            {{ $packinglist->quantity_box }}
                        </td>
                        <td>
                            {{ $packinglist->volume }}
                        </td>
                        <td>
                            {{ $packinglist->gross_weight }}
                        </td>
                        <td>
                            {{ $packinglist->net_weight }}
                        </td>
                        <td>
                            {{ $packinglist->boxspec }}
                        </td>
                        <td>
                            {{ $packinglist->boxno }}
                        </td>
                        <td>
                            {{ $packinglist->date_vanning }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/shipment/packinglists/'.$packinglist->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/nxshipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('packinglists.destroy', $packinglist->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $packinglists->setPath('/shipment/packinglists')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
