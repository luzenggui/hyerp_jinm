@extends('navbarerp')
@section('title', '生成时间段的考勤数据')
@section('main')


            {{ Form::open(array('class' => 'form-horizontal', 'id' => 'formMain')) }}
        {{--<div class="form-group">--}}
            {!! Form::label('sdate', '开始日期(Sdate)', ['class' => 'form-inline']) !!}
            {!! Form::date('sdate', null, ['class' => 'form-inline']) !!}
            {!! Form::label('edate', '结束日期(Edate)', ['class' => 'form-inline']) !!}
            {!! Form::date('edate', null, ['class' => 'form-inline']) !!}

            {!! Form::button('生成', ['class' => 'btn btn-success ','id'=>'Datasync']) !!}

        {{--</div>--}}
            {!! Form::close() !!}

@stop

@section('script')
    <script type="text/javascript">
        $('#Datasync').click(function () {
            if ($("#sdate").val() == "" || $("#edate").val() == "") {
                alert('Please input date value');
                return;
            }
            $.ajax({
                type: "POST",
                url: "{!! url('/personal/checkrecords/synchronization') !!}" ,
                data:$("form#formMain").serialize(),
                datatype:"json",
                success: function(result) {
                      // alert($("form#formMain").serialize());
                    // alert(result.errorcode);
                    if (result.errorcode == 0)
                    {
                        alert(result.errormsg );

                    }
                    else
                        alert(result.errormsg );
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(thrownError);
                    alert('error');
                }
            });
        });
    </script>
@stop
