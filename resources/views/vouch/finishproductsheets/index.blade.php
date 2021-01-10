@extends('navbarerp')

@section('title', 'JPTE成品表单')

@section('main')
    <div class="panel-heading">
        {{--<a href="/vouch/finishproductsheets/create" class="btn btn-sm btn-success">新建</a>--}}
        <a href="/vouch/finishproductsheets/import" class="btn btn-sm btn-success">导入</a>
{{--        {!! Form::button('导出', [url('personal/checkrecords/export'),'class' => 'btn btn-success btn-sm', 'id' => 'btnExport']) !!}--}}
        {{--<a href="/personal/checkrecords/export" class="btn btn-sm btn-success">导出</a>--}}
        {!! Form::open(['url' => '/vouch/finishproductsheets/export', 'class' => 'pull-right form-inline']) !!}
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

        {!! Form::open(['url' => '/vouch/finishproductsheets/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::label('mt_codelabel', '代码:', ['class' => 'control-label']) !!}
            {!! Form::text('mt_code', null, ['class' => 'form-control']) !!}
            {!! Form::label('mt_namelabel', '品名', ['class' => 'control-label']) !!}
            {!! Form::text('mt_name', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($finishproductsheets->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th >发票编号</th>
                    <th >合同编号</th>
                    <th >代码</th>
                    <th >类别</th>
                    <th >面料</th>
                    <th >海关代码</th>
                    <th >规格</th>
                    <th >颜色</th>
                    <th >数量</th>
                    <th >PI单价</th>
                    <th >PI金额</th>
                    <th >CM单价</th>
                    <th >CM金额</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($finishproductsheets as $finishproductsheet)
                    <tr>
                        <td >
                            {{ $finishproductsheet->invoiceno }}
                        </td>
                        <td >
                            {{ $finishproductsheet->sheetno }}
                        </td>
                        <td >
                            {{ $finishproductsheet->finishproductcode->fg_code }}
                        </td>
                        <td >
                            {{ $finishproductsheet->finishproductcode->type_name }}
                        </td>
                        <td >
                            {{ $finishproductsheet->finishproductcode->fabrics }}
                        </td>
                        <td >
                            {{ $finishproductsheet->finishproductcode->hs_code }}
                        </td>
                        <td>
                            {{ $finishproductsheet->patt }}
                        </td>
                        <td>
                            {{ $finishproductsheet->color }}
                        </td>
                        <td >
                            {{ $finishproductsheet->qty }}
                        </td>
                        <td >
                            {{ $finishproductsheet->unitprice }}
                        </td>
                        <td >
                            {{ $finishproductsheet->amount}}
                        </td>
                        <td >
                            {{ $finishproductsheet->cmunitprice }}
                        </td>
                        <td >
                            {{ $finishproductsheet->cmamount }}
                        </td>
                        {{--<td>--}}
                            {{--<a href="{{ URL::to('/vouch/finishproductsheets/'.$finishproductsheet->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>--}}
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {{--{!! Form::open(array('route' => array('finishproductsheets.destroy', $finishproductsheet->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}--}}
                            {{--{!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}--}}
                            {{--{!! Form::close() !!}--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $finishproductsheets->setPath('/vouch/finishproductsheets')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
