@extends('navbarerp')

@section('title', 'ASN')

@section('main')
    <div class="panel-heading">
        <a href="asns/create" class="btn btn-sm btn-success">新建</a>
        {!! Form::button('导出PackingList', ['class' => 'btn btn-sm btn-success', 'id' => 'btnExportPackinglist']) !!}
        {!! Form::button('导出DPL', ['class' => 'btn btn-sm btn-success', 'id' => 'btnExportDPL']) !!}
        {!! Form::button('导出Invoice', ['class' => 'btn btn-sm btn-success', 'id' => 'btnExportInvoice']) !!}
        {!! Form::button('导出验货报告', ['class' => 'btn btn-sm btn-success', 'id' => 'btnExportCheckReport']) !!}
    </div>

    @if ($asns->count())
    <table class="table table-striped table-hover table-condensed" id="tbMain">
        <thead>
            <tr>
                <th></th>
                <th>编号</th>
                <th>传输控制号</th>
                <th>测试标记</th>
                <th>交易控制号</th>
                {{--<th>产品类型</th>--}}
                {{--<th>编织类型</th>--}}
                {{--<th>目的地</th>--}}
                {{--<th>供应商名称</th>--}}
                <th>创建时间</th>
                <th>明细</th>
                {{--<th>Shipment</th>--}}
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asns as $asn)
                <tr>
                    <td>
                        <input type="checkbox" class="qx" value="{{ $asn->id }}" data-id="{{ $asn->id }}">
                    </td>
                    <td>
                        {{ $asn->asn_number }}
                    </td>
                    <td>
                        {{ $asn->interchange_control_number }}
                    </td>
                    <td>
                        {{ $asn->test_indicator }}
                    </td>
                    <td>
                        {{ $asn->transaction_set_control_no }}
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
                        {{ $asn->created_at }}
                    </td>
                    <td>
{{--                        {{ $asn->asnshipments->first()  }}--}}
                        {{--<a href="{{ URL::to('/purchase/asnshipments/' . $asn->asnshipments->first()->id . '/asnorders') }}" target="_blank">明细</a>--}}
                        @if ($asn->asnshipments->first() && $asn->asnshipments->first()->asnorders->first())
                            <a href="{{ URL::to('/purchase/asnorders/' . $asn->asnshipments->first()->asnorders->first()->id . '/asnpackagings') }}" target="_blank">明细</a>
                        @else
                            还未选择订单
                        @endif
                    </td>
                    {{--<td>--}}
                        {{--<a href="{{ URL::to('/purchase/asns/' . $asn->id . '/asnshipments') }}" target="_blank">Shipment</a>--}}
                    {{--</td>--}}
                    <td>
                        <a href="{{ URL::to('/purchase/asns/'.$asn->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {{--<a href="{{ URL::to('/purchase/asns/'.$asn->id.'/export') }}" class="btn btn-success btn-sm pull-left">导出</a>--}}
                        {{--{!! Form::button('打印', ['class' => 'btn btn-success btn-sm pull-left', 'id' => 'btnPrint']) !!}--}}
                        {{--{!! Form::button('打印2', ['class' => 'btn btn-success btn-sm pull-left', 'id' => 'btnPrint2']) !!}--}}
                        {{--{!! Form::button('打印3', ['class' => 'btn btn-success btn-sm pull-left', 'id' => 'btnPrint3']) !!}--}}
                        <a href="{{ URL::to('/purchase/asns/'.$asn->id.'/labelprint') }}" class="btn btn-success btn-sm pull-left" target="_blank">打印标签</a>
                        {{--<a href="{{ URL::to('/purchase/asns/'.$asn->id.'/labelpreprint') }}" class="btn btn-success btn-sm pull-left" target="_blank">标签预览</a>--}}
                        {!! Form::button('发送', ['class' => 'btn btn-success btn-sm pull-left', 'data-toggle' => 'modal', 'data-target' => '#sendAsnModal', 'data-asn_id' => $asn->id]) !!}
                        {!! Form::open(array('route' => array('asns.destroy', $asn->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                        {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    {!! $asns->render() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif

    <div class="modal fade" id="sendAsnModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">发送ASN</h4>
                </div>
                <div class="modal-body">
                    <p>
                        发送ASN数据到FTP服务器？
                    </p>


                </div>
                <div class="modal-footer">
                    {!! Form::open(['url' => '/shipment/shipments/clearfile', 'class' => 'form-horizontal', 'files' => true, 'id' => 'frmSendAsn']) !!}
                    {!! Form::hidden('asn_id', null, []) !!}
                    {!! Form::button('取消', ['class' => 'btn btn-sm', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button('发送', ['class' => 'btn btn-sm btn-primary', 'id' => 'btnSend']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {

            $("#btnPrint").click(function() {
                var objfs = new ActiveXObject("Scripting.FileSystemObject");
                var objprinter = objfs.createtextfile("LPT1:", true);
                objprinter.writeline("^XA");
                objprinter.writeline("^FO50,50");
                objprinter.writeline("^AON,36,20");
                objprinter.writeline("^FD12345678^FS");
                objprinter.writeline("^PQ1,0,1,Y");
                objprinter.writeline("^XZ");
                objprinter.writeline();
                objfs = null;

            });

            $("#btnPrint2").click(function() {
                var zpl = "${^XA\
                    ^FXTest ZPL^FS\
                ^FO50,100\
                ^A0N,89^FDHello ZPL^FS\
                ^XZ}$";
                var printWindow = window.open();
                printWindow.document.open('text/plain')
                printWindow.document.write(zpl);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            });

            $("#btnPrint3").click(function() {
                var zpl = "${^XA\
                    ^FXTest ZPL^FS\
                ^FO50,100\
                ^A0N,89^FDHello ZPL^FS\
                ^XZ}$";
                var printWindow = window.open();
                printWindow.document.open('text/plain');
                printWindow.document.write(zpl);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            });

            $("#btnPrint4").click(function() {
                var zpl = "${^XA\
                    ^FXTest ZPL^FS\
                ^FO50,100\
                ^A0N,89^FDHello ZPL^FS\
                ^XZ}$";
                var printWindow = window.open();
                printWindow.document.open('text/plain');
                printWindow.document.write(zpl);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            });

            $('#sendAsnModal').on('show.bs.modal', function (e) {
                var target = $(e.relatedTarget);
                // alert(text.data('id'));

                var modal = $(this);
                modal.find("input[name='asn_id']").val(target.data('asn_id'));
            });

            $("#btnSend").click(function() {
                var form = new FormData(document.getElementById("frmSendAsn"));
                $.ajax({
                    type: "POST",
                    url: "{{ url('purchase/asns/send') }}",
                    data: form,
                    contentType: false,
                    processData: false,
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
                        alert("发送成功。");
                        $('#sendAsnModal').modal('toggle');
//                        var id = "filehandler_" + $('#clearAttachModal').find("input[name='shipment_id']").val() + "_" + $('#clearAttachModal').find("input[name='type']").val();
//                        $("#filehandler_" + $('#clearAttachModal').find("input[name='shipment_id']").val() + "_" + $('#clearAttachModal').find("input[name='type']").val()).html(result.popoverhtml);
//                        $('[data-toggle="popover"]').popover();
                    },
                });
            });

            $("#btnExportPackinglist").click(function(e) {

                var checkvalues = [];
                var checknumbers = [];
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    checkvalues[i] =$(this).val();
                    checknumbers[i] = $(this).attr('data-id');
                });

//                alert(checkvalues.join(","));
                $("#poitemroll_numbers").val(checknumbers.join(","));
                $("#poitemroll_values").val(checkvalues.join(","));
                $("#poitemroll_numbers" +  + $("#selectPoitemrollModal").find('#num').val()).val(checknumbers.join(","));
                $("#poitemroll_values" +  + $("#selectPoitemrollModal").find('#num').val()).val(checkvalues.join(","));

                window.open("{{ url('purchase/asns/exportpackinglist') }}" + "?ids=" + checkvalues.join(","));
                {{--$.ajax({--}}
                    {{--type: "GET",--}}
                    {{--url: "{{ url('purchase/asns/exportpackinglist') }}",--}}
                    {{--data: "ids=" + checkvalues.join(","),--}}
                    {{--contentType: false,--}}
                    {{--processData: false,--}}
{{--//                    dataType: "json",--}}
                    {{--error:function(xhr, ajaxOptions, thrownError){--}}
                        {{--alert('error');--}}
                    {{--},--}}
                    {{--success:function(result){--}}
                        {{--alert("发送成功。");--}}
{{--//                        $('#sendAsnModal').modal('toggle');--}}
                    {{--},--}}
                {{--});--}}
            });

            $("#btnExportDPL").click(function(e) {

                var checkvalues = [];
                var checknumbers = [];
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    checkvalues[i] =$(this).val();
                    checknumbers[i] = $(this).attr('data-id');
                });

//                alert(checkvalues.join(","));
                $("#poitemroll_numbers").val(checknumbers.join(","));
                $("#poitemroll_values").val(checkvalues.join(","));
                $("#poitemroll_numbers" +  + $("#selectPoitemrollModal").find('#num').val()).val(checknumbers.join(","));
                $("#poitemroll_values" +  + $("#selectPoitemrollModal").find('#num').val()).val(checkvalues.join(","));

                window.open("{{ url('purchase/asns/exportdpl') }}" + "?ids=" + checkvalues.join(","));
            });

            $("#btnExportInvoice").click(function(e) {

                var checkvalues = [];
                var checknumbers = [];
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    checkvalues[i] =$(this).val();
                    checknumbers[i] = $(this).attr('data-id');
                });

                $("#poitemroll_numbers").val(checknumbers.join(","));
                $("#poitemroll_values").val(checkvalues.join(","));
                $("#poitemroll_numbers" +  + $("#selectPoitemrollModal").find('#num').val()).val(checknumbers.join(","));
                $("#poitemroll_values" +  + $("#selectPoitemrollModal").find('#num').val()).val(checkvalues.join(","));

                window.open("{{ url('purchase/asns/exportinvoice') }}" + "?ids=" + checkvalues.join(","));
            });

            $("#btnExportCheckReport").click(function(e) {

                var checkvalues = [];
                var checknumbers = [];
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    checkvalues[i] =$(this).val();
                    checknumbers[i] = $(this).attr('data-id');
                });

                $("#poitemroll_numbers").val(checknumbers.join(","));
                $("#poitemroll_values").val(checkvalues.join(","));
                $("#poitemroll_numbers" +  + $("#selectPoitemrollModal").find('#num').val()).val(checknumbers.join(","));
                $("#poitemroll_values" +  + $("#selectPoitemrollModal").find('#num').val()).val(checkvalues.join(","));

                window.open("{{ url('purchase/asns/exportcheckreport') }}" + "?ids=" + checkvalues.join(","));
            });
        });
    </script>
@endsection