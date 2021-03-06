@extends('navbarerp')
@section('title', '排料申请')
@section('main')

    <div class="panel-heading">
        <a href="/development/fabricdischarges/create" class="btn btn-sm btn-success">新建</a>
        @can('fabricdischarge_finish')
        {!! Form::button('保存制版完成', ['class' => 'btn btn-sm btn-success', 'id' => 'btnFinishedZb']) !!}
        {!! Form::button('保存排料完成', ['class' => 'btn btn-sm btn-success', 'id' => 'btnFinishedPl']) !!}
        @endcan
    </div>

    <div class="panel-body">
        {!! Form::open(['url' => '/development/fabricdischarges/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}

        <div class="form-group-sm">
            {!! Form::select('status1', [0 => '未制版', 1 => '已制版'], null, ['class' => 'form-control', 'placeholder' => '--制版状态--']) !!}
            {!! Form::select('status2', [0 => '未排料', 1 => '已排料'], null, ['class' => 'form-control', 'placeholder' => '--排料状态--']) !!}
            {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '版号,款号','id'=>'key']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

    @if ($fabricdischarges->count())

    <table class="table table-striped table-hover table-condensed" id="tbMain">
        <thead>
            <tr>
                <th></th>
                <th style="width:100px">等待数</th>
                <th>编号</th>
                <th>部门</th>
                <th>联系人</th>
                <th style="width:100px">联系人电话</th>
                <th>款号</th>
                <th>版号</th>
                <th style="width: 50px">时效</th>
                <th style="width: 100px">提交日期</th>
                <th style="width: 150px">创建人</th>
                <th>制版状态</th>
                <th>排料状态</th>
                @can('fabricdischarge_finish')
                <th>制版数量</th>
                <th>排料数量</th>
                @endcan
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fabricdischarges as $fabricdischarge)
                <tr>
                    <td>
                        <input type="checkbox" class="qx"  value="{{ $fabricdischarge->id }}" data-id="{{ $fabricdischarge->id }}">
                    </td>
                    <td>
                        @if($fabricdischarge->flag2<>0)
                            {{""}}
                        @else
                            {{ $fabricdischarge->getnumber($fabricdischarge->id) }}
                        @endif
                    </td>
                    <td>
                        {{ $fabricdischarge->id }}
                    </td>
                    <td>
                        {{ $fabricdischarge->department }}
                    </td>
                    <td>
                        {{ $fabricdischarge->contactor }}
                    </td>
                    <td>
                        {{ $fabricdischarge->contactor_tel }}
                    </td>
                    <td>
                        {{ $fabricdischarge->style }}
                    </td>
                    <td>
                        {{ $fabricdischarge->version }}
                    </td>
                    <td>
                        {{ $fabricdischarge->status }}
                    </td>
                    <td>
                        {{ $fabricdischarge->applydate }}
                    </td>
                    <td>
                        {{ $fabricdischarge->createname }}
                    </td>
                    <td>
                        @if($fabricdischarge->flag1==0)
                            {{"未制版"}}
                        @elseif($fabricdischarge->flag1==1)
                            {{"已制版"}}
                        @endif
                    </td>
                    <td>
                        @if($fabricdischarge->flag2==0)
                            {{"未排料"}}
                        @elseif($fabricdischarge->flag2==1)
                            {{"已排料"}}
                        @endif
                    </td>
                    @can('fabricdischarge_finish')
                    <td>
                        @if(isset($fabricdischarge->num1) and $fabricdischarge->num1 >0)
                            {{ $fabricdischarge->num1 }}
                        @else
                            {!! Form::text('', null, ['class' => 'form-control','style'=>'width: 50px','id'=>'txtnum1']) !!}
                        @endif
                    </td>
                    <td>
                        @if(isset($fabricdischarge->num2) and $fabricdischarge->num2 >0)
                            {{ $fabricdischarge->num2 }}
                        @else
                            {!! Form::text('', null, ['class' => 'form-control','style'=>'width: 50px','id'=>'txtnum2']) !!}
                        @endif
                    </td>
                    @endcan
                    <td>
                        @can('fabricdischarge_finish')

                         {{--{!! Form::open(array('url' => 'development/fabricdischarges/' . $fabricdischarge->id . '/finish',  'onsubmit' => 'return confirm("确定完成此记录?");')) !!}--}}
                         {!! Form::submit( $fabricdischarge->flag1 == 1 ? '已制版' : '制版',['class'=>'btn btn-warning btn-sm pull-left ','data-toggle' => 'modal', 'data-target' => '#inputNumModal','data-type'=>'num1', 'data-frabricid'=>$fabricdischarge->id,$fabricdischarge->flag1 == 1 ? 'disabled' : 'abled'])!!}
                         {{--{!! Form::text('num1', null, ['class' => ' pull-left ','size'=>'5px','placeholder'=>'数量','id'=>'num1']) !!}--}}
                         {{--{!! Form::close() !!}--}}

                         {{--{!! Form::open(array('url' => 'development/fabricdischarges/' . $fabricdischarge->id . '/finish2', 'onsubmit' => 'return confirm("确定完成此记录?");')) !!}--}}
                         {!! Form::submit( $fabricdischarge->flag2 == 1 ? '已排料' : '排料',['class'=>'btn btn-warning btn-sm pull-left', 'data-toggle' => 'modal', 'data-target' => '#inputNumModal','data-type'=>'num2', 'data-frabricid'=>$fabricdischarge->id,$fabricdischarge->flag2 == 1 ? 'disabled' : 'abled'])!!}

                          {{--{!! Form::close() !!}--}}
                        @endcan
                        <a href="{{ URL::to('/development/fabricdischarges/'.$fabricdischarge->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('fabricdischarges.destroy', $fabricdischarge->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm pull-left']) !!}
                        {!! Form::close() !!}
                        <a href="{{ URL::to('/development/fabricdischarges/'.$fabricdischarge->id . '/export') }}" class="btn btn-success btn-sm pull-left">导出</a>
                    </td>
                </tr>
            @endforeach
        </tbody>


    </table>
            {!! $fabricdischarges->setPath('/development/fabricdischarges')->appends($inputs)->links() !!}
    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif

    </div>
    @include('development.fabricdischarges._inputnummodal')
@stop

@section('script')
    @include('development.fabricdischarges._inputnumjs')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
                $("#btnFinishedZb").click(function(e) {

                var checkvalues = [];
                var textvalues = [];
                var isok=true;
                var ids="";
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    var rownum=$(this).parents("tr").index() +1;
                    var textvalue=$(this).parents("tr").find("td:eq(13)").find("#txtnum1").val();
                    if(textvalue==0 || typeof(textvalue)=="undefined" || textvalue=='' || textvalue==null)
                    {
                        alert("第" + rownum + "行的制版数量请输入值！");
                        isok=false;
                        return;
                    }

                    checkvalues[i] =$(this).val();
                    textvalues[i] = textvalue;
                });

                 // alert(checkvalues.join(","));
                if(isok){
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/development/fabricdischarges/updatefinishedzb') }}",
                        data: "ids=" + checkvalues.join(",") + "&num1=" + textvalues.join(","),
                        // contentType: false,
                        // processData: false,
                        //                    dataType: "json",
                        error:function(xhr, ajaxOptions, thrownError){
                            alert('thrownError');
                        },
                        success:function(result){
                            // alert(request.url.toString());
                            alert("保存成功。");
                            window.location.reload();
                            //                        $('#sendAsnModal').modal('toggle');
                        }
                    });
                }
                });

            $("#btnFinishedPl").click(function(e) {

                var checkvalues = [];
                var checknumbers = [];
                var ids="";
                var isok=true;
                $("#tbMain").find("input[type='checkbox']:checked").each(function (i) {
                    var rownum=$(this).parents("tr").index() +1;
                    var textvalue=$(this).parents("tr").find("td:eq(13)").find("#txtnum2").val();
                    if(textvalue==0 || typeof(textvalue)=="undefined" || textvalue=='' || textvalue==null)
                    {
                        alert("第" + rownum  + "行的排版数量请输入值！");
                        isok=false;
                        return;
                    }
                    checkvalues[i] =$(this).val();
                    checknumbers[i] = $(this).attr('data-id');
                });

                // alert(checkvalues.join(","));
                if(isok)
                {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/development/fabricdischarges/updatefinishedpl') }}",
                        data: "ids=" + checkvalues.join(",")+ "&num2=" + textvalues.join(","),
                        // contentType: false,
                        // processData: false,
                        //                    dataType: "json",
                        error:function(xhr, ajaxOptions, thrownError){
                            alert('thrownError');
                        },
                        success:function(result){
                            alert("保存成功。");
                            window.location.reload();
                            //                        $('#sendAsnModal').modal('toggle');
                        }
                    });
                }
            });
        });
    </script>
@endsection