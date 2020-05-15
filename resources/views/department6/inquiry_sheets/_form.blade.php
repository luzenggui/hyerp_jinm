<div class="form-body">
    <div class="row">
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
                {!! Form::label('UPC#', '供应商编号', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::text('UPC#',  null, ['class' => 'form-control',  $attr]) !!}
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
                        {!! Form::text('prod_qty',  null, ['class' => 'form-control',  $attr]) !!}
                    </div>
                </div>

            </div>
        </div>

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
    </div>

    <div class="row">
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
    </div>

    <div class="row">
        <div class='col-xs-12'>
        <div class="form-group">
            {!! Form::label('prod_photo', '产品照片', ['class' => 'control-label']) !!}
                <div class="row">
                    <div class="col-xs-12">
                {!! Form::textarea('prod_photo', null, ['class' => 'form-control',  $attr,'id'=>'content','rows' => 3]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3><strong>部位面料:</strong></h3>
    <hr />

        @if(isset($inquiry_sheet->purchasedetail))
        @else
        <div id="sortable1">
            <div class="col-xs-12 item-row margin-top-5">
        <div name="container_item_purchasedetail">
            {{--<div class="row">--}}
                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('partid', '部位', ['class' => ' control-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::select('partid', $partList,null, ['class' => 'form-control', 'placeholder' => '--请选择--', $attr, 'id' => 'partid_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('fabric_desc', '面料', ['class' => ' control-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('fabric_desc', null, ['class' => 'form-control',  $attr, 'id' => 'fabric_desc_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('composition', '成分', ['class' => 'control-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('composition', null, ['class' => 'form-control', $attr,  'id' => 'composition_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('edge_to_edge_width', '有效门幅', ['class' => 'control-label']) !!}
                        <div class="row">
                            <div class="col-xs-10">
                                {!! Form::text('edge_to_edge_width', null, ['class' => 'form-control', $attr,  'id' => 'edge_to_edge_width_1']) !!}
                            </div>

                            <div class="col-xs-1 text-right ">
                                <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>

                        </div>
                    </div>
                </div>

            {{--</div>--}}

            {{--<div class="row">--}}
                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('edge_to_edge_width', '边到边门幅', ['class' => 'control-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('edge_to_edge_width', null, ['class' => 'form-control', $attr,  'id' => 'edge_to_edge_width_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('qty', '用料', ['class' => 'control-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('qty', null, ['class' => 'form-control', $attr,  'id' => 'qty_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('price', '面料单价', ['class' => 'control-label']) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('price', null, ['class' => 'form-control', $attr,  'id' => 'price_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('total_price', '费用合计', ['class' => 'control-label' ]) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('total_price', null, ['class' => 'form-control', $attr,  'id' => 'total_price_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>

            {{--</div>--}}

            {{--<div class="row">--}}
                <div class='col-xs-3'>
                    <div class="form-group">
                        {!! Form::label('factoryname', '工厂', ['class' => 'control-label' ]) !!}
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Form::text('factoryname', null, ['class' => 'form-control', $attr,  'id' => 'factoryname_1']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            {{--</div>--}}
        </div>
        </div>
        </div>

            {{--{!! Form::button('+增加明细', ['class' => 'btn btn-sm', 'id' => 'btnAddTravel']) !!}--}}
            <a href="javascript:void(0);" class="bannerTitle addMore" id="btnAddPurchasedetialItem">+增加明细</a>
        @endif
    <h3><strong>辅料:</strong></h3>
    <hr />

        @if(isset($inquiry_sheet->ingredientdetail))
        @else
        <div id="sortable2">
            <div class="col-xs-12 item-row margin-top-5">
            <div name="container_item_ingredientdetail">
                {{--<div class="row">--}}
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('ingredientid', '辅料', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::select('processid', $ingredientList,null, ['class' => 'form-control', 'placeholder' => '--请选择--', $attr, 'id' => 'processid_1']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('qty', '用料', ['class' => 'control-label']) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('qty', null, ['class' => 'form-control', $attr,  'id' => 'qty_1']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('price', '单价', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('price', null, ['class' => 'form-control', $attr,  'id' => 'price_1']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_price', '费用合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-10">
                                    {!! Form::text('total_price', null, ['class' => 'form-control', $attr,  'id' => 'total_price_1']) !!}
                                </div>

                                <div class="col-xs-1 text-right ">
                                    <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                {{--</div>--}}

                {{--<div class="row">--}}
                    <div class='col-xs-3'>
                        <div class="form-group">
                            {!! Form::label('total_qty', '用料合计', ['class' => 'control-label' ]) !!}
                            <div class="row">
                                <div class="col-xs-12">
                                    {!! Form::text('total_qty', null, ['class' => 'form-control', $attr,  'id' => 'total_qty_1']) !!}
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

                {{--</div>--}}
            </div>
            </div>
        </div>
                    {{--{!! Form::button('+增加明细', ['class' => 'btn btn-sm', 'id' => 'btnAddTravel']) !!}--}}
                    <a href="javascript:void(0);" class="bannerTitle addMore" id="btnAddIngedientdetailItem">+增加明细</a>

         @endif
    <h3><strong>加工明细:</strong></h3>
    <hr />

         @if(isset($inquiry_sheet->processdetail))
         @else
        <div id="sortable3">
            <div class="col-xs-12 item-row margin-top-5">
              <div name="container_item_processdetail">
                  {{--<div class="row">--}}
                      <div class='col-xs-3'>
                          <div class="form-group">
                              {!! Form::label('processid', '加工费', ['class' => 'control-label']) !!}
                              <div class="row">
                                  <div class="col-xs-12">
                                      {!! Form::select('processid', $processList,null, ['class' => 'form-control', 'placeholder' => '--请选择--', $attr, 'id' => 'processid_1']) !!}
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class='col-xs-3'>
                          <div class="form-group">
                              {!! Form::label('price', '费用价格', ['class' => 'control-label' ]) !!}
                              <div class="row">
                                  <div class="col-xs-12">
                                      {!! Form::text('price', null, ['class' => 'form-control', $attr,  'id' => 'price_1']) !!}
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class='col-xs-3'>
                          <div class="form-group">
                              {!! Form::label('total_price', '费用合计', ['class' => 'control-label' ]) !!}
                              <div class="row">
                                  <div class="col-xs-11">
                                      {!! Form::text('total_price', null, ['class' => 'form-control', $attr,  'id' => 'total_price_1']) !!}
                                  </div>
                                  <div class="col-xs-1 text-right ">
                                      <button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  </div>
                              </div>
                          </div>
                      </div>

                  {{--</div>--}}
              </div>
            </div>
        </div>

                {{--{!! Form::button('+增加明细', ['class' => 'btn btn-sm', 'id' => 'btnAddTravel']) !!}--}}
                <a href="javascript:void(0);" class="bannerTitle addMore" id="btnAddProcessdetailItem">+增加明细</a>
          @endif
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
                 {!! Form::label('process_costs', '加工费合计', ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="col-xs-12">
                         {!! Form::text('purchase_costs',  null, ['class' => 'form-control',  $attr]) !!}
                     </div>
                 </div>
             </div>
         </div>

         <div class='col-xs-3'>
             <div class="form-group">
                 {!! Form::label('purchase_costs', '采购费合计', ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="col-xs-12">
                         {!! Form::text('purchase_costs',  null, ['class' => 'form-control',  $attr]) !!}
                     </div>
                 </div>
             </div>
         </div>

         <div class='col-xs-3'>
             <div class="form-group">
                 {!! Form::label('total_costs', '合计总价', ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="col-xs-12">
                         {!! Form::text('total_costs',  null, ['class' => 'form-control',  $attr]) !!}
                     </div>
                 </div>
             </div>
         </div>
     </div>

      <div class="row">
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
      </div>

      <div class="row">
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
                  {!! Form::label('vol_total', '总体积', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('vol_total',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('qty_container', '每个集装箱可装数量', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('qty_container',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('inland_freight', '内陆运费$（40HQ）', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('inland_freight',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('arlington_ocean_freight', '海运费$(Arlington，USA-FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('arlington_ocean_freight',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('risk_rate', '风险率', ['class' => 'control-label']) !!}
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
                          {!! Form::text('fob_shanghai',  null, ['class' => 'form-control',  $attr]) !!}
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
      </div>

      <div class="row">
          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('arlington_ldp', 'LDP Arlington,USA(FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('arlington_ldp',  null, ['class' => 'form-control',  $attr]) !!}
                      </div>
                  </div>
              </div>
          </div>

          <div class='col-xs-3'>
              <div class="form-group">
                  {!! Form::label('atc_ldp', 'LDP ATC,CA,USA(FCL40HQ)', ['class' => 'control-label']) !!}
                  <div class="row">
                      <div class="col-xs-12">
                          {!! Form::text('atc_ldp',  null, ['class' => 'form-control',  $attr]) !!}
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




