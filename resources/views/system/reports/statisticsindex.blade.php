@extends('navbarerp')

@section('main')
    <div class="panel-heading">
        {{--
        <div class="pull-right" style="padding-top: 4px;">
            <a href="{{ URL::to('system/depts') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{'部门管理', [], 'layouts'}}</a>
        </div>
        --}}

    </div>

    <div class="panel-body">
        {!! Form::open(['url' => '/system/reports/' . $report->id . '/export', 'class' => 'pull-right form-inline']) !!}
        <div class="form-group-sm">
            @foreach($input as $key=>$value)
                {!! Form::hidden($key, $value) !!}
            @endforeach
            {!! Form::submit('导出到Excel(Export)', ['class' => 'btn btn-default btn-sm']) !!}
        </div>
        {!! Form::close() !!}

        {!! Form::open(['url' => '/system/reports/' . $report->id . '/statistics', 'class' => 'pull-right form-inline']) !!}
        <div class="form-group-sm">
            {{-- 根据不同报表设置不同搜索条件 --}}
            @if ($report->name == "p_frabicdata")
                {!! Form::label('applydatelabel', '申请日期:', ['class' => 'control-label']) !!}
                {!! Form::date('bdate', null, ['class' => 'form-control']) !!}
                {!! Form::label('applydatelabelto', '-', ['class' => 'control-label']) !!}
                {!! Form::date('edate', null, ['class' => 'form-control']) !!}
            @endif
            @if ($report->name == "pgenkqrport")
                {!! Form::label('applydatelabel', '年份', ['class' => 'control-label']) !!}
                {!! Form::text('yr', date('Y',time()), ['class' => 'form-control','id'=>'txtYr']) !!}
                {!! Form::label('applydatelabel', '月份', ['class' => 'control-label']) !!}
                {!! Form::text('mon', date('m',time()), ['class' => 'form-control','id'=>'txtMon']) !!}
                {!! Form::label('applylabel_depart', '部门', ['class' => 'control-label']) !!}
                {!! Form::select('depart', $oadepartmentList, null,['class' => 'form-control','placeholder' => '--请选择--']) !!}
            @endif
            @if ($report->name == "pgetbudgetdata")
                {!! Form::text('contractno', null, ['class' => 'form-control','placeholder'=>'合同号']) !!}
                {!! Form::text('shipno', null, ['class' => 'form-control','placeholder'=>'运编号']) !!}
            @endif
            @if ($report->name == "pgetfinancedata")
                {!! Form::label('etdstartlabel', 'ETD:', ['class' => 'control-label']) !!}
                {!! Form::date('etdstart', null, ['class' => 'form-control']) !!}
                {!! Form::label('etdlabelto', '-', ['class' => 'control-label']) !!}
                {!! Form::date('etdend', null, ['class' => 'form-control']) !!}
                {!! Form::select('finishedfinance', ['-1' => '未完成', '1' => '完成'], null, ['class' => 'form-control', 'placeholder' => '--收汇完成--']) !!}
             @endif
            @if ($report->name == "pgenleavedata")
                {!! Form::label('applydatelabel', '缺勤日期:', ['class' => 'control-label']) !!}
                {!! Form::date('missday', date('Y-m-d',time()), ['class' => 'form-control']) !!}
            @endif
            @if ($report->name == "pgetinvoicedata")
                {!! Form::label('startlabel', '日期:', ['class' => 'control-label']) !!}
                {!! Form::date('invdatestart', null, ['class' => 'form-control']) !!}
                {!! Form::label('labelto', '-', ['class' => 'control-label']) !!}
                {!! Form::date('invdateend', null, ['class' => 'form-control']) !!}
                {!! Form::text('departno', null, ['class' => 'form-control','placeholder'=>'部门']) !!}
                {!! Form::text('customer', null, ['class' => 'form-control','placeholder'=>'客户']) !!}
            @endif
            @if ($report->name == "pgetinventory")
                {!! Form::text('mtcode', null, ['class' => 'form-control','placeholder'=>'物料编码']) !!}
            @endif
            @if ($report->name == "pgetinventoryacc")

                {!! Form::text('mtcode', null, ['class' => 'form-control','placeholder'=>'物料编码']) !!}
                {!! Form::text('sheetno', null, ['class' => 'form-control','placeholder'=>'合同号']) !!}
            @endif
            @if ($report->name == "pgencydata")
                {!! Form::label('date_vanning', '装箱日期:', ['class' => 'control-label']) !!}
                {!! Form::date('startdate_vanning', null, ['class' => 'form-control']) !!}
                {!! Form::label('labelto', '-', ['class' => 'control-label']) !!}
                {!! Form::date('enddate_vanning', null, ['class' => 'form-control']) !!}

                {!! Form::text('factoryname', null, ['class' => 'form-control','placeholder'=>'工厂名']) !!}
            @endif
            @if ($report->name == "pgetjxdata_qzpy")
                {!! Form::label('applydatelabel', '年份', ['class' => 'control-label']) !!}
                {!! Form::text('year', date('Y',time()), ['class' => 'form-control','id'=>'txtYr']) !!}
                {!! Form::label('applydatelabel', '月份', ['class' => 'control-label']) !!}
                {!! Form::text('mon', date('m',time()), ['class' => 'form-control','id'=>'txtMon']) !!}
                {!! Form::text('depart',  null,['class' => 'form-control','placeholder' => '部门']) !!}
            @endif
            {!! Form::submit('查找(Search)', ['class' => 'btn btn-default btn-sm','id'=>'btnSearch']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <?php $hasright = false; ?>
    @if ($report->name == "so_projectengineeringlist_statistics")
        @can('system_report_so_projectengineeringlist_statistics')
            <?php $hasright = true; ?>
        @endcan
    @elseif ($report->name == "so_amountstatistics_forfinancedept")
        @can('system_report_so_amountstatistics_forfinancedept')
            <?php $hasright = true; ?>
        @endcan
    @elseif ($report->name == "shipment_pvh")
        @can('system_report_sh_shipment_pvh')
            <?php $hasright = true; ?>
        @endcan
    @elseif ($report->name == "p_frabicdata")
        @can('fabricdischarge_finish')
            <?php $hasright = true; ?>
        @endcan
    @elseif ($report->name == "pgenkqrport" or $report->name =="pgenleavedata" or $report->name =="pgetjxdata_qzpy")
        @can('module_personal')
            <?php $hasright = true; ?>
        @endcan
    @elseif ($report->name == "pgetbudgetdata" or $report->name == "pgetfinancedata" or $report->name == "pgetinvoicedata"  )
        @can('module_finance')
            <?php $hasright = true; ?>
        @endcan
    @elseif ($report->name == "pgetinventory" or $report->name == "pgetinventoryacc"  or $report->name == "pgencydata")
        @can('module_vouch')
            <?php $hasright = true; ?>
        @endcan
    @else
        @if (Auth::user()->isSuperAdmin())
            <?php $hasright = true; ?>
        @endif
    @endif

    @if ($hasright)
        @if ($items->count())
        <table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    @if (count($titleshows) > 1)
                        @foreach($titleshows as $titleshow)
                            <th>{{ $titleshow }}</th>
                        @endforeach
                    @else
                        @foreach(array_first($items->items()) as $key=>$value)
                            <th>{{$key}}</th>
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    @foreach($item as $value)
                    <td>
                        {{ $value }}
                    </td>
                    @endforeach
                </tr>
            @endforeach

            @if (count($sumcols) > 0 && strlen($sumcols[0]) > 0)
                <?php $sumvalues = []; ?>

                @foreach($items as $item)
                    <?php $colnum = 1; ?>
                    @foreach($item as  $value)
                        @foreach ($sumcols as $key => $sumcol)
                            @if ($colnum == $sumcol)
                                <?php $sumvalues[$key] = array_key_exists($key, $sumvalues) ? $sumvalues[$key] + $value : $value; ?>
                            @endif
                        @endforeach

                        <?php $colnum++; ?>
                    @endforeach
                @endforeach

                <tr class="info">
                    @foreach($items as $item)
                        <?php $colnum = 1; ?>
                        @foreach($item as  $value)
                            <td>
                                @foreach ($sumcols as $key => $sumcol)
                                    @if ($colnum == $sumcol)
                                        {{ $sumvalues[$key] }}
                                    @endif
                                @endforeach
                            <?php $colnum++; ?>
                            </td>
                        @endforeach
                        @break
                    @endforeach

                </tr>

                <tr class="success">
                    @foreach($items as $item)
                        <?php $colnum = 1; ?>
                        <?php $totalindex = 0; ?>
                        @foreach($item as  $value)
                            <td>
                                @foreach ($sumcols as $key => $sumcol)
                                    @if ($colnum == $sumcol)
                                        @if (count($sumvalues_total) > $key)
                                            {{ $sumvalues_total[$sumcol] }}
                                        @endif
                                    @endif
                                @endforeach
                                <?php $colnum++; ?>
                            </td>
                        @endforeach
                        @break
                    @endforeach
                </tr>
            @endif
            </tbody>

        </table>
        {!! $items->setPath('/system/reports/' . $report->id . '/statistics')->appends($input)->links() !!}
        @else
        <div class="alert alert-warning alert-block">
            <i class="fa fa-warning"></i>
            {{'无记录', [], 'layouts'}}
        </div>
        @endif
    @else
        无权限。
    @endif
@stop

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("#btnSearch").click(function() {
                if($("#txtYr").val() == "" || $("#txtMon").val() == "") {
                    alert('年份、月份都不能为空');
                    return false;
                }
                });
        });
    </script>
@endsection
