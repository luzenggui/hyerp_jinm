@extends('navbarerp')

@section('title', 'ASN')

@section('main')
    <div class="panel-heading">
        {{--<a href="shipments/create" class="btn btn-sm btn-success">新建(New)</a>--}}
        {{--<a href="shipments/import" class="btn btn-sm btn-success">导入(Import)</a>--}}
    </div>

    <div class="panel-body">

        {!! Form::open(['url' => '/shipment/shipments/searchfilemonitor', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}
        <div class="form-group-sm">
            {{--{!! Form::label('createdatestartlabel', 'Create Date:', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('createdatestart', null, ['class' => 'form-control']) !!}--}}
            {{--{!! Form::label('createdatelabelto', '-', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('createdateend', null, ['class' => 'form-control']) !!}--}}

            {!! Form::label('etdstartlabel', 'ETD:', ['class' => 'control-label']) !!}
            {!! Form::date('etdstart', null, ['class' => 'form-control']) !!}
            {!! Form::label('etdlabelto', '-', ['class' => 'control-label']) !!}
            {!! Form::date('etdend', null, ['class' => 'form-control']) !!}

            {{--{!! Form::label('amount_for_customer', 'Amount for Customer:', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::select('amount_for_customer_opt', ['>=' => '>=', '<=' => '<=', '=' => '='], null, ['class' => 'form-control']) !!}--}}
            {{--{!! Form::text('amount_for_customer', null, ['class' => 'form-control', 'placeholder' => 'Amount for Customer']) !!}--}}
            {!! Form::select('invoice_number_type', ['JPTEEA' => 'JPTEEA', 'JPTEEB' => 'JPTEEB'], null, ['class' => 'form-control', 'placeholder' => '--Invoice No. Type--']) !!}

            {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => 'Invoice No.,Contact No.,Customer']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}
            <a class="btn btn-default btn-sm" href="{!! url('shipment/shipmentattachmentrecords') !!}" target="_blank">File Operation Records</a>
            {{--{!! Form::button('Export PVH', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExportPVH']) !!}--}}
        </div>
        {!! Form::close() !!}

        @if ($shipments->count())
            <?php $types = ['SI', 'CI', 'PL', 'PLA', 'RMA', 'BC', 'bank_permit', 'ECD','BTB_DOCS', 'BL',  'others']; ?>
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>Customer</th>
                    <th>Contact No.</th>
                    <th width="90px">ETD</th>
                    <th>Qty for Customer</th>
                    <th>Amount for Customer</th>
                    @foreach($types as $type)
                        <th>{{ $type }}</th>
                    @endforeach
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
                            {{ $shipment->customer_name }}
                        </td>
                        <td title="@if (isset($shipment->contract_number)) {{ $shipment->contract_number }} @else @endif">
                            {{ str_limit($shipment->contract_number, 40) }}
                        </td>
                        <td>
                            {{ $shipment->etd }}
                        </td>
                        <td>
                            {{ $shipment->qty_for_customer }}
                        </td>
                        <td>
                            {{ $shipment->amount_for_customer }}
                        </td>
                        @foreach($types as $type)
                            <td>
                                <div id="filehandler_{{ $shipment->id }}_{{ $type }}" data-shipment_id="{{ $shipment->id }}">
                                @if (isset($shipment) && null != $shipment->shipmentattachments->where('type', $type)->first())
                                    <a tabindex="0" role="button" class="btn btn-sm btn-success filehandler" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-trigger="focus"  data-shipment_id="{{ $shipment->id }}" data-type="{!! $type !!}"
                                            data-content="<a href='{!! Storage::url($shipment->shipmentattachments->where('type', $type)->first()->path) !!}' target='_blank' class='btn btn-sm'>View</a>
                                            <button class='btn btn-sm' data-toggle='modal' data-target='#uploadAttachModal' data-shipment_id='{!! $shipment->id !!}' data-type='{!! $type !!}' type='button'>Re-upload</button>
                                            <button class='btn btn-sm' data-toggle='modal' data-target='#clearAttachModal' data-shipment_id='{!! $shipment->id !!}' data-type='{!! $type !!}' type='button'>Clear</button>">V</a>

{{--                                    <a href="{!! Storage::url($shipment->shipmentattachments->where('type', $type)->first()->path) !!}" target="_blank" class="btn btn-sm btn-success">V</a>--}}
                                    {{--{{ $shipment->shipmentattachments->where('type', $type)->first()->filename }}--}}
                                @else
                                    {!! Form::button('+', ['class' => 'btn btn-sm', 'data-toggle' => 'modal', 'data-target' => '#uploadAttachModal', 'data-shipment_id' => $shipment->id, 'data-type' => $type]) !!}
                                @endif
                                </div>
                            </td>
                        @endforeach
                        <td>
                            <a href="{{ URL::to('/shipment/shipments/'.$shipment->id) }}" class="btn btn-success btn-sm pull-left">Show</a>
                            {{--{!! Form::open(array('route' => array('shipments.destroy', $shipment->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}--}}
                            {{--{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}--}}
                            {{--{!! Form::close() !!}--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{--{!! $shipments->render() !!}--}}
            {!! $shipments->setPath('/shipment/shipments/filemonitor')->appends($inputs)->links() !!}
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

    <div class="modal fade" id="clearAttachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Clear File</h4>
                </div>
                <div class="modal-body">
                    <p>
                    Clear this attachment?
                    </p>


                </div>
                <div class="modal-footer">
                    {!! Form::open(['url' => '/shipment/shipments/clearfile', 'class' => 'form-horizontal', 'files' => true, 'id' => 'frmClear']) !!}
                    {!! Form::hidden('shipment_id', null, []) !!}
                    {!! Form::hidden('type', null, []) !!}
                    {!! Form::button('Cancel', ['class' => 'btn btn-sm', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button('Clear', ['class' => 'btn btn-sm btn-primary', 'id' => 'btnClear']) !!}
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

            $('#uploadAttachModal').on('show.bs.modal', function (e) {
                var target = $(e.relatedTarget);
                // alert(text.data('id'));

                var modal = $(this);
                modal.find("input[name='file']").val('');
                modal.find("input[name='shipment_id']").val(target.data('shipment_id'));
                modal.find("input[name='type']").val(target.data('type'));
            });

            $("#btnUpload").click(function() {
//                console.log(id);
//                var html = '<a tabindex="0" role="button" class="btn btn-sm btn-success" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-trigger="focus" >V</a>';
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
                        alert("Upload Success.");
                        $('#uploadAttachModal').modal('toggle');
                        var id = "filehandler_" + $('#uploadAttachModal').find("input[name='shipment_id']").val() + "_" + $('#uploadAttachModal').find("input[name='type']").val();
                        $("#filehandler_" + $('#uploadAttachModal').find("input[name='shipment_id']").val() + "_" + $('#uploadAttachModal').find("input[name='type']").val()).html(result.popoverhtml);
                        $('[data-toggle="popover"]').popover();
                    },
                });
            });

            $('#clearAttachModal').on('show.bs.modal', function (e) {
                var target = $(e.relatedTarget);
                // alert(text.data('id'));

                var modal = $(this);
                modal.find("input[name='file']").val('');
                modal.find("input[name='shipment_id']").val(target.data('shipment_id'));
                modal.find("input[name='type']").val(target.data('type'));
            });

            $("#btnClear").click(function() {
                var form = new FormData(document.getElementById("frmClear"));
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/clearfile') }}",
                    data: form,
                    contentType: false,
                    processData: false,
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
                        alert("Clear Success.");
                        $('#clearAttachModal').modal('toggle');
                        var id = "filehandler_" + $('#clearAttachModal').find("input[name='shipment_id']").val() + "_" + $('#clearAttachModal').find("input[name='type']").val();
                        $("#filehandler_" + $('#clearAttachModal').find("input[name='shipment_id']").val() + "_" + $('#clearAttachModal').find("input[name='type']").val()).html(result.popoverhtml);
                        $('[data-toggle="popover"]').popover();
                    },
                });
            });

            $(function () {
                $('[data-toggle="popover"]').popover()
            });

            $(".filehandler").popover({
            });
        });
    </script>
@endsection
