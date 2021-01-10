@extends('navbarerp')

@section('title', 'JPTE 百米用量 used kgs per 100M')

@section('main')
    <div class="panel-heading">
        <a href="/vouch/boms/create" class="btn btn-sm btn-success">新建</a>
        <a href="/vouch/boms/import" class="btn btn-sm btn-success">导入</a>
        {{--        {!! Form::button('导出', [url('personal/checkrecords/export'),'class' => 'btn btn-success btn-sm', 'id' => 'btnExport']) !!}--}}
        {{--<a href="/personal/checkrecords/export" class="btn btn-sm btn-success">导出</a>--}}
        {!! Form::open(['url' => '/vouch/boms/export', 'class' => 'pull-right form-inline']) !!}
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

        {!! Form::open(['url' => '/vouch/boms/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::label('fg_codelabel', '成品代码:', ['class' => 'control-label']) !!}
            {!! Form::text('fg_code', null, ['class' => 'form-control']) !!}

            {!! Form::label('mt_codelabel', '原料代码:', ['class' => 'control-label']) !!}
            {!! Form::text('mt_code', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($boms->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th >成品代码</th>
                    <th >原料代码</th>
                    <th >原料名</th>
                    <th >数量</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($boms as $bom)
                    <tr>
                        <td>
                            {{ $bom->finishproductcode->fg_code }}
                        </td>
                        <td>
                            {{ $bom->materialcode->code }}
                        </td>
                        <td>
                            {{ $bom->materialcode->ch_name }}
                        </td>
                        <td>
                            {{ $bom->qty }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/vouch/boms/'.$bom->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('boms.destroy', $bom->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $boms->setPath('/vouch/boms')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
