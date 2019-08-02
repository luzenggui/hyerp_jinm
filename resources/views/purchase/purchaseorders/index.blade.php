@extends('navbarerp')

@section('title', '采购订单')

@section('main')
    <div class="panel-heading">
        {{--<a href="purchaseorders/create" class="btn btn-sm btn-success">新建</a>--}}
{{--        <div class="pull-right" style="padding-top: 4px;">
            <a href="{{ URL::to('purchase/vendtypes') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{'客户类型管理', [], 'layouts'}}</a>
        </div> --}}
    </div>
    

    @if ($purchaseorders->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>编号</th>
                <th>采购订单名称</th>
                <th>供应商</th>
                <th>对应客户PO</th>
                <th>物料</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseorders as $purchaseorder)
                <tr>
                    <td>
                        {{ $purchaseorder->number }}
                    </td>
                    <td>
                        {{ $purchaseorder->descrip }}
                    </td>
                    <td>
                        {{ $purchaseorder->vendor->name }}
                    </td>
                    <td>
                        @if (isset($purchaseorder->poheadc->purchase_order_number)) {{ $purchaseorder->poheadc->purchase_order_number }} @endif
                    </td>
                    <td>
                        <a href="{{ URL::to('/purchase/purchaseorders/' . $purchaseorder->id . '/detail') }}" target="_blank">明细</a>
                    </td>
                    <td>
                        @if (!Auth::user()->isVendor())
                            <a href="{{ URL::to('/purchase/purchaseorders/'.$purchaseorder->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            <a href="{{ URL::to('/purchase/purchaseorders/' . $purchaseorder->id . '/exportcontract') }}" class="btn btn-success btn-sm pull-left">导出合同</a>
                        @endif
                        <a href="{{ URL::to('/purchase/purchaseorders/' . $purchaseorder->id . '/packing') }}" class="btn btn-success btn-sm pull-left">打包</a>
                        @if (!Auth::user()->isVendor())
                        {!! Form::open(array('route' => array('purchaseorders.destroy', $purchaseorder->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $purchaseorders->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif


@stop

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
        });

    </script>
@endsection
