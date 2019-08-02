@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        <a href="{{ URL::to('purchase/asnpackagings/' . $id . '/create') }}" class="btn btn-sm btn-success">新建</a>
    </div>

    @if ($asnpackagings->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>物料</th>
                <th>颜色</th>
                <th>明细</th>
                {{--<th>Item</th>--}}
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asnpackagings as $asnpackaging)
                <tr>
                    <td>
                        {{ $asnpackaging->poitem->poitemc->material_code }}
                    </td>
                    <td>
                        {{ $asnpackaging->poitem->poitemc->color_desc1 }}
                    </td>
                    <td>
                        <table class="table table-condensed table-bordered">
                            <tbody>
                            @foreach($asnpackaging->asnitems as $asnitem)
                                <tr>
                                    <td>卷号：{{ $asnitem->poitemroll->roll_number }}，数量：{{ $asnitem->poitemroll->quantity_shipped }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    {{--<td>--}}
                        {{--<a href="{{ URL::to('/purchase/asnpackagings/' . $asnpackaging->id . '/asnitems') }}" target="_blank">Item</a>--}}
                    {{--</td>--}}
                    <td>
                        {{--<a href="{{ URL::to('/purchase/asnpackagings/'.$asnpackaging->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>--}}
                        {!! Form::open(array('route' => array('asnpackagings.destroy', $asnpackaging->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $asnpackagings->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@stop
