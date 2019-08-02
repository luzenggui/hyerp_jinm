<div class="modal fade" id="selectVendorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">选择供应商</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '供应商名称', 'id' => 'keyVendor']) !!}
                    <span class="input-group-btn">
                   		{!! Form::button('查找', ['class' => 'btn btn-default btn-sm', 'id' => 'btnSearchVendor']) !!}
                   	</span>
                </div>
                {!! Form::hidden('name', null, ['id' => 'name']) !!}
                {!! Form::hidden('id', null, ['id' => 'id']) !!}
                <p>
                <div class="list-group" id="listvendors">

                </div>
                </p>
            </div>
        </div>
    </div>
</div>
