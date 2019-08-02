<script type="text/javascript">
    jQuery(document).ready(function(e) {









        $('#selectPurchaseorderModal').on('show.bs.modal', function (e) {
            $("#listsalesorders").empty();

            var text = $(e.relatedTarget);
            var modal = $(this);

//                modal.find('#name').val(text.data('name'));
//                modal.find('#id').val(text.data('id'));
//                modal.find('#supplierid').val(text.data('supplierid'));
//                modal.find('#poheadamount').val(text.data('poheadamount'));
        });

        $("#btnSearchOrder").click(function() {
            if ($("#keyOrder").val() == "") {
                alert('请输入关键字');
                return;
            }
            $.ajax({
                type: "GET",
                url: "{!! url('/purchase/purchaseorders/getitemsbyorderkey/') !!}" + "/" + $("#keyOrder").val(),
                success: function(result) {
                    var strhtml = '';
                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectOrder_' + String(i);
                        strhtml += "<button type='button' class='list-group-item' id='" + btnId + "'>" + "<h4>" + field.number + "</h4><p>" + field.orderdate + " | " + field.descrip + "</p></button>"
                    });
                    if (strhtml == '')
                        strhtml = '无记录。';
                    $("#listsalesorders").empty().append(strhtml);

                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectOrder_' + String(i);
                        addBtnClickEvent(btnId, field);
                    });
                    // addBtnClickEvent('btnSelectOrder_0');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error');
                }
            });
        });

        function addBtnClickEvent(btnId, field)
        {
            $("#" + btnId).bind("click", function() {
                $('#selectPurchaseorderModal').modal('toggle');
                // $("#order_number").val(number);
                // $("#order_id").val(salesorderid);
                $("#pohead_number").val(field.number);
                $("#pohead_id").val(field.id);

            });
        }

        $('#selectSupplierModal').on('show.bs.modal', function (e) {
            $("#listsuppliers").empty();

            var text = $(e.relatedTarget);
            // alert(text.data('id'));

            var modal = $(this);
            modal.find('#name').val(text.data('name'));
            modal.find('#id').val(text.data('id'));
            // alert(modal.find('#id').val());
        });

        $("#btnSearchSupplier").click(function() {
            if ($("#keySupplier").val() == "") {
                alert('请输入关键字');
                return;
            }
            $.ajax({
                type: "GET",
                url: "{!! url('/purchase/vendinfos/getitemsbykey/') !!}" + "/" + $("#keySupplier").val(),
                success: function(result) {
                    var strhtml = '';
                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectCustomer_' + String(i);
                        strhtml += "<button type='button' class='list-group-item' id='" + btnId + "'>" + "<h4>" + field.name + "</h4></button>"
                    });
                    if (strhtml == '')
                        strhtml = '无记录。';
                    $("#listsuppliers").empty().append(strhtml);

                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectCustomer_' + String(i);
                        addBtnClickEventSupplier(btnId, field.id, field.name, field);
                    });
                    // addBtnClickEvent('btnSelectOrder_0');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error');
                }
            });
        });

        function addBtnClickEventSupplier(btnId, supplierid, name, field)
        {
            $("#" + btnId).bind("click", function() {
                $('#selectSupplierModal').modal('toggle');
                $("#" + $("#selectSupplierModal").find('#name').val()).val(name);
                $("#" + $("#selectSupplierModal").find('#id').val()).val(supplierid);
                $("#supplier_bank").val(field.bank);
                $("#supplier_bankaccountnumber").val(field.bankaccountnumber);
                $("#vendbank_id").val(field.vendbank_id);
                $("#selectSupplierBankModal").find("#vendinfo_id").val(supplierid);
            });
        }

        $('#selectSupplierBankModal').on('show.bs.modal', function (e) {
            $("#listsupplierbanks").empty();
            $("form#formAddVendbank").hide();
            $("#selectSupplierBankModal").find("#bankname").val("");
            $("#selectSupplierBankModal").find("#accountnum").val("");

            var text = $(e.relatedTarget);
            var modal = $(this);

            modal.find('#name').val(text.data('name'));
            modal.find('#id').val(text.data('id'));
        });

        $('#selectSupplierBankModal').on('shown.bs.modal', function (e) {
            // $("#listsupplierbanks").empty();

            var text = $(e.relatedTarget);
            var modal = $(this);

            // modal.find('#listsupplierbanks').append("aaaa");

            $.ajax({
                type: "GET",
                url: "{!! url('/purchase/vendbank/getitemsbyvendid/') !!}" + "/" + $("#supplier_id").val(),
                success: function(result) {
                    var strhtml = '';
                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectSupplierbank_' + String(i);
                        // strhtml += "<button type='button' class='list-group-item' id='" + btnId + "'>" + "<h4>" + field.bankname + "</h4><p>" + field.accountnum + "</p></button>"
                        strhtml += "<button type='button' class='list-group-item' id='" + btnId + "'>" + field.bankname + ": " + field.accountnum + "</button>"
                    });
                    if (strhtml == '')
                        strhtml = '无记录。';
                    modal.find('#listsupplierbanks').empty().append(strhtml);

                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectSupplierbank_' + String(i);
                        addBtnClickEventSupplierbank(btnId, field);
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error');
                }
            });
        });

        function addBtnClickEventSupplierbank(btnId, field)
        {
            $("#" + btnId).bind("click", function() {
                $('#selectSupplierBankModal').modal('toggle');
                // $("#" + $("#selectSupplierModal").find('#name').val()).val(name);
                // $("#" + $("#selectSupplierModal").find('#id').val()).val(supplierid);
                $("#vendbank_id").val(field.id);
                $("#supplier_bank").val(field.bankname);
                $("#supplier_bankaccountnumber").val(field.accountnum);
            });
        }

        $("#btnShowAddVendbank").click(function() {
            $("form#formAddVendbank").show();
        });

        $("#btnAddVendbank").click(function() {
            if ($("#selectSupplierBankModal").find("#vendinfo_id").val() == 0)
            {
                alert("还未选中供应商。");
                return;
            }
            if ($("#selectSupplierBankModal").find("#bankname").val().trim() == "" || $("#selectSupplierBankModal").find("#accountnum").val().trim() == "")
            {
                alert("开户行和银行账号不能为空。");
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ url('purchase/vendbank') }}",
                data: $("form#formAddVendbank").serialize(),
                dataType: "json",
                error:function(xhr, ajaxOptions, thrownError){
                    alert('error');
                },
                success:function(result){
                    alert("新增成功。");
                    $('#selectSupplierBankModal').modal('toggle');
                    $("#vendbank_id").val(result.id);
                    $("#supplier_bank").val(result.bankname);
                    $("#supplier_bankaccountnumber").val(result.accountnum);
                },
            });
        });
    });
</script>
