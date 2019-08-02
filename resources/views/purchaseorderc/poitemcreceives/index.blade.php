@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        {{--
        <a href="{{ URL::to('purchaseorderc/poitemcs/' . $id . '/create') }}" class="btn btn-sm btn-success">新建</a>
         --}}
    </div>
    

    @if ($poitemcreceives->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>面料序列号</th>
                <th>物料代码</th>
                <th>数量</th>
                <th>单位</th>
                <th>面料尺寸</th>
                <th>运输方式</th>
                <th>单价</th>
                <th>发货日期</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($poitemcreceives as $poitemcreceive)
                <tr>
                    <td>
                        {{ $poitemcreceive->fabric_sequence_no }}
                    </td>
                    <td>
                        {{ $poitemcreceive->material_code }}
                    </td>
                    <td>
                        {{ $poitemcreceive->quantity }}
                    </td>
                    <td>
                        {{ $poitemcreceive->unit }}
                    </td>
                    <td>
                        {{ $poitemcreceive->fabric_width }}
                    </td>
                    <td>
                        {{ $poitemcreceive->transportation_method_type_code }}
                    </td>
                    <td>
                        {{ $poitemcreceive->unit_price }}
                    </td>
                    <td>
                        {{ $poitemcreceive->shipment_date }}
                    </td>
                    <td>
                        <a href="{{ url('/purchaseorderc/poitemcreceives', $poitemcreceive->id) }}" class="btn btn-success btn-sm pull-left">查看</a>

                        {{--<a href="{{ URL::to('/purchaseorderc/poitemcs/'.$poitemcreceive->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>--}}
                        {{--{!! Form::open(array('route' => array('poitemcs.destroy', $poitemcreceive->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}--}}
                            {{--{!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}--}}
                        {{--{!! Form::close() !!}--}}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $poitemcreceives->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@stop
