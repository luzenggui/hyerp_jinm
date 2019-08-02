@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        <a href="{{ URL::to('purchase/asnshipments/' . $id . '/create') }}" class="btn btn-sm btn-success">新建</a>
    </div>
    

    @if ($asnshipments->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>毛重</th>
                <th>运单号</th>
                <th>发货日期</th>
                <th>目的地</th>
                <th>Order</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asnshipments as $asnshipment)
                <tr>
                    <td>
                        {{ $asnshipment->gross_weight . $asnshipment->gross_unit }}
                    </td>
                    <td>
                        {{ $asnshipment->ref_bm_identification }}
                    </td>
                    <td>
                        {{ $asnshipment->ship_date }}
                    </td>
                    <td>
                        {{ $asnshipment->country_of_destination }}
                    </td>
                    <td>
                        <a href="{{ URL::to('/purchase/asnshipments/' . $asnshipment->id . '/asnorders') }}" target="_blank">Order</a>
                    </td>
                    <td>
                        <a href="{{ URL::to('/purchase/asnshipments/'.$asnshipment->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('asnshipments.destroy', $asnshipment->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $asnshipments->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@stop
