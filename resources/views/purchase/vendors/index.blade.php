@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        <a href="vendors/create" class="btn btn-sm btn-success">新建</a>
        {{--<div class="pull-right" style="padding-top: 4px;">--}}
            {{--<a href="{{ URL::to('purchase/vendtypes') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{'供应商类型管理', [], 'layouts'}}</a>--}}
        {{--</div>--}}
    </div>
    

    @if ($vendors->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>编号</th>
                <th>名称</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendors as $vendor)
                <tr>
                    <td>
                        {{ $vendor->number }}
                    </td>
                    <td>
                        {{ $vendor->name }}
                    </td>
                    <td>
                        <a href="{{ URL::to('/purchase/vendors/'.$vendor->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('vendors.destroy', $vendor->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $vendors->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@stop
