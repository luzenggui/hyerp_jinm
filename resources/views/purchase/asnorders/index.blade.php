@extends('navbarerp')

{{--<style>--}}
    {{--td.details-control {--}}
        {{--background: url('/resources/details_open.png') no-repeat center center;--}}
        {{--cursor: pointer;--}}
    {{--}--}}
    {{--tr.shown td.details-control {--}}
        {{--background: url('/resources/details_close.png') no-repeat center center;--}}
    {{--}--}}
{{--</style>--}}

@section('main')
    <div class="panel-heading">
        <a href="{{ URL::to('purchase/asnorders/' . $id . '/create') }}" class="btn btn-sm btn-success @if($asnorders->count() && $asnorders->first()->asnpackagings->count()) disabled @endif">新建</a>
    </div>

    {!! Form::hidden('asnshipment_id', $id, []) !!}

    @if ($asnorders->count())
    <table id="tableAsnorder2" class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                {{--<th></th>--}}
                <th>采购订单</th>
                <th>明细</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asnorders as $asnorder)
                <tr>
                    <td style="vertical-align: middle!important">
                        {{ $asnorder->pohead->number }}
                    </td>
                    <td  style="vertical-align: middle!important">
                        {{--<a href="{{ URL::to('/purchase/asnorders/' . $asnorder->id . '/asnpackagings') }}" target="_blank">Packaging</a>--}}
                        <table class="table table-condensed table-bordered">
                            <tbody>
                            @foreach($asnorder->asnpackagings as $asnpackaging)
                            <tr>
                                <td  style="vertical-align: middle!important">{{ $asnpackaging->poitem->poitemc->material_code }}, {{ $asnpackaging->dyelotseries }}</td>
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
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td>
                        {{--<a href="{{ URL::to('/purchase/asnorders/'.$asnorder->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>--}}
                        {!! Form::open(array('route' => array('asnorders.destroy', $asnorder->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
{{--    {!! $asnorders->render() !!}--}}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif    


@endsection

@section('script')
    {{--<script type="text/javascript" src="/DataTables/datatables.min.js"></script>--}}
    <script type="text/javascript" src="/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
//            $('#selectProject')
//                .editableSelect({
//                    effects: 'slide',
//                })
//                .on('select.editable-select', function (e, li) {
//                    if (li.val() > 0)
//                        $('input[name=project_id]').val(li.val());
//                    else
//                        $('input[name=project_id]').val('');
//                })
//            ;

//            $('#selectSohead')
//                .editableSelect({
//                    effects: 'slide',
//                })
//                .on('select.editable-select', function (e, li) {
//                    if (li.val() > 0)
//                        $('input[name=sohead_id]').val(li.val());
//                    else
//                        $('input[name=sohead_id]').val('');
//                })
//            ;

            $("#btnExport").click(function() {
                $("form#formExport").find('#sohead_id').val($('input[name=sohead_id]').val());
                $("form#formExport").submit();
            });

            $("#btnExport2").click(function() {
                $("form#formExport2").find('#sohead_id').val($('input[name=sohead_id]').val());
                $("form#formExport2").submit();
            });

            $("#btnExport3").click(function() {
                $("form#formExport3").find('#project_id').val($('input[name=project_id]').val());
                $("form#formExport3").submit();
            });

            function format ( d ) {
                // `d` is the original data object for the row
                return '<table class="table details-table" id="detail-' + d.id + '" width="100%">'+
                    '<thead>'+
                    '<tr>' +
                    '<th></th>' +
                    '<th>物料名称</th>' +
                    '<th>奖金系数</th>' +
                    '<th>应发奖金</th>' +
                    '</tr>'+
                    '</thead>'+
                    '</table>';
            }

//            var template = Handlebars.compile($("#details-template").html());
            var tableAsnorder = $('#tableAsnorder').DataTable({
                "processing": true,
                "serverSide": true,
                {{--"ajax": "{{ url('my/bonus/indexjsonbyorder') }}",--}}
                "ajax": {
                    "url": "{{ url('purchase/asnorders/asnorderjson') }}",
                    "data": function (d) {
                        d.asnshipment_id = $('input[name=asnshipment_id]').val();
//                        d.project_id = $('input[name=project_id]').val();       // because use jquery-editable-select.js, select control changed to input control
//                        d.issuedrawingdatestart = $('input[name=issuedrawingdatestart]').val();
//                        d.issuedrawingdateend = $('input[name=issuedrawingdateend]').val();
                    }
                },
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "searchable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {"data": "number", "name": "number"},
//                    {"data": "tonnage", "name": "tonnage"},
//                    {"data": "applicant", "name": "applicant"},
//                    {"data": "productioncompany", "name": "productioncompany"},
//                    {"data": "overview", "name": "overview"},
                ],
//                "fnCreatedRow": function(nRow, aData, iDataIndex) {
//                    $('td:eq(0)', nRow).html("<span class='row-details row-details-close' data_id='" + aData[1] + "'></span>&nbsp;" + aData[0]);
//                }
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    });
                }
            });

            $('#tableAsnorder tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tableAsnorder.row(tr);
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

            function initTable(tableId, data) {
                $('#' + tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    {{--ajax: "{{ url('my/bonus/detailjsonbyorder') }}/" + data.id,--}}
                    "ajax": {
                        "url": "{{ url('purchase/asnpackagings/asnpackagingjson') }}/" + data.id,
//                        "data": function (d) {
//                            d.receivedatestart = $('input[name=receivedatestart]').val();
//                            d.receivedateend = $('input[name=receivedateend]').val();
//                        }
                    },
                    columns: [
                        {
                            "className":      'details-control',
                            "orderable":      false,
                            "searchable":      false,
                            "data":           null,
                            "defaultContent": ''
                        },
                        { data: 'material_code', name: 'material_code' },
//                        { data: 'amount', name: 'amount' },
//                        { data: 'bonusfactor', name: 'bonusfactor' },
//                        { data: 'bonus', name: 'bonus' },
                    ]
                })
            };

            var tableMcitempurchase = $('#tableMcitempurchase').DataTable({
                "processing": true,
                "serverSide": true,
                {{--"ajax": "{{ url('my/bonus/indexjsonbyorder') }}",--}}
                "ajax": {
                    "url": "{{ url('approval/report2/mcitempurchasejson') }}",
                    "data": function (d) {
                        d.sohead_id = $('input[name=sohead_id]').val();
                        d.project_id = $('input[name=project_id]').val();
                        d.receivedatestart = $('input[name=receivedatestart]').val();
                        d.receivedateend = $('input[name=receivedateend]').val();
                    }
                },
                "columns": [
                    {"data": "created_date", "name": "mcitempurchases.created_at", "searchable": false},
                    {"data": "manufacturingcenter", "name": "manufacturingcenter"},
                    {"data": "totalweight", "name": "totalweight", "searchable": false},
                    {"data": "detailuse", "name": "detailuse"},
//                    {"data": "overview", "name": "overview"},
//                    {"data": "bonusfactor", "name": "bonusfactor"},
//                    {"data": "bonus", "name": "bonus"},
//                    {"data": "bonuspaid", "name": "bonuspaid"},
//                    {"data": "paybonus", "name": "paybonus"},
                ],
//                "fnCreatedRow": function(nRow, aData, iDataIndex) {
//                    $('td:eq(0)', nRow).html("<span class='row-details row-details-close' data_id='" + aData[1] + "'></span>&nbsp;" + aData[0]);
//                }
            });

            var tablePppayment = $('#tablePppayment').DataTable({
                "processing": true,
                "serverSide": true,
                {{--"ajax": "{{ url('my/bonus/indexjsonbyorder') }}",--}}
                "ajax": {
                    "url": "{{ url('approval/report2/pppaymentjson') }}",
                    "data": function (d) {
                        d.sohead_id = $('input[name=sohead_id]').val();
                        d.project_id = $('input[name=project_id]').val();
                        d.receivedatestart = $('input[name=receivedatestart]').val();
                        d.receivedateend = $('input[name=receivedateend]').val();
                    }
                },
                "columns": [
                    {"data": "created_date", "name": "pppaymentitems.created_at"},
                    {"data": "tonnage_paowan", "name": "tonnage_paowan"},
                    {"data": "tonnage_youqi", "name": "tonnage_youqi"},
                    {"data": "tonnage_rengong", "name": "tonnage_rengong"},
                    {"data": "tonnage_maohan", "name": "tonnage_maohan"},
                    {"data": "productioncompany", "name": "productioncompany"},
                    {"data": "productionoverview", "name": "productionoverview"},
                    {"data": "paymentdate", "name": "paymentdate"},
                    {"data": "applicant", "name": "applicant"},
                    {"data": "tonnage", "name": "tonnage"},
                ],
//                "fnCreatedRow": function(nRow, aData, iDataIndex) {
//                    $('td:eq(0)', nRow).html("<span class='row-details row-details-close' data_id='" + aData[1] + "'></span>&nbsp;" + aData[0]);
//                }
            });


            $('#frmSearch').on('submit', function (e) {
                tableAsnorder.draw();
                tableMcitempurchase.draw();
                tablePppayment.draw();
                e.preventDefault();
            })
        });
    </script>
@endsection
