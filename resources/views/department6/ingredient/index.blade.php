@extends('navbarerp')

@section('title', '辅料信息')

@section('main')
    <div class="panel-heading">
        <a href="ingredient/create" class="btn btn-sm btn-success">新建</a>
        {{--<a href="shipments/import" class="btn btn-sm btn-success">导入(Import)</a>--}}
    </div>

    <div class="panel-body">


        @if ($ingredients->count())
            <table class="table table-striped table-hover table-condensed">
                <thead>
                <tr>
                    <th>Name</th>
                    {{--<th>Detail</th>--}}
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ingredients as $ingredient)
                    <tr>
                        <td>
                            {{ $ingredient->name }}
                        </td>
                        <td>
                            <a href="{{ URL::to('/department6/ingredient/'.$ingredient->id.'/edit') }}" class="btn btn-success btn-sm pull-left">编辑</a>
                            {!! Form::open(array('route' => array('ingredient.destroy', $ingredient->id), 'method' => 'delete', 'onsubmit' => 'return confirm("确定删除此记录(Delete this record)?");')) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {!! $ingredients->setPath('/department6/ingredient')->appends($inputs)->links() !!}
        @else
            <div class="alert alert-warning alert-block">
                <i class="fa fa-warning"></i>
                {{'无记录(No Record)', [], 'layouts'}}
            </div>
        @endif
    </div>

@endsection

