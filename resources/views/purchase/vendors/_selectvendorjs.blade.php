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

            $("div[name='poitemcquantity_container']").each(function(i){
                var container = $(this);
                var poitemc_id = this.dataset.poitemc_id;
                console.info(poitemc_id);

                container.find("div[class='row']").each(function (i) {
                    var itemObject = new Object();
                    var row = $(this);
//                        console.info(row.find("input[name='roll_no']").val());
                    console.info(row.find("input[name='quantity']").val());

                    itemObject.poitemc_id = poitemc_id;
//                        itemObject.roll_no = row.find("input[name='roll_no']").val();
                    itemObject.quantity = row.find("input[name='quantity']").val();

                    if (itemObject.quantity.length > 0)
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

            $("form#frmPurchaseorder").submit();
        });
    });
</script>
