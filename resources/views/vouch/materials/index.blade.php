@extends('navbarerp')

@section('title', 'JPTE 面料制造用的原材料品名-代码表')

@section('main')
    <div class="panel-heading">
        <a href="/vouch/materials/create" class="btn btn-sm btn-success">新建</a>
        <a href="/vouch/materials/import" class="btn btn-sm btn-success">导入</a>
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

        {!! Form::open(['url' => '/vouch/materials/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {!! Form::label('mt_codelabel', '代码:', ['class' => 'control-label']) !!}
            {!! Form::text('mt_code', null, ['class' => 'form-control']) !!}
            {!! Form::label('mt_namelabel', '品名', ['class' => 'control-label']) !!}
            {!! Form::text('mt_name', null, ['class' => 'form-control']) !!}

            {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        @if ($materials->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th >代码</th>
                    <th >品名</th>
                    <th >品名/Name</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td >
                            {{ $material->code }}
                        </td>
                        <td >
                            {{ $material->ch_name }}
                        </td>
                        <td >
                            {{ $material->en_name }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/vouch/materials/'.$material->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$salarysheet->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('materials.destroy', $material->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $salarysheets->render() !!}--}}
            {!! $materials->setPath('/vouch/materials')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection
