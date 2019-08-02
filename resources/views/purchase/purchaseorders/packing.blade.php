@extends('navbarerp')

@section('title', '采购订单打包')

<style>
    td.details-control {
        background: url('/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/resources/details_close.png') no-repeat center center;
    }
</style>

@section('main')
    <div class="panel-heading">
        <a href="{{ url('purchase/purchaseorders/' . $id . '/importpacking') }}" class="btn btn-sm btn-success">导入</a>
    </div>
    

    <table id="tablePacking" class="table table-striped table-hover table-full-width">
        <thead>
            <tr>
                <th>面料序列号</th>
                <th>物料代码</th>
                <th>颜色</th>
                <th>中文描述</th>
                <th>数量</th>
                <th>单位</th>
                <th>面料尺寸</th>
                {{--<th>运输方式</th>--}}
                {{--<th>发货日期</th>--}}
                <th>已发数量</th>
                <th>打包</th>
            </tr>
        </thead>
        <tbody>
        @foreach($poitems as $poitem)
            <tr>
                <td>
                    {{ $poitem->poitemc->fabric_sequence_no }}
                </td>
                <td>
                    {{ $poitem->poitemc->material_code }}
                </td>
                <td>
                    {{ $poitem->poitemc->color_desc1 }}
                </td>
                <td>
                    {{ $poitem->chinesedescrip }}
                </td>
                <td>
                    {{ $poitem->quantity }}
                </td>
                <td>
                    {{ $poitem->poitemc->unit }}
                </td>
                <td>
                    {{ $poitem->poitemc->fabric_width }}
                </td>
                {{--<td>--}}
                    {{--{{ $poitem->poitemc->transportation_method_type_code }}--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--{{ $poitem->poitemc->shipment_date }}--}}
                {{--</td>--}}
                <td>
                    {{ $poitem->poitemrolls->sum('quantity_shipped') }}
                </td>
                {{--
                <td>
                    <a href="{{ URL::to('/purchase/purchaseorders/' . $purchaseorder->id . '/detail') }}" target="_blank">明细</a>
                </td>
                --}}
                <td>
                    <div id="divTd_{{ $poitem->id }}" name="asn_container" data-poitem_id="{{ $poitem->id }}">
                        <div class="row">
                            {!! Form::text('roll_number', null, ['placeholder' => '卷号']) !!}
                            {!! Form::text('quantity_shipped', null, ['placeholder' => '数量(Y)']) !!}
                            {!! Form::text('gross_weight', null, ['placeholder' => '毛重(KG)']) !!}
                            {!! Form::text('fabric_width', $poitem->fabric_width(), ['placeholder' => '面料宽度(IN)']) !!}
                            {!! Form::text('net_weight', null, ['placeholder' => '净重(KG)']) !!}
                            {!! Form::text('dyelotseries', null, ['placeholder' => '等级']) !!}
                            {!! Form::text('remark', null, ['placeholder' => '备注']) !!}
                            {!! Form::text('remark2', null, ['placeholder' => '备注2']) !!}
                            {!! Form::text('remark3', null, ['placeholder' => '备注3']) !!}
                            {!! Form::button('+', ['name' => 'btnAddLine', 'data-seq' => $poitem->id, 'data-fabric_width' => $poitem->fabric_width()]) !!}
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {!! Form::open(['url' => '/purchase/poitems/packingstore', 'class' => 'pull-left', 'id' => 'frmStorePacking']) !!}
        {!! Form::hidden('number', null) !!}
        {!! Form::hidden('items_string', null, ['id' => 'items_string']) !!}
        {!! Form::button('打包', ['class' => 'btn btn-primary', 'id' => 'btnStorePacking']) !!}
    {!! Form::close() !!}

@endsection

@section('script')
    {{--<script type="text/javascript" src="/DataTables/datatables.js"></script>--}}
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("button[name='btnAddLine']").click(function () {
                var itemHtml = '\
                    <div class="row">\
                        <input placeholder="卷号" name="roll_number" type="text">\
                        <input placeholder="数量" name="quantity_shipped" type="text">\
                        <input placeholder="毛重" name="gross_weight" type="text">\
                        <input placeholder="面料宽度" name="fabric_width" type="text" value="' + this.dataset.fabric_width +'">\
                        <input placeholder="净重" name="net_weight" type="text">\
                        <input placeholder="等级" name="dyelotseries" type="text">\
                        <input placeholder="备注" name="remark" type="text">\
                        <input placeholder="备注2" name="remark2" type="text">\
                        <input placeholder="备注3" name="remark3" type="text">\
                        <button name="btnDeleteLine" type="button" onclick="delLine(this);">-</button>\
                    </div>\
                    ';
                $("#divTd_" + this.dataset.seq).append(itemHtml);
            });

            delLine = function (e) {
                $(e).parent().remove();
            };


            $("#btnStorePacking").click(function() {
                var itemArray = new Array();

                $("div[name='asn_container']").each(function(i){
                    var container = $(this);
                    var poitem_id = this.dataset.poitem_id;
                    console.info(poitem_id);

                    container.find("div[class='row']").each(function (i) {
                        var itemObject = new Object();
                        var row = $(this);
                        console.info(row.find("input[name='roll_number']").val());
                        console.info(row.find("input[name='quantity_shipped']").val());

                        itemObject.poitem_id = poitem_id;
                        itemObject.roll_number = row.find("input[name='roll_number']").val();
                        itemObject.quantity_shipped = row.find("input[name='quantity_shipped']").val();
                        itemObject.gross_weight = row.find("input[name='gross_weight']").val();
                        itemObject.fabric_width = row.find("input[name='fabric_width']").val();
                        itemObject.net_weight = row.find("input[name='net_weight']").val();
                        itemObject.dyelotseries = row.find("input[name='dyelotseries']").val();
                        itemObject.remark = row.find("input[name='remark']").val();
                        itemObject.remark2 = row.find("input[name='remark2']").val();
                        itemObject.remark3 = row.find("input[name='remark3']").val();

                        if (itemObject.roll_number.length > 0 && itemObject.quantity_shipped.length > 0)
                        {
                            console.info(JSON.stringify(itemObject));
                            itemArray.push(itemObject);
                        }
                    });


//                    alert(JSON.stringify(itemArray));
//                    return false;
//                    alert($("form#formMain").serialize());
                });
                console.info(JSON.stringify(itemArray));
                $("#items_string").val(JSON.stringify(itemArray));

                $("form#frmStorePacking").submit();
            });
//
//            $("#btnExport2").click(function() {
//                $("form#formExport2").find('#sohead_id').val($('input[name=sohead_id]').val());
//                $("form#formExport2").submit();
//            });
//
//            $("#btnExport3").click(function() {
//                $("form#formExport3").find('#project_id').val($('input[name=project_id]').val());
//                $("form#formExport3").submit();
//            });

