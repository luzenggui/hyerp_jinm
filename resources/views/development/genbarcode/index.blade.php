@extends('navbarerp')
@section('title', 'UPC条码生成')
@section('main')

    {!! Form::open(['url' => '/development/genbarcode/changebarcode', 'class' => 'form-horizontal', 'files' => true]) !!}

    {{--<div class="form-group">--}}
    {{--{!! Form::label('salary_date', '工资日期:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}--}}
    {{--<div class='col-xs-8 col-sm-10'>--}}
    {{--{!! Form::date('salary_date', date('Y-m-d'), ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="panel-heading">

    </div>

    <div class="panel-body">

        <div class="form-body">
            <div class="row">
                {!! Form::label('startcell', '开始行', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
                <div class='col-xs-4 col-sm-4'>
                    {!! Form::text('startcell', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                {!! Form::label('endcell', '结束结束', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
                <div class='col-xs-4 col-sm-4'>
                    {!! Form::text('endcell', null, ['class' => 'form-control']) !!}
                </div>
            </div>


            <div class="row">
                {!! Form::label('file', '选择Excel文件:', ['class' => 'col-xs-4 col-sm-2 control-label']) !!}
                <div class='col-xs-4 col-sm-4'>
                    {!! Form::file('file', []) !!}
                </div>
            </div>


        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('导入', ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection