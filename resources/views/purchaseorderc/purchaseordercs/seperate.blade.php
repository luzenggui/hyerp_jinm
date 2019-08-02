@extends('navbarerp')

@section('title', 'PO分单')


@section('main')
    <div class="panel-heading">

    </div>

    <div class="panel-body">
        {!! Form::open(['url' => 'purchase/purchaseorders/storeseperate', 'class' => 'form-horizontal', 'id' => 'frmPurchaseorder']) !!}
        @include('purchaseorderc.purchaseordercs._seperate',
            [
                'submitButtonText' => '保存',
                'attr' => '',
                'btnclass' => 'btn btn-primary',
            ])
        {!! Form::close() !!}
    </div>

    @include('errors.list')

    <div class="modal fade" id="selectVendorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">选择供应商</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '供应商名称', 'id' => 'keyVendor']) !!}
                        <span class="input-group-btn">
                   		{!! Form::button('查找', ['class' => 'btn btn-default btn-sm', 'id' => 'btnSearchVendor']) !!}
                   	</span>
                    </div>
                    {!! Form::hidden('name', null, ['id' => 'name']) !!}
                    {!! Form::hidden('id', null, ['id' => 'id']) !!}
                    <p>
                    <div class="list-group" id="listvendors">

                    </div>
                    </p>
                    <form id="formAccept">
                        {!! csrf_field() !!}

                        {{--                    {!! Form::hidden('reimbursement_id', $reimbursement->id, ['class' => 'form-control']) !!}
                                            {!! Form::hidden('status', 0, ['class' => 'form-control']) !!} --}}
                    </form>
                </div>
                {{--            <div class="modal-footer">
                                {!! Form::button('取消', ['class' => 'btn btn-sm', 'data-dismiss' => 'modal']) !!}
                                {!! Form::button('确定', ['class' => 'btn btn-sm', 'id' => 'btnAccept']) !!}
                            </div>--}}
            </div>
        </div>
    </div>



@endsection

@section('script')
    {{--<script type="text/javascript" src="/DataTables/datatables.js"></script>--}}
    <script type="text/javascript">
        jQuery(document).ready(function(e) {











            $('#selectVendorModal').on('show.bs.modal', function (e) {
                $("#listvendors").empty();

                var text = $(e.relatedTarget);
                // alert(text.data('id'));

//                var modal = $(this);
//                modal.find('#name').val(text.data('name'));
//                modal.find('#id').val(text.data('id'));
            });

            $("#btnSearchVendor").click(function() {
                if ($("#keyVendor").val() == "") {
                    alert('请输入关键字');
                    return;
                }
                $.ajax({
                    type: "GET",
                    url: "{!! url('/purchase/vendors/getitemsbykey/') !!}" + "/" + $("#keyVendor").val(),
                    success: function(result) {
                        var strhtml = '';
                        $.each(result.data, function(i, field) {
                            btnId = 'btnSelectVendor_' + String(i);
                            strhtml += "<button type='button' class='list-group-item' id='" + btnId + "'>" + "<h4>" + field.name + "</h4></button>"
                        });
                        if (strhtml == '')
                            strhtml = '无记录。';
                        $("#listvendors").empty().append(strhtml);

                        $.each(result.data, function(i, field) {
                            btnId = 'btnSelectVendor_' + String(i);
                            addBtnClickEventVendor(btnId, field);
                        });
                        // addBtnClickEvent('btnSelectOrder_0');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert('error');
                    }
                });
            });

            function addBtnClickEventVendor(btnId, field)
            {
                $("#" + btnId).bind("click", function() {
                    $('#selectVendorModal').modal('toggle');
//                    $("#" + $("#selectVendorModal").find('#name').val()).val(name);
//                    $("#" + $("#selectVendorModal").find('#id').val()).val(supplierid);
                    $("#vendor_name").val(field.name);
                    $("#vendor_id").val(field.id);
//                    $("#vendbank_id").val(field.vendbank_id);
//                    $("#selectSupplierBankModal").find("#vendinfo_id").val(supplierid);
                });
            }

            $("#btnSubmit").click(function() {
                var itemArray = new Array();

                $("#tablePacking tbody tr").each(function () {
                    var poitemc_id = this.dataset.poitemc_id;
                    console.info(poitemc_id);
                    console.info($(this).find("input[name='quantity']").val());
                    var trrow = $(this);

                    var itemObject = new Object();
                    itemObject.poitemc_id = poitemc_id;
                    itemObject.quantity = trrow.find("input[name='quantity']").val();
                    itemObject.chinesedescrip = trrow.find("input[name='chinesedescrip']").val();
                    itemObject.unitprice = trrow.find("input[name='unitprice']").val();

                    if (itemObject.quantity.length > 0)
                    {
                        console.info(JSON.stringify(itemObject));
                        itemArray.push(itemObject);
                    }
                });

//                $("div[name='poitemcquantity_container']").each(function(i){
//                    var container = $(this);
//                    console.info(container.find("td").length);
//                    console.info($(this).find("input[name='quantity']").val());
//                    container.find("td").each(function () {
//                        alert('aaa');
//                    });
//                    var poitemc_id = this.dataset.poitemc_id;
//                    console.info(poitemc_id);
//
//                    var itemObject = new Object();
////                        console.info(row.find("input[name='roll_no']").val());
//                    console.info(container.find("input[name='quantity']").val());
//
//                    itemObject.poitemc_id = poitemc_id;
////                        itemObject.roll_no = container.find("input[name='roll_no']").val();
//                    itemObject.quantity = container.find("input[name='quantity']").val();
//                    itemObject.chinesedescrip = container.find("input[name='chinesedescrip']").val();
//                    itemObject.unitprice = container.find("input[name='unitprice']").val();
//
//                    if (itemObject.quantity.length > 0)
//                    {
//                        console.info(JSON.stringify(itemObject));
//                        itemArray.push(itemObject);
//                    }
//
//
////                    alert(JSON.stringify(itemArray));
////                    return false;
////                    alert($("form#formMain").serialize());
//                });

                console.info(JSON.stringify(itemArray));
                $("#items_string").val(JSON.stringify(itemArray));

                $("form#frmPurchaseorder").submit();
            });
        });
    </script>
@endsection
