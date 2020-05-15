@extends('navbarerp')

@section('title', '询价单')

@section('main')
@can('inquirysheets_view')
    <div class="panel-heading">
        <div class="panel-title">询价单
{{--            <div class="pull-right">
                <a href="{{ URL::to('product/itemclasses') }}" target="_blank" class="btn btn-sm btn-success">{{'物料类型管理'}}</a>
                <a href="{{ URL::to('product/characteristics') }}" target="_blank" class="btn btn-sm btn-success">{{'物料属性管理'}}</a>
            </div> --}}
            <a href="inquiry_sheets/mcreate" class="btn btn-sm btn-success pull-right">新建</a>
        </div>
    </div>
    
    <div class="panel-body">
{{--
        <a href="{{ URL::to('approval/items/create') }}" class="btn btn-sm btn-success">新建</a>
--}}
        <form class="pull-right" action="/department6/inquiry_sheets/export" method="post">
            {!! csrf_field() !!}
            <div class="pull-right">
                <button type="submit" class="btn btn-default btn-sm">导出</button>
            </div>
        </form>


        {!! Form::open(['url' => '/department6/inquiry_sheets/search', 'class' => 'pull-right form-inline', 'id' => 'frmCondition']) !!}
            <div class="form-group-sm">
                {!! Form::label('createdatelabel', '创建时间:', ['class' => 'control-label']) !!}
                {!! Form::date('createdatestart', null, ['class' => 'form-control']) !!}
                {!! Form::label('approvaldatelabelto', '-', ['class' => 'control-label']) !!}
                {!! Form::date('createdateend', null, ['class' => 'form-control']) !!}

                {{--
                {!! Form::select('paymentmethod', ['支票' => '支票', '贷记' => '贷记', '电汇' => '电汇', '汇票' => '汇票', '现金' => '现金', '银行卡' => '银行卡', '其他' => '其他'], null, ['class' => 'form-control', 'placeholder' => '--付款方式--']) !!}

                {!! Form::select('paymentstatus', ['0' => '已付款', '-1' => '未付款'], null, ['class' => 'form-control', 'placeholder' => '--付款状态--']); !!}
                {!! Form::select('approvalstatus', ['1' => '审批中', '0' => '已通过', '-2' => '未通过'], null, ['class' => 'form-control', 'placeholder' => '--审批状态--']); !!}
                --}}
                {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '供应商编号']) !!}
                {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}

            </div>
        {!! Form::close() !!}


    </div>

    @if ($inquiry_sheets->count())

    <table id="userDataTable" class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th>创建日期</th>
                <th>客户</th>
                <th>产品照片</th>
                <th>供应商编号</th>
                <th >操作</th>

            </tr>
        </thead>

        <tbody>
            @foreach($inquiry_sheets as $inquiry_sheet)
                <tr>
                    <td>
                        {{ $inquiry_sheet->created_at }}
                    </td>
                    <td>
                        {{ $inquiry_sheet->customername }}
                    </td>
                    <td>
                        {{ $inquiry_sheet->prod_photo }}
                    </td>
                    <td>
                        {{ $inquiry_sheet->supplier_stock_number }}
                    </td>
                    <td>
                        <a href="{{ URL::to('/department6/inquiry_sheets/'.$inquiry_sheet->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                        {!! Form::open(array('route' => array('inquiry_sheets.destroy', $inquiry_sheet->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                        {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
            @endforeach
        </tbody>

    </table>


    {!! $inquiry_sheets->setPath('/department6/inquiry_sheets')->appends($inputs)->links() !!}


    @else
    <div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无记录', [], 'layouts'}}
    </div>
    @endif
@endcan
@endsection

@section('script')
    <script type="text/javascript" src="/DataTables/datatables.js"></script>
    {{--<script type="text/javascript" src="/DataTables/DataTables-1.10.16/js/jquery.dataTables.js"></script>--}}
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("#btnExport").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('department6/inquiry_sheets/export') }}",
                    // data: $("form#formAddVendbank").serialize(),
                    // dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
                        alert("导出成功:" + result);
                    },
                }); 
            });
        });
    </script>
@endsection