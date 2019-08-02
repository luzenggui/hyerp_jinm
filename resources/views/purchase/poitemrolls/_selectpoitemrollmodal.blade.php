<div class="modal fade" id="selectPoitemrollModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">选择卷</h4>
            </div>
            <div class="modal-body">
                {{--<div class="input-group">--}}
                    {{--{!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '', 'id' => 'keyDrawingchecker']) !!}--}}
                    {{--<span class="input-group-btn">--}}
                   		{{--{!! Form::button('查找', ['class' => 'btn btn-default btn-sm', 'id' => 'btnSearchDrawingchecker']) !!}--}}
                   	{{--</span>--}}
                {{--</div>--}}
                {!! Form::hidden('id', null, ['id' => 'id']) !!}
                {!! Form::hidden('num', null, ['id' => 'num']) !!}
                <p>
                <div class="list-group" id="listpoitemrolls">

                </div>
                <div class="checkbox" id="checkall"></div>
                </p>
                <form id="formAccept">
                    {{--{!! csrf_field() !!}--}}

                </form>
            </div>
            <div class="modal-footer">
                {!! Form::button('取消', ['class' => 'btn btn-sm', 'data-dismiss' => 'modal']) !!}
                {!! Form::button('确定', ['class' => 'btn btn-sm btn-primary', 'id' => 'btnok_selectpoitemrolls']) !!}
            </div>
        </div>
    </div>
</div>