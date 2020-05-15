@extends('navbarerp')

@section('title', '加工信息')

@section('main')
    <div class="panel-heading">
        <a href="process/create" class="btn btn-sm btn-success">新建</a>
        {{--<a href="shipments/import" class="btn btn-sm btn-success">导入(Import)</a>--}}
    </div>

    <div class="panel-body">


        @if ($processes->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Name</th>
                    {{--<th>Detail</th>--}}
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($processes as $process)
                    <tr>
                        <td>
                            {{ $process->name }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/department6/process/'.$process->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {!! Form::open(array('route' => array('process.destroy', $process->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {!! $processes->setPath('/department6/process')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection

