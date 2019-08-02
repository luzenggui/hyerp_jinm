@extends('navbarerp')

@section('main')
    {{--<div class="panel-heading">--}}
        {{--<a href="{{ URL::to('purchase/asnitems/' . $id . '/create') }}" class="btn btn-sm btn-success">新建</a>--}}
    {{--</div>--}}
    

    @if ($poitemrolls->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>卷号</th>
                <th>发货数量</th>
                <th>毛重</th>
                <th>毛重单位</th>
                <th>净重</th>
                <th>净重单位</th>
                <th>UCC编号</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($poitemrolls as $poitemroll)
                <tr>
                    <td>
                        {{ $poitemroll->roll_number }}
                    </td>
                    <td>
                        {{ $poitemroll->quantity_shipped }}
                    </td>
                    <td>
                        {{ $poitemroll->gross_weight }}
                    </td>
                    <td>
                        {{ $poitemroll->gross_unit }}
                    </td>
                    <td>
                        {{ $poitemroll->net_weight }}
                    </td>
                    <td>
                        {{ $poitemroll->net_unit }}
                    </td>
                    <td>
                        {{ $poitemroll->ucc_number }}
                    </td>
                    <td>
                        <a href="{{ URL::to('/purchase/poitemrolls/'.$poitemroll->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('poitemrolls.destroy', $poitemroll->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $poitemrolls->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@stop
