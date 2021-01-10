@extends('navbarerp')

@section('title', 'JPTE物料表单')

@section('main')
    <div class="panel-heading">
        {{--<a href="/vouch/materialsheets/create" class="btn btn-sm btn-success">新建</a>--}}
        <a href="/vouch/materialsheets/import" class="btn btn-sm btn-success">导入</a>
{{--        {!! Form::button('导出', [url('personal/checkrecords/export'),'class' => 'btn btn-success btn-sm', 'id' => 'btnExport']) !!}--}}
        {{--<a href="/personal/checkrecords/export" class="btn btn-sm btn-success">导出</a>--}}
        {!! Form::open(['url' => '/vouch/materialsheets/export', 'class' => 'pull-right form-inline']) !!}
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

        {!! Form::open(['url' => '/vouch/materials/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::label('mt_codelabel', '代码:', ['class' => 'control-label']) !!}
            {!! Form::text('mt_code', null, ['class' => 'form-control']) !!}
            {!! Form::label('mt_namelabel', '品名', ['class' => 'control-label']) !!}
            {!! Form::text('mt_name', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($materialsheets->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th >发票编号</th>
                    <th >合同编号</th>
                    <th >代码</th>
                    <th >品名</th>
                    <th >品名/Name</th>
                    <th >数量</th>
                    <th >金额</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materialsheets as $materialsheet)
                    <tr>
                        <td >
                            {{ $materialsheet->invoiceno }}
                        </td>
                        <td >
                            {{ $materialsheet->sheetno }}
                        </td>
                        <td >
                            {{ $materialsheet->materialcode->code }}
                        </td>
                        <td >
                            {{ $materialsheet->materialcode->ch_name }}
                        </td>
                        <td >
                            {{ $materialsheet->materialcode->en_name }}
                        </td>
                        <td >
                            {{ $materialsheet->qty }}
                        </td>
                        <td >
                            {{ $materialsheet->amount }}
                        </td>
                        {{--<td>--}}
                            {{--<a href="{{ URL::to('/vouch/materialsheets/'.$materialsheet->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>--}}
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {{--{!! Form::open(array('route' => array('materialsheets.destroy', $materialsheet->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}--}}
                            {{--{!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}--}}
                            {{--{!! Form::close() !!}--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $materialsheets->setPath('/vouch/materialsheets')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
