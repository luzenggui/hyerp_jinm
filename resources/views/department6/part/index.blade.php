@extends('navbarerp')

@section('title', '部位信息')

@section('main')
    <div class="panel-heading">
        <a href="part/create" class="btn btn-sm btn-success">新建</a>
        {{--<a href="shipments/import" class="btn btn-sm btn-success">导入(Import)</a>--}}
    </div>

    <div class="panel-body">


        @if ($parts->count())
            <table class="table table-striped table-hover table-condensed table-sm">
                <thead>
                <tr>
                    <th>Name</th>
                    {{--<th>Detail</th>--}}
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($parts as $part)
                    <tr>
                        <td>
                            {{ $part->name }}
                        </td>
                        <td>
                            {!! Form::open(array('url' => url('/department6/part/copypart/'. $part->id), 'onsubmit' => 'return confirm("确定复制此部位？");')) !!}
                            {!! Form::submit('复制', ['class' => 'btn btn-success btn-sm pull-left']) !!}
                            {!! Form::close() !!}
                            <a href="{{ URL::to('/department6/part/'.$part->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {!! Form::open(array('route' => array('part.destroy', $part->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {!! $parts->setPath('/department6/part')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection

