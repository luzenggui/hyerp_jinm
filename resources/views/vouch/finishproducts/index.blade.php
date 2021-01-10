@extends('navbarerp')

@section('title', 'JPTE FINAL FABRICS 成品号-规格表-代码表')

@section('main')
    <div class="panel-heading">
        <a href="/vouch/finishproducts/create" class="btn btn-sm btn-success">新建</a>
        <a href="/vouch/finishproducts/import" class="btn btn-sm btn-success">导入</a>
        {{--        {!! Form::button('导出', [url('personal/checkrecords/export'),'class' => 'btn btn-success btn-sm', 'id' => 'btnExport']) !!}--}}
        {{--<a href="/personal/checkrecords/export" class="btn btn-sm btn-success">导出</a>--}}
        {!! Form::open(['url' => '/vouch/materials/export', 'class' => 'pull-right form-inline']) !!}
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

        {!! Form::open(['url' => '/vouch/finishproducts/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::label('fg_codelabel', '代码:', ['class' => 'control-label']) !!}
            {!! Form::text('fg_code', null, ['class' => 'form-control']) !!}
            {!! Form::label('hs_codelabel', '海关编码:', ['class' => 'control-label']) !!}
            {!! Form::text('hs_code', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($finishproducts->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th >代码</th>
                    <th >面料类别</th>
                    <th >面料</th>
                    <th >海关代码</th>
                    <th >备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($finishproducts as $finishproduct)
                    <tr>
                        <td>
                            {{ $finishproduct->fg_code }}
                        </td>
                        <td>
                            {{ $finishproduct->type_name }}
                        </td>
                        <td>
                            {{ $finishproduct->fabrics }}
                        </td>
                        <td>
                            {{ $finishproduct->hs_code }}
                        </td>
                        <td>
                            {{ $finishproduct->memo }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/vouch/finishproducts/'.$finishproduct->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('finishproducts.destroy', $finishproduct->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $finishproducts->setPath('/vouch/finishproducts')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
