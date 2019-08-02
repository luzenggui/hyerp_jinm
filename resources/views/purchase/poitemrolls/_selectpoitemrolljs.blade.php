<script type="text/javascript">
    jQuery(document).ready(function(e) {
        var isCheckAll = false;
        $('#selectPoitemrollModal').on('show.bs.modal', function (e) {
            $("#listpoitemrolls").empty();

            var text = $(e.relatedTarget);
            var modal = $(this);

            modal.find('#name').val(text.data('name'));
            modal.find('#id').val(text.data('id'));
            modal.find('#supplierid').val(text.data('supplierid'));
            modal.find('#poheadamount').val(text.data('poheadamount'));
            modal.find('#num').val(text.data('num'));
        });

        $('#selectPoitemrollModal').on('shown.bs.modal', function (e) {
            $("#listpoitemrolls").empty();

            var text = $(e.relatedTarget);
            var modal = $(this);

            $.ajax({
                type: "GET",
                url: "{!! url('/purchase/poitemrolls/getitemsbypoitem/') !!}" + "/" + text.data('poitem_id'),
                success: function(result) {
                    var strhtml = '';
                    $.each(result.data, function(i, field) {
                        btnId = 'btnSelectDrawingchecker_' + String(i);
                        strhtml += '<label class="list-group-item"><input type="checkbox" class="qx" name="check_poitemroll" value="' + field.id + '" data-number="' + field.roll_number + '">卷号: ' + field.roll_number + ', 数量: ' + field.quantity_shipped + '</label>';
//                        strhtml += "<button type='button' class='list-group-item' id='" + btnId + "'>" + "<h4>" + field.name + "</h4></button>"
                    });
                    if (strhtml == '')
                        strhtml = '无记录。';
                    else
                    {
                        $("#checkall").empty().append('<label><input type="checkbox" id="ck_all">全选/取消' + '</label>');

                        $("#ck_all").click(function (e) {
                            var status = $(this).prop("checked");
//                            console.log(status);
                            var ck = $(".qx").prop("checked", status);
                        })
                    }
                    $("#listpoitemrolls").empty().append(strhtml);

//                    $.each(result.data, function(i, field) {
//                        btnId = 'btnSelectDrawingchecker_' + String(i);
//                        addBtnClickEvent(btnId, field);
//                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error');
                }
            });
        });

        $("#btnok_selectpoitemrolls").click(function(e) {

            var checkvalues = [];
            var checknumbers = [];
            $("#selectPoitemrollModal").find("input[type='checkbox']:checked").each(function (i) {
                checkvalues[i] =$(this).val();
                checknumbers[i] = $(this).attr('data-number');
            });

//            var text = $(this).parent.parent;
//            alert(text.data('poitem_id'));

            $("#poitemroll_numbers").val(checknumbers.join(","));
            $("#poitemroll_values").val(checkvalues.join(","));
            $("#poitemroll_numbers" +  + $("#selectPoitemrollModal").find('#num').val()).val(checknumbers.join(","));
            $("#poitemroll_values" +  + $("#selectPoitemrollModal").find('#num').val()).val(checkvalues.join(","));
            $('#selectPoitemrollModal').modal("toggle");
        });




    });
</script>
