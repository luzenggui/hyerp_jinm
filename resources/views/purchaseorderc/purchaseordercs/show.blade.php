@extends('navbarerp')

@section('main')


    {!! Form::model($purchaseorder, ['class' => 'form-horizontal']) !!}
    @include('purchaseorderc.purchaseordercs._form',
        [
            'submitButtonText' => '-',
            'attr' => 'readonly',
            'btnclass' => 'hidden',
        ])
    {!! Form::close() !!}









    {{-- pdf 预览 --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        PDF 预览标题
                    </h4>
                </div>
                <div class="modal-body" >
                    <a class="media" id="pdfContainer"
                       @if (isset($paymentrequest->purchaseorder_hxold->businesscontract)) href="{!! config('custom.hxold.purchase_businesscontract_webdir') . $paymentrequest->purchaseorder_hxold->id . '/' . $paymentrequest->purchaseorder_hxold->businesscontract !!}" @else href="" @endif>

                    </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

@endsection


@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("#btnPreview").click(function() {
                window.print();
            });

            $("#btnRetract").bind("click", function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('approval/paymentrequestretract') }}",
                    data: $("form#formRetract").serialize(),
                    contentType:"application/x-www-form-urlencoded",
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert($("form#formRetract").serialize());
                        alert('error');
                        alert(xhr.status);
                        alert(xhr.responseText);
                        alert(ajaxOptions);
                        alert(thrownError);
                    },
                    success: function(result) {
//                        alert('操作完成.');
                        $('#rejectModal').modal('toggle');
                        {{--                        location.href = "{{ url('approval/mindexmyapproval') }}";--}}
                                                location.reload(true);
                    },
                });
            });
        });
    </script>


    @yield('for_paymentrequestapprovals_create_script')
@endsection

