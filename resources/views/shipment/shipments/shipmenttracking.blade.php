@extends('navbarerp')

@section('title', 'Shipment Tracking')

@section('main')
    <div class="panel-heading">
        {{--<a href="shipments/create" class="btn btn-sm btn-success">新建(New)</a>--}}
        {{--<a href="shipments/import" class="btn btn-sm btn-success">导入(Import)</a>--}}
    </div>

    <div class="panel-body">

        {!! Form::open(['url' => '/shipment/shipments/searchshipmenttracking', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
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

            {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => 'Invoice No.,Contact No.,Customer']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}
            {!! Form::button('Export', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExport']) !!}
            {{--{!! Form::button('Export PVH', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExportPVH']) !!}--}}
        </div>
        {!! Form::close() !!}

        @if ($shipments->count())
            <?php $types = ['ci_pl', 'rma', 'bc', 'bank_permit', 'BTB_DOCS', 'bl', 'ECD', 'others']; ?>
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>Customs No.</th>
                    <th>Customer Name</th>
                    <th>Des. Port</th>
                    <th>ETD</th>
                    <th>ETD TRANSPORT Date</th>
                    <th>BL No.</th>
                    <th>Shipping Line</th>
                    <th>Container No.</th>
                    {{--<th>Qty for Customs</th>--}}
                    {{--<th>Amount for Customs</th>--}}
                    {{--@foreach($types as $type)--}}
                        {{--<th>{{ $type }}</th>--}}
                    {{--@endforeach--}}
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shipments as $shipment)
                    <tr>
                        <td>
                            {{ $shipment->invoice_number }}
                        </td>
                        <td>
                            {{ $shipment->customs_no }}
                        </td>
                        <td>
                            {{ $shipment->customer_name }}
                        </td>
                        <td>
                            {{ $shipment->dest_port }}
                        </td>
                        <td>
                            {{ $shipment->etd }}
                        </td>
                        <td>
                            {{ $shipment->etd_transport_date }}
                        </td>
                        <td>
                            {{ $shipment->bill_no }}
                        </td>
                        <td>
                            {{ $shipment->ship_company }}
                        </td>
                        <td>
                            {{ $shipment->container_number }}
                        </td>
                        {{--<td>--}}
                            {{--{{ $shipment->qty_for_customs }}--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--{{ $shipment->amount_for_customs }}--}}
                        {{--</td>--}}
                        {{--@foreach($types as $type)--}}
                            {{--<td>--}}
                                {{--@if (isset($shipment) && null != $shipment->shipmentattachments->where('type', $type)->first())--}}
                                    {{--<a href="{!! Storage::url($shipment->shipmentattachments->where('type', $type)->first()->path) !!}" target="_blank" class="btn btn-sm btn-success">V</a>--}}
                                    {{--{{ $shipment->shipmentattachments->where('type', $type)->first()->filename }}--}}
                                {{--@else--}}
                                    {{--{!! Form::button('+', ['class' => 'btn btn-sm', 'data-toggle' => 'modal', 'data-target' => '#uploadAttachModal', 'data-shipment_id' => $shipment->id, 'data-type' => $type]) !!}--}}
                                {{--@endif--}}
                            {{--</td>--}}
                        {{--@endforeach--}}
                        <td>
                            <a href="{{ URL::to('/shipment/shipments/'.$shipment->id.'/editshipmenttracking') }}" class="btn btn-success btn-sm pull-left">Edit</a>
                            {{--{!! Form::open(array('route' => array('shipments.destroy', $shipment->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}--}}
                            {{--{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}--}}
                            {{--{!! Form::close() !!}--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $shipments->render() !!}--}}
            {!! $shipments->setPath('/shipment/shipments/shipmenttracking')->appends([
                'createdatestart' => isset($inputs['createdatestart']) ? $inputs['createdatestart'] : null,
                'createdateend' => isset($inputs['createdateend']) ? $inputs['createdateend'] : null,
                'etdstart' => isset($inputs['etdstart']) ? $inputs['etdstart'] : null,
                'etdend' => isset($inputs['etdend']) ? $inputs['etdend'] : null,
                'amount_for_customer_opt' => isset($inputs['amount_for_customer_opt']) ? $inputs['amount_for_customer_opt'] : null,
                'amount_for_customer' => isset($inputs['amount_for_customer']) ? $inputs['amount_for_customer'] : null,
                'key' => isset($inputs['key']) ? $inputs['key'] : null,
            ])->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

    <div class="modal fade" id="uploadAttachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload File</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url' => '/shipment/shipments/uploadfile', 'class' => 'form-horizontal', 'files' => true, 'id' => 'frmUpload']) !!}
                    <div class="form-group">
                        {!! Form::label('file', '选择文件(Select File):', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
                        <div class='col-xs-8 col-sm-10'>
                            {!! Form::file('file') !!}
                        </div>
                    </div>

                    {!! Form::hidden('shipment_id', null, []) !!}
                    {!! Form::hidden('type', null, []) !!}

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {!! Form::button('Upload', ['class' => 'btn btn-primary', 'id' => 'btnUpload']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("#btnExport").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/exportshipmenttracking') }}",
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

            $('#uploadAttachModal').on('show.bs.modal', function (e) {
                $("#listvendors").empty();

                var target = $(e.relatedTarget);
                // alert(text.data('id'));

                var modal = $(this);
                modal.find("input[name='shipment_id']").val(target.data('shipment_id'));
                modal.find("input[name='type']").val(target.data('type'));
            });

            $("#btnUpload").click(function() {
                var form = new FormData(document.getElementById("frmUpload"));
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/uploadfile') }}",
                    data: form,
                    contentType: false,
                    processData: false,
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
//                        alert(result);
//                        location.href = result;
                        alert("上传成功。.");
                        $('#uploadAttachModal').modal('toggle');
                    },
                });
            });
        });
    </script>
@endsection
