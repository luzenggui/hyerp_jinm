<script type="text/javascript">
    jQuery(document).ready(function(e) {

        $('#inputNumModal').on('show.bs.modal', function (e) {
            $("#keynum").empty();

            var modal = $(this);
            modal.find('#type').val($(e.relatedTarget).data('type'));
            modal.find('#frabricid').val($(e.relatedTarget).data('frabricid'));
        });


        $("#btnok_inputnum").click(function() {
            if ($("#keynum").val() == "") {
                alert('请输入关键字');
                return;
            }
            $.ajax({
                type: "POST",
                url: "{!! url('/development/fabricdischarges/finish') !!}",
                data: $("form#formMain").serialize(),
                success: function(result) {
                    if (result.errorcode >= 0)
                    {
                        $('#inputNumModal').modal('toggle');
                        window.location.reload('true');
                        // redirect('development/fabricdischarges');
                    }
                    else
                        alert(result.errormsg );
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error');
                }
            });
        });
    });
</script>