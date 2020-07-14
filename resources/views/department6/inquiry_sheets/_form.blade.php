<div class="form-body">
    <div class="row" >
        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('customername', '客户', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('customername',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('prod_description', '产品描述', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('prod_description',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3 '>
            <div class="form-group">
                {!! Form::label('prod_size', '产品尺寸', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('prod_size',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3 '>
            <div class="form-group">
                {!! Form::label('customer_item_name', '客人款号&产品名称', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('customer_item_name',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('supplier_stock_number', '供应商编号', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('supplier_stock_number',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('UPC', '条形码号', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('UPC',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>

            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('FOB_SH_price', '大价格', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('FOB_SH_price',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>

            </div>
        </div>

        <div class='col-xs-3 '>
            <div class="form-group">
                {!! Form::label('prod_qty', '产品数量', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('prod_qty', isset($inquiry_sheet->prod_qty) ? $inquiry_sheet->prod_qty : 1, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class='col-xs-3 '>
            <div class="form-group">
                {!! Form::label('ingredients_note', '辅料', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('ingredients_note',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>

            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('packing_note', '包装', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('packing_note',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('remark_factory', '工厂提供', ['class' => 'control-label' ]) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('remark_factory', null, ['class' => 'form-control', $attr]) !!}
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class='col-xs-6'>
            <div class="form-group">
                {!! Form::label('prod_photo', '产品照片', ['class' => 'control-label']) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {!! Form::textarea('prod_photo', null, ['class' => 'form-control',  $attr,'id'=>'prod_photo','rows' => 3]) !!}
                        </div>
                    </div>
            </div>
        </div>

        <div class='col-xs-3'>
            <a href="#" class="thumbnail">
                <img  alt="产品缩略图" style="width:200px; height:100px" id="showImg" />
            </a>
        </div>
    </div>

    <h3><strong>部位面料:</strong></h3>
    <hr />
    <div id="sortable1">
     @if(isset($inquiry_sheet->purchasedetail))
         @foreach($inquiry_sheet->purchasedetail as $purchasedetail)

                <div class="item-row margin-top-5 " >
                    <div name="container_item_purchasedetail" >
                        <div class="row" >
                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('partid', '部位', ['class' => ' control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                                <select class="form-control" name="partid" id="selectPartid" >
                                                    @foreach($parts as $part)
                                                        @if($part->id==$purchasedetail->partid)
                                                        <option  value="{{ $part->id }} " selected >{{ $part->name }}</option>
                                                        @else
                                                            <option  value="{{ $part->id }} ">{{ $part->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            {!! Form::hidden('purchasedetailid', $purchasedetail->id ) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('fabric_desc', '面料', ['class' => ' control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('fabric_desc', $purchasedetail->fabric_desc, ['class' => 'form-control',  $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('composition', '成分', ['class' => 'control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('composition', $purchasedetail->composition, ['class' => 'form-control', $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('valid_width', '有效门幅', ['class' => 'control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-10">
                                            {!! Form::text('valid_width', $purchasedetail->valid_width, ['class' => 'form-control', $attr]) !!}
                                        </div>

                                        <div class="col-xs-1 text-right ">
                                            <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('edge_to_edge_width', '边到边门幅', ['class' => 'control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('edge_to_edge_width', $purchasedetail->edge_to_edge_width, ['class' => 'form-control', $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('qty', '用料', ['class' => 'control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('qty', $purchasedetail->qty, ['class' => 'form-control qty', $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('price', '面料单价', ['class' => 'control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('price', $purchasedetail->price, ['class' => 'form-control price', $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('outprice', '报出单价', ['class' => 'control-label']) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('outprice', $purchasedetail->outprice, ['class' => 'form-control outprice', $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('total_price', '工厂费用合计', ['class' => 'control-label' ]) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('total_price', $purchasedetail->total_price, ['class' => 'form-control total_price', $attr,$attrdisable]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('total_outprice', '报出费用合计', ['class' => 'control-label' ]) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('total_outprice', $purchasedetail->total_outprice, ['class' => 'form-control total_outprice', $attr,$attrdisable]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('total_qty', '用料合计', ['class' => 'control-label' ]) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('total_qty', $purchasedetail->total_qty, ['class' => 'form-control total_qty', $attr,$attrdisable]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-3'>
                                <div class="form-group">
                                    {!! Form::label('factoryname', '工厂', ['class' => 'control-label' ]) !!}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {!! Form::text('factoryname', $purchasedetail->factoryname, ['class' => 'form-control', $attr]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        @endforeach

    @else
            <div class="item-row margin-top-5" style="background-color:#C0C0C0;">
                <div name="container_item_purchasedetail" >
                    <div class="row">
                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('partid', '部位', ['class' => ' control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                            {!! Form::select('partid', $partList,null, ['class' => 'form-control', 'placeholder' => '--请选择--', 'id'=>'selectPartid' ]) !!}
{{--                                            {!! Form::hidden('part_id', null, ['id' => 'part_id']) !!}--}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('fabric_desc', '面料', ['class' => ' control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                            {!! Form::text('fabric_desc', null, ['class' => 'form-control',  $attr, ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('composition', '成分', ['class' => 'control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('composition', null, ['class' => 'form-control', $attr,  ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('valid_width', '有效门幅', ['class' => 'control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-10">
                                        {!! Form::text('valid_width', null, ['class' => 'form-control', $attr, ]) !!}
                                    </div>

                                    <div class="col-xs-1 text-right ">
                                        <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('edge_to_edge_width', '边到边门幅', ['class' => 'control-label ']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('edge_to_edge_width', null, ['class' => 'form-control', $attr,  ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('qty', '用料', ['class' => 'control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('qty', null, ['class' => 'form-control qty', $attr]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('price', '面料单价', ['class' => 'control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('price', null, ['class' => 'form-control price', $attr]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('outprice', '报出单价', ['class' => 'control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('outprice', null, ['class' => 'form-control outprice', $attr]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('total_price', '工厂费用合计', ['class' => 'control-label' ]) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('total_price', null, ['class' => 'form-control total_price', $attr,$attrdisable]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('total_outprice', '报出费用合计', ['class' => 'control-label' ]) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('total_outprice', null, ['class' => 'form-control total_outprice', $attr,$attrdisable]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('total_qty', '用料合计', ['class' => 'control-label' ]) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('total_qty', null, ['class' => 'form-control total_qty', $attr,$attrdisable]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('factoryname', '工厂', ['class' => 'control-label' ]) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::text('factoryname', null, ['class' => 'form-control', $attr]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif
    </div>
            {{--{!! Form::button('+增加明细', ['class' => 'btn btn-sm', 'id' => 'btnAddTravel']) !!}--}}
            <a href="javascript:void(0);" class="bannerTitle addMore" id="btnAddPurchasedetialItem">+增加明细</a>

    <h3><strong>辅料:</strong></h3>
    <hr />

    <div id="sortable2">
    @if(isset($inquiry_sheet->ingredientdetail))
        @foreach($inquiry_sheet->ingredientdetail as $ingredientdetail)
          <div class="item-row margin-top-5" >
            <div name="container_item_ingredientdetail" >
                <div class="row">
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('ingredientid', '辅料', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                        <select class="form-control" name="ingredientid" >
                                            @foreach($ingredients as $ingredient)
                                                @if($ingredient->id==$ingredientdetail->ingredientid)
                                                    <option  value="{{ $ingredient->id }}"  selected >{{ $ingredient->name }}</option>
                                                @else
                                                    <option  value="{{ $ingredient->id }} ">{{ $ingredient->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    {!! Form::hidden('ingredientdetailid', $ingredientdetail->id ) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('qty', '用料', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('qty', $ingredientdetail->qty, ['class' => 'form-control qty', $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('price', '工厂单价', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('price', $ingredientdetail->price, ['class' => 'form-control price', $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('outprice', '报出单价', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-10">
                                    {!! Form::text('outprice', $ingredientdetail->outprice, ['class' => 'form-control outprice', $attr]) !!}
                                </div>

                                <div class="col-xs-1 text-right ">
                                    <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_price', '工厂费用合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_price', $ingredientdetail->total_price, ['class' => 'form-control total_price', $attr,$attrdisable]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_outprice', '报出费用合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_outprice', $ingredientdetail->total_outprice, ['class' => 'form-control total_outprice', $attr,$attrdisable]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_qty', '用料合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_qty', $ingredientdetail->total_qty, ['class' => 'form-control total_qty', $attr,$attrdisable]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('remark_factory', '工厂提供', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('remark_factory',  $ingredientdetail->remark_factory, ['class' => 'form-control',  $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('ingredient_desc', '辅料说明', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('ingredient_desc',  $ingredientdetail->ingredient_desc, ['class' => 'form-control',  $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
    @endforeach

    @else
            <div class="item-row margin-top-5" style="background-color:#C0C0C0;">
                <div name="container_item_ingredientdetail" >
                    <div class="row">
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('ingredientid', '辅料', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                        {!! Form::select('ingredientid', $ingredientList,null, ['class' => 'form-control', 'placeholder' => '--请选择--', $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('qty', '用料', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('qty', null, ['class' => 'form-control qty', $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('price', '工厂单价', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('price', null, ['class' => 'form-control price', $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('outprice', '报出单价', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-10">
                                    {!! Form::text('outprice', null, ['class' => 'form-control outprice', $attr]) !!}
                                </div>
                                <div class="col-xs-1 text-right ">
                                    <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_price', '工厂费用合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_price', null, ['class' => 'form-control total_price', $attr,$attrdisable]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_outprice', '报出费用合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_outprice', null, ['class' => 'form-control total_outprice', $attr,$attrdisable]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_qty', '用料合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_qty', null, ['class' => 'form-control total_qty', $attr,$attrdisable]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('remark_factory', '工厂提供', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('remark_factory',  null, ['class' => 'form-control',  $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('ingredient_desc', '辅料说明', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('ingredient_desc',  null, ['class' => 'form-control',  $attr]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
    {{--{!! Form::button('+增加明细', ['class' => 'btn btn-sm', 'id' => 'btnAddTravel']) !!}--}}
                    <a href="javascript:void(0);" class="bannerTitle addMore" id="btnAddIngedientdetailItem">+增加明细</a>



    <h3><strong>加工明细:</strong></h3>
    <hr />
    <div id="sortable3">
     @if(isset($inquiry_sheet->processdetail))

    @foreach($inquiry_sheet->processdetail as $processdetail)
                <div class="item-row margin-top-5" >
                      <div name="container_item_processdetail">
                          <div class="row">
                              <div class='col-xs-3'>
                                  <div class="form-group">
                                      {!! Form::label('processid', '加工费', ['class' => 'control-label']) !!}
                                      <div class="row">
                                          <div class="col-xs-12">
                                                  <select class="form-control" name="processid" >
                                                      @foreach($processes as $process)
                                                          @if($process->id==$processdetail->processid)
                                                              <option  value="{{ $process->id }} " selected>{{ $process->name }}</option>
                                                          @else
                                                              <option  value="{{ $process->id }} ">{{ $process->name }}</option>
                                                          @endif
                                                      @endforeach
                                                  </select>
                                              {!! Form::hidden('processdetailid', $processdetail->id ) !!}
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class='col-xs-3'>
                                  <div class="form-group">
                                      {!! Form::label('price', '工厂费用', ['class' => 'control-label' ]) !!}
                                      <div class="row">
                                          <div class="col-xs-12">
                                              {!! Form::text('price', $processdetail->price, ['class' => 'form-control price', $attr]) !!}
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class='col-xs-3'>
                                  <div class="form-group">
                                      {!! Form::label('outprice', '报出费用', ['class' => 'control-label' ]) !!}
                                      <div class="row">
                                          <div class="col-xs-11">
                                              {!! Form::text('outprice', $processdetail->outprice, ['class' => 'form-control outprice', $attr]) !!}
                                          </div>
                                          <div class="col-xs-1 text-right ">
                                              <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                </div>
    @endforeach
    @else
        <div class="item-row margin-top-5" style="background-color:#C0C0C0;">
                <div name="container_item_processdetail">
                    <div class="row">
                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('processid', '加工费', ['class' => 'control-label']) !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                            {!! Form::select('processid', $processList,null, ['class' => 'form-control', 'placeholder' => '--请选择--', $attr]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-xs-3'>
                            <div class="form-group">
                                {!! Form::label('price', '工厂费用', ['class' => 'control-label' ]) !!}
                                <div class="row">
                                    <div class="col-xs-11">
                                        {!! Form::text('price', null, ['class' => 'form-control price', $attr]) !!}
                                    </div>
                                    <div class="col-xs-1 text-right ">
                                        <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    @endif
        </div>
            {{--{!! Form::button('+增加明细', ['class' => 'btn btn-sm', 'id' => 'btnAddTravel']) !!}--}}
                <a href="javascript:void(0);" class="bannerTitle addMore" id="btnAddProcessdetailItem">+增加明细</a>



    {!! Form::hidden('items_string1', null, ['id' => 'items_string1']) !!}
    {!! Form::hidden('items_string2', null, ['id' => 'items_string2']) !!}
    {!! Form::hidden('items_string3', null, ['id' => 'items_string3']) !!}

     <hr />
     <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('process_tax', '加工税', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('process_tax',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

         <div class='col-xs-3'>
             <div class="form-group">
                 {!! Form::label('process_costs', '工厂加工费合计', ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="col-xs-12">
                         {!! Form::text('process_costs',  null, ['class' => 'form-control',  $attr,$attrdisable,'id' =>'process_costs']) !!}
                     </div>
                 </div>
             </div>
         </div>

         <div class='col-xs-3'>
             <div class="form-group">
                 {!! Form::label('process_taxcosts', '工厂加工费(含税)合计', ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="col-xs-12">
                         {!! Form::text('process_taxcosts',  null, ['class' => 'form-control',  $attr,$attrdisable,'id' =>'process_taxcosts']) !!}
                     </div>
                 </div>
             </div>
         </div>

         <div class='col-xs-3'>
             <div class="form-group">
                 {!! Form::label('purchase_costs', '工厂采购费合计', ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="col-xs-12">
                         {!! Form::text('purchase_costs',  null, ['class' => 'form-control',  $attr,$attrdisable,'id' =>'purchase_costs']) !!}
                     </div>
                 </div>
             </div>
         </div>
     </div>

      <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('purchase_outcosts', '报出采购费合计', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('purchase_outcosts',  null, ['class' => 'form-control',  $attr,$attrdisable,'id' =>'purchase_outcosts']) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('remark', '备注', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('remark',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('length_carton', 'L', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('length_carton',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('width_carton', 'W', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('width_carton',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('high_carton', 'H', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('high_carton',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('qty_percarton', '每箱数量', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('qty_percarton',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('arlington_ocean_freight', '海运费$(Arlington，USA-FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('arlington_ocean_freight',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('atc_ocean_freight', '海运费$(ATC,USA-FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('atc_ocean_freight',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('risk_rate', '风险率(<1)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('risk_rate',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('fob_shanghai', 'FOB shanghai', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('fob_shanghai',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('import_rate', '进口税率', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('import_rate',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('arlington_ldp', 'LDP Arlington,USA(FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('arlington_ldp',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('atc_ldp', 'LDP ATC,CA,USA(FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('atc_ldp',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('total_costs', '工厂合计总价', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('total_costs',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('total_outcosts', '报出合计总价', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('total_outcosts',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('exchange_rate', '汇率', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('exchange_rate',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

      </div>
    <div class="row">
        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('vol_total', '总体积', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('vol_total',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('qty_container', '每个集装箱可装数量', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('qty_container',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class='col-xs-3'>
            <div class="form-group">
                {!! Form::label('inland_freight', '内陆运费$（40HQ）', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('inland_freight',  null, ['class' => 'form-control',  $attr,$attrdisable]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    {!! Form::submit($submitButtonText, ['class' => $btnclass, 'id' => 'btnSubmit']) !!}
    </div>
</div>




