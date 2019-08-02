@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        {{--<a href="{{ URL::to('purchase/poitems/' . $id . '/create') }}" class="btn btn-sm btn-success">新建</a>--}}
{{--        <div class="pull-right" style="padding-top: 4px;">
            <a href="{{ URL::to('purchase/vendtypes') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{'客户类型管理', [], 'layouts'}}</a>
        </div> --}}
    </div>
    

    @if ($poitems->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>物料代码</th>
                <th>颜色</th>
                <th>中文描述</th>
                <th>单价</th>
                <th>数量</th>
                {{--<th>运费</th>--}}
                {{--<th>已收货</th>--}}
                <th>卷</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($poitems as $poitem)
                <tr>
                    <td>
                        {{ $poitem->poitemc->material_code }}
                    </td>
                    <td>
                        {{ $poitem->poitemc->color_desc1 }}
                    </td>
                    <td>
                        {{ $poitem->chinesedescrip }}
                    </td>
                    <td>
                        {{ $poitem->unitprice }}
                    </td>
                    <td>
                        {{ number_format($poitem->quantity, 0)  }}
                    </td>
                    {{--<td>--}}
                        {{--{{ $poitem->freight }}--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--{{ $poitem->qty_received }}--}}
                    {{--</td>--}}
                    <td>
                        <a href="{{ URL::to('/purchase/poitems/'.$poitem->id.'/poitemrolls') }}">明细</a>
                    </td>
                    <td>
                        @cannot('vendor')
                        <a href="{{ URL::to('/purchase/poitems/'.$poitem->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('poitems.destroy', $poitem->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $poitems->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@stop
