<div class="modal fade" id="inputNumModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">输入数量</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('class' => 'form-horizontal', 'id' => 'formMain')) }}
                {!! Form::text('num', null, ['class' => 'form-control', 'placeholder' => '数量', 'id' => 'keynum']) !!}
                {!! Form::hidden('type', null, ['id' => 'type']) !!}
                {!! Form::hidden('frabricid', null, ['id' => 'frabricid']) !!}
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                {!! Form::button('取消', ['class' => 'btn btn-sm', 'data-dismiss' => 'modal']) !!}
                {!! Form::button('确定', ['class' => 'btn btn-sm btn-primary', 'id' => 'btnok_inputnum']) !!}
            </div>
        </div>
    </div>
</div>