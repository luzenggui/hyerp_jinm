@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        <a href="{{ URL::to('shipment/shipmentitems/' . $shipment_id . '/create') }}" class="btn btn-sm btn-success">新建(New)</a>
    </div>
    

    @if ($shipmentitems->count())
    <table class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>Contract No.</th>
                <th>Purcahse Order No.</th>
                <th>Qty for Customer</th>
                <th>amount for Customer</th>
                <th>Volume</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipmentitems as $shipmentitem)
                <tr>
                    <td>
                        {{ $shipmentitem->contract_number }}
                    </td>
                    <td>
                        {{ $shipmentitem->purchaseorder_number }}
                    </td>
                    <td>
                        {{ $shipmentitem->qty_for_customer }}
                    </td>
                    <td>
                        {{ $shipmentitem->amount_for_customer }}
                    </td>
                    <td>
                        {{ $shipmentitem->volume }}
                    </td>
                    <td>
                        <a href="{{ URL::to('/shipment/shipmentitems/'.$shipmentitem->id.'/edit') }}" class="btn btn-success btn-sm pull-left">Edit</a>
                        {!! Form::open(array('route' => array('shipmentitems.destroy', $shipmentitem->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $shipmentitems->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录(No Record)', [], 'layouts'}}
    </div>
    @endif    


@stop
