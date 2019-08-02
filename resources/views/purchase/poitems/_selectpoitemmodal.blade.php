<div class="modal fade" id="selectPurchaseorderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">选择物料</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    {!! Form::text('key', null, ['class' => 'form-control', 'placeholder' => '采购订单编号', 'id' => 'keyOrder']) !!}
                    <span class="input-group-btn">
                   		{!! Form::button('查找', ['class' => 'btn btn-default btn-sm', 'id' => 'btnSearchOrder']) !!}
                   	</span>
                </div>
                {!! Form::hidden('name', null, ['id' => 'name']) !!}
                {!! Form::hidden('id', null, ['id' => 'id']) !!}
                {!! Form::hidden('supplierid', 0, ['id' => 'supplierid']) !!}
                {!! Form::hidden('poheadamount', 0, ['id' => 'poheadamount']) !!}
                <p>
                <div class="list-group" id="listsalesorders">

                </div>
                </p>

            </div>

        </div>
    </div>
</div>