//            function format ( d ) {
//                // `d` is the original data object for the row
//                return '<table class="table details-table" id="detail-' + d.id + '">'+
//                    '<thead>'+
//                    '<tr>' +
//                    '<th>收款日期</th>' +
//                    '<th>收款金额</th>' +
//                    '<th>奖金系数</th>' +
//                    '<th>应发奖金</th>' +
//                    '</tr>'+
//                    '</thead>'+
//                    '</table>';
//            }

            {{--var tablePacking = $('#tablePacking').DataTable({--}}
                {{--"processing": true,--}}
                {{--"serverSide": true,--}}
                {{--"ajax": "{{ url('my/bonus/indexjsonbyorder') }}",--}}
                {{--"ajax": {--}}
                    {{--"url": "{{ url('purchaseorderc/purchaseordercs/' . $id . '/detailjson') }}",--}}
                    {{--"data": function (d) {--}}
                        {{--d.soheadc_id = {{ $id }};--}}
{{--//                        d.project_id = $('input[name=project_id]').val();       // because use jquery-editable-select.js, select control changed to input control--}}
{{--//                        d.issuedrawingdatestart = $('input[name=issuedrawingdatestart]').val();--}}
{{--//                        d.issuedrawingdateend = $('input[name=issuedrawingdateend]').val();--}}
                    {{--}--}}
                {{--},--}}
                {{--"columns": [--}}
{{--//                    {--}}
{{--//                        "orderable":      false,--}}
{{--//                        "searchable":      false,--}}
{{--//                        "data":           null,--}}
{{--//                        "defaultContent": ''--}}
{{--//                    },--}}
                    {{--{"data": "fabric_sequence_no", "name": "fabric_sequence_no"},--}}
                    {{--{"data": "material_code", "name": "material_code"},--}}
                    {{--{"data": "quantity", "name": "quantity"},--}}
                    {{--{"data": "unit", "name": "unit"},--}}
                    {{--{"data": "fabric_width", "name": "fabric_width"},--}}
                    {{--{"data": "transportation_method_type_code", "name": "transportation_method_type_code"},--}}
                    {{--{"data": "unit_price", "name": "unit_price"},--}}
                    {{--{"data": "shipment_date", "name": "shipment_date"},--}}
                    {{--{"data": "packedcount", "name": "packedcount"},--}}
                    {{--{"data": "packingcount", "name": "packingcount"},--}}
                {{--],--}}
{{--//                "fnCreatedRow": function(nRow, aData, iDataIndex) {--}}
{{--//                    $('td:eq(0)', nRow).html("<span class='row-details row-details-close' data_id='" + aData[1] + "'></span>&nbsp;" + aData[0]);--}}
{{--//                }--}}
                {{--initComplete: function () {--}}
                    {{--this.api().columns().every(function () {--}}
                        {{--var column = this;--}}
                        {{--var input = document.createElement("input");--}}
                        {{--$(input).appendTo($(column.footer()).empty())--}}
                            {{--.on('change', function () {--}}
                                {{--column.search($(this).val(), false, false, true).draw();--}}
                            {{--});--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}

            $('#tableIssuedrawing tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tableIssuedrawing.row(tr);
                var tableId = 'detail-' + row.data().id;

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
//                    row.child(template(row.data())).show();
                    initTable(tableId, row.data());
                    tr.addClass('shown');
                    tr.next().find('td').addClass('no-padding bg-gray');
                }
            } );

            {{--function initTable(tableId, data) {--}}
                {{--$('#' + tableId).DataTable({--}}
                    {{--processing: true,--}}
                    {{--serverSide: true,--}}
                    {{--ajax: "{{ url('my/bonus/detailjsonbyorder') }}/" + data.id,--}}
                    {{--"ajax": {--}}
                        {{--"url": "{{ url('my/bonus/detailjsonbyorder') }}/" + data.id,--}}
                        {{--"data": function (d) {--}}
                            {{--d.receivedatestart = $('input[name=receivedatestart]').val();--}}
                            {{--d.receivedateend = $('input[name=receivedateend]').val();--}}
                        {{--}--}}
                    {{--},--}}
                    {{--columns: [--}}
                        {{--{ data: 'receiptdate', name: 'receiptdate' },--}}
                        {{--{ data: 'amount', name: 'amount' },--}}
                        {{--{ data: 'bonusfactor', name: 'bonusfactor' },--}}
                        {{--{ data: 'bonus', name: 'bonus' },--}}
                    {{--]--}}
                {{--})--}}
            {{--};--}}






            $('#frmSearch').on('submit', function (e) {
                tableIssuedrawing.draw();
                tableMcitempurchase.draw();
                tablePppayment.draw();
                e.preventDefault();
            })
        });
    </script>
@endsection
