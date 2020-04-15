@extends('navbarerp')

@section('title', 'ASN')

@section('main')
    <div class="panel-heading">
        <a href="/shipment/shipments/create" class="btn btn-sm btn-success">新建(New)</a>
        <a href="/shipment/shipments/import" class="btn btn-sm btn-success">导入(Import)</a>
        {!! Form::button('保存收汇完成', ['class' => 'btn btn-sm btn-success', 'id' => 'btnFinishedFinance']) !!}
        {!! Form::close() !!}
    </div>

    <div class="panel-body">
        {{--{!! Form::open(['url' => '/shipment/shipments/export', 'class' => 'pull-right']) !!}--}}
            {{--{!! Form::submit('Export', ['class' => 'btn btn-default btn-sm']) !!}--}}
        {{--{!! Form::close() !!}--}}

        {!! Form::open(['url' => '/shipment/shipments/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {{--{!! Form::label('createdatestartlabel', 'Create Date:', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('createdatestart', null, ['class' => 'form-control']) !!}--}}
            {{--{!! Form::label('createdatelabelto', '-', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('createdateend', null, ['class' => 'form-control']) !!}--}}

            {!! Form::label('etdstartlabel', 'ETD:', ['class' => 'control-label']) !!}
            {!! Form::date('etdstart', null, ['class' => 'form-control']) !!}
            {!! Form::label('etdlabelto', '-', ['class' => 'control-label']) !!}
            {!! Form::date('etdend', null, ['class' => 'form-control']) !!}

            {!! Form::label('amount_for_customer', 'Amount for Customer:', ['class' => 'control-label']) !!}
            {!! Form::select('amount_for_customer_opt', ['>=' => '>=', '<=' => '<=', '=' => '='], null, ['class' => 'form-control']) !!}
            {!! Form::text('amount_for_customer', null, ['class' => 'form-control', 'placeholder' => 'Amount for Customer']) !!}

            {!! Form::select('invoice_number_type', ['JPTEEA' => 'JPTEEA', 'JPTEEB' => 'JPTEEB'], null, ['class' => 'form-control', 'placeholder' => '--Invoice No. Type--']) !!}

            {{--{!! Form::select('paymentstatus', ['0' => '已付款', '-1' => '未付款'], null, ['class' => 'form-control', 'placeholder' => '--付款状态--']); !!}--}}
            {{--{!! Form::select('approvalstatus', ['1' => '审批中', '0' => '已通过', '-2' => '未通过'], null, ['class' => 'form-control', 'placeholder' => '--审批状态--']); !!}--}}
            {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => 'Invoice No.,Contact No.,Customer']) !!}
            {!! Form::select('finished_fininace', ['unfinished' => '未完成', 'finished' => '完成'], null, ['class' => 'form-control', 'placeholder' => '--收汇完成--']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}
            {!! Form::button('Export', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExport']) !!}
            {{--{!! Form::button('Export PVH', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExportPVH']) !!}--}}
        </div>
        {!! Form::close() !!}

        @if ($shipments->count())
            <table class="table table-striped table-hover table-condensed" id="tbMain">
                <thead>
                <tr>
                    <th>Dept</th>
                    <th>Customer</th>
                    <th>Invoice No.</th>
                    <th>Contact No.</th>
                    {{--<th>产品类型</th>--}}
                    {{--<th>编织类型</th>--}}
                    {{--<th>目的地</th>--}}
                    {{--<th>供应商名称</th>--}}
                    <th>Create Time</th>
                    <th>Amount for Customer</th>
                    <th>Finished Finance</th>
                    <th>Detail</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shipments as $shipment)
                    <tr>
                        <td>
                            {{ $shipment->dept }}
                        </td>
                        <td>
                            {{ $shipment->customer_name }}
                        </td>
                        <td>
                            {{ $shipment->invoice_number }}
                        </td>
                        <td title="@if (isset($shipment->contract_number)) {{ $shipment->contract_number }} @else @endif">
                            {{ str_limit($shipment->contract_number, 30) }}
                        </td>
                        {{--<td>--}}
                        {{--{{ $purchaseorder->product_type }}--}}
                        {{--</td>--}}
                        {{--<td>--}}
                        {{--{{ $purchaseorder->weave_type }}--}}
                        {{--</td>--}}
                        {{--<td>--}}
                        {{--{{ $purchaseorder->destination_country }}--}}
                        {{--</td>--}}
                        {{--<td>--}}
                        {{--{{ $purchaseorder->supplier_name }}--}}
                        {{--</td>--}}
                        <td>
                            {{ $shipment->created_at }}
                        </td>
                        <td>
                            {{ $shipment->amount_for_customer }}
                        </td>
                        <td>
                            @if(!empty($shipment->receive_finished)  or $shipment->receive_finished >=1)
                                <input type="checkbox" class="qx" checked="true" disabled="true">
                            @else
                                <input type="checkbox" class="qx" disabled_value=1 value="{{ $shipment->id }}" data-id="{{ $shipment->id }}">
                            @endif
                        </td>
                        <td>
                            <a href="{{ URL::to('/shipment/shipments/' . $shipment->id . '/shipmentitems') }}" target="_blank">Detail</a>
                        </td>
                        <td>
                            <a href="{{ URL::to('/shipment/shipments/'.$shipment->id.'/edit') }}" class="btn btn-success btn-sm pull-left">Edit</a>
                            {{--<a href="{{ URL::to('/shipment/shipments/'.$shipment->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                            {!! Form::open(array('route' => array('shipments.destroy', $shipment->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $shipments->render() !!}--}}
            {!! $shipments->setPath('/shipment/shipments')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("#btnExport").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/export') }}",
                    data: $("form#frmSearch").serialize(),
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
                        location.href = result;
//                        alert("导出成功.");
                    },
                });
            });

            $("#btnExportPVH").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/exportpvh') }}",
                    data: $("form#frmSearch").serialize(),
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
//                        alert(result);
                        location.href = result;
//                        alert("导出成功.");
                    },
                });
            });
            $("#btnFinishedFinance").click(function(e) {

                var checkvalues = [];
                var checknumbers = [];
                var ids="";
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    if($(this).attr('disabled_value') ==1 )
                    {
                        checkvalues[i] =$(this).val();
                        checknumbers[i] = $(this).attr('data-id');
                    }
                });

                // alert(checkvalues.join(","));

                {{--window.open("{{ url('/shipment/shipments/updatefinished') }}" + "?ids=" + checkvalues.join(","));--}}
                $.ajax({
                type: "GET",
                url: "{{ url('/shipment/shipments/updatefinished') }}",
                data: "ids=" + checkvalues.join(","),
                // contentType: false,
                // processData: false,
                //                    dataType: "json",
                error:function(xhr, ajaxOptions, thrownError){
                    alert('thrownError');
                },
                success:function(result){
                    alert("保存成功。");
                    window.location.reload();
                //                        $('#sendAsnModal').modal('toggle');
                },
                });
            });
        });
    </script>
@endsection
