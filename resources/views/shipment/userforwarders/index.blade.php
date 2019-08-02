@extends('navbarerp')

@section('title', 'User Forwarder')

@section('main')
    <div class="panel-heading">
        <a href="userforwarders/create" class="btn btn-sm btn-success">新建</a>
        {{--<a href="shipments/import" class="btn btn-sm btn-success">导入(Import)</a>--}}
    </div>

    <div class="panel-body">
        {{--{!! Form::open(['url' => '/shipment/shipments/search', 'class' => 'pull-right form-inline', 'id' => 'frmSearch']) !!}--}}
        {{--<div class="form-group-sm">--}}
            {{--{!! Form::label('createdatestartlabel', 'Create Date:', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('createdatestart', null, ['class' => 'form-control']) !!}--}}
            {{--{!! Form::label('createdatelabelto', '-', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('createdateend', null, ['class' => 'form-control']) !!}--}}

            {{--{!! Form::label('etdstartlabel', 'ETD:', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('etdstart', null, ['class' => 'form-control']) !!}--}}
            {{--{!! Form::label('etdlabelto', '-', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::date('etdend', null, ['class' => 'form-control']) !!}--}}

            {{--{!! Form::label('amount_for_customer', 'Amount for Customer:', ['class' => 'control-label']) !!}--}}
            {{--{!! Form::select('amount_for_customer_opt', ['>=' => '>=', '<=' => '<=', '=' => '='], null, ['class' => 'form-control']) !!}--}}
            {{--{!! Form::text('amount_for_customer', null, ['class' => 'form-control', 'placeholder' => 'Amount for Customer']) !!}--}}


            {{--{!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => 'Invoice No.,Contact No.,Customer']) !!}--}}
            {{--{!! Form::submit('Search', ['class' => 'btn btn-default btn-sm']) !!}--}}
            {{--{!! Form::button('Export', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExport']) !!}--}}
            {{--{!! Form::button('Export PVH', ['class' => 'btn btn-default btn-sm', 'id' => 'btnExportPVH']) !!}--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}

        @if ($userforwarders->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Forwarder</th>
                    {{--<th>Detail</th>--}}
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($userforwarders as $userforwarder)
                    <tr>
                        <td>
                            {{ $userforwarder->user->name }}
                        </td>
                        <td>
                            {{ $userforwarder->forwarder }}
                        </td>
                        {{--<td>--}}
                            {{--<a href="{{ URL::to('/shipment/userforwarders/' . $userforwarder->id . '/forwarders') }}" target="_blank">Forwarders</a>--}}
                        {{--</td>--}}
                        <td>
                            <a href="{{ URL::to('/shipment/userforwarders/'.$userforwarder->id.'/edit') }}" class="btn btn-success btn-sm pull-left">Edit</a>
                            {!! Form::open(array('route' => array('userforwarders.destroy', $userforwarder->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {!! $userforwarders->setPath('/shipment/shipments')->appends([
                'createdatestart' => isset($inputs['createdatestart']) ? $inputs['createdatestart'] : null,
                'createdateend' => isset($inputs['createdateend']) ? $inputs['createdateend'] : null,
                'etdstart' => isset($inputs['etdstart']) ? $inputs['etdstart'] : null,
                'etdend' => isset($inputs['etdend']) ? $inputs['etdend'] : null,
                'amount_for_customer_opt' => isset($inputs['amount_for_customer_opt']) ? $inputs['amount_for_customer_opt'] : null,
                'amount_for_customer' => isset($inputs['amount_for_customer']) ? $inputs['amount_for_customer'] : null,
                'key' => isset($inputs['key']) ? $inputs['key'] : null,
            ])->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(e) {
            $("#btnExport").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/export') }}",
                    data: $("form#frmSearch").serialize(),
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
                        location.href = result;
//                        alert("导出成功.");
                    },
                });
            });

            $("#btnExportPVH").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('shipment/shipments/exportpvh') }}",
                    data: $("form#frmSearch").serialize(),
//                    dataType: "json",
                    error:function(xhr, ajaxOptions, thrownError){
                        alert('error');
                    },
                    success:function(result){
//                        alert(result);
                        location.href = result;
//                        alert("导出成功.");
                    },
                });
            });
        });
    </script>
@endsection
