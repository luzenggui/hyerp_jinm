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

            {!! Form::submit('查找(Search)', ['class' => 'btn btn-default btn-sm']) !!}
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
