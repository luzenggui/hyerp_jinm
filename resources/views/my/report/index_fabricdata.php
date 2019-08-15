@extends('navbarerp')

@section('title', '排版排料统计')

@section('main')
<div class="panel-heading">
    <div class="panel-title">排版排料统计</div>
</div>

<div class="panel-body">

    {!! Form::open(['url' => '/my/report/fabricdata', 'class' => 'pull-right form-inline']) !!}
    <div class="form-group-sm">
        {!! Form::label('receivedatelabel', '申请日期:', ['class' => 'control-label']) !!}
        {!! Form::date('applydatestart', null, ['class' => 'form-control']) !!}
        {!! Form::label('applydatelabelto', '-', ['class' => 'control-label']) !!}
        {!! Form::date('applydateend', null, ['class' => 'form-control']) !!}
        {!! Form::submit('查找', ['class' => 'btn btn-default btn-sm']) !!}
    </div>
    {!! Form::close() !!}
</div>

<table id="userDataTable" class="table table-striped table-hover table-condensed">
    <thead>
    <tr>
        <th>订单名称</th>
        <th>订单金额</th>

        <th>区间收款</th>
        <th>收款日期</th>
        <th>奖金系数</th>
        <th>应发奖金</th>
        {{--
        <th>合同金额</th>

        <th>申请人</th>
        <th>审批状态</th>
        <th>付款状态</th>
        @if (Agent::isDesktop())
        <th style="width: 150px">操作</th>
        @endif
        --}}
    </tr>
    </thead>

    <tbody>
    @foreach($items as $item)
    <tr>
        <td>
            {{ $item->sohead->projectjc }}
        </td>
        <td>
            {{ number_format($item->sohead->amount, 4)  }}
        </td>
        <td>
            <?php $amountperiod = $item->amount; ?>
            <?php $totalaamountperiod += $amountperiod; ?>
            {{ number_format($amountperiod, 4) }}
        </td>
        <td>
            {{ substr($item->date, 0, 10) }}
        </td>
        <td>
            {{ $item->sohead->getBonusfactorByPolicy() * 100.0 . '%' }}
        </td>
        <td>
            {{--{{ dd(array_first($item->sohead->getAmountpertenthousandBySohead())) }}--}}
            <?php
            $bonus = $item->amount * $item->sohead->getBonusfactorByPolicy() * array_first($item->sohead->getAmountpertenthousandBySohead())->amountpertenthousandbysohead;
            $totalbonus += $bonus;
            ?>
            {{ $bonus }}
        </td>
        {{--
        <td>
            {{ $item->sohead->receiptpayments->sum('amount') / $item->sohead->amount }}
        </td>
        --}}
        {{--
        <td>
            @if (isset($paymentrequest->purchaseorder_hxold->amount)) {{ $paymentrequest->purchaseorder_hxold->amount }} @else @endif
        </td>
        <td>
            {{ $paymentrequest->applicant->name }}
        </td>
        <td>
            @if ($paymentrequest->approversetting_id > 0)
            <div class="text-primary">审批中</div>
            @elseif ($paymentrequest->approversetting_id == 0)
            <div class="text-success">已通过</div>
            @elseif ($paymentrequest->approversetting_id == -3)
            <div class="text-warning">撤回中</div>
            @elseif ($paymentrequest->approversetting_id == -4)
            <div class="text-danger">已撤回</div>
            @else
            <div class="text-danger">未通过</div>
            @endif
        </td>
        <td>
            @if ($paymentrequest->approversetting_id === 0)

            @if (isset($paymentrequest->purchaseorder_hxold->payments))
            @if ($paymentrequest->paymentrequestapprovals->max('created_at') < $paymentrequest->purchaseorder_hxold->payments->max('create_date'))
            <div class="text-success">已付款</div>
            @endif
            @endif
            @endif
        </td>
        @if (Agent::isDesktop())
        <td>
            @can('approval_paymentrequest_payment_create')
            <a href="{{ url('/approval/paymentrequests/' . $paymentrequest->id . '/pay') }}" target="_blank" class="btn btn-success btn-sm pull-left
                        @if ($paymentrequest->approversetting_id === 0)
                            @if (isset($paymentrequest->purchaseorder_hxold->payments))
                                @if ($paymentrequest->paymentrequestapprovals->max('created_at') > $paymentrequest->purchaseorder_hxold->payments->max('create_date'))
                                    abled
                                @else
                                    disabled
                                @endif
                            @else
                                disabled
                            @endif
                        @else
                            disabled
                        @endif
                        ">付款</a>
            @endcan

            @can('approval_paymentrequest_delete')
            {!! Form::open(array('route' => array('approval.paymentrequests.destroy', $paymentrequest->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录?");')) !!}
            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
            {!! Form::close() !!}
            @endcan

        </td>
        @endif
        --}}
    </tr>
    @endforeach

    <tr class="info">
        <td>合计</td>
        <td></td>
        <td>{{ $totalaamountperiod }}</td>
        <td></td>
        <td></td>
        <td>
            {{--{{ number_format($items->sum('bonus'), 2) }}--}}
            {{ $totalbonus }}
        </td>
        {{--
        <td>
            @if (Auth::user()->email == "admin@admin.com")
            {{ $purchaseorders->sum('amount') }}
            @endif
        </td>
        <td></td>
        <td></td>
        <td></td>
        @if (Agent::isDesktop())
        <td></td>
        @endif
        --}}
    </tr>

    <tr class="success">
        <td colspan="6">注：此数据为参考数据，最后奖金以实发为准。</td>
        {{--
        <td></td>
        <td>
            @if (isset($totalamount))
            {{ $totalamount }}
            @endif
        </td>
        <td></td>
        <td></td>
        <td>

        </td>
        <td>

        </td>
        <td></td>
        <td></td>
        <td></td>
        @if (Agent::isDesktop())
        <td></td>
        @endif
        --}}
    </tr>
    </tbody>

</table>

@else
<div class="alert alert-warning alert-block">
    <i class="fa fa-warning"></i>
    {{'无记录', [], 'layouts'}}
</div>
@endif

@endsection

@section('script')
<script type="text/javascript" src="/DataTables/datatables.js"></script>
{{--<script type="text/javascript" src="/DataTables/DataTables-1.10.16/js/jquery.dataTables.js"></script>--}}
<script type="text/javascript">
    jQuery(document).ready(function(e) {
        $("#btnExport").click(function() {
            $.ajax({
                type: "POST",
                url: "{{ url('approval/paymentrequests/export') }}",
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