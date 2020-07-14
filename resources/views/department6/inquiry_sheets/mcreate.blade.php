@extends('navbarerp')

@section('title', '创建询价单')

@section('main')
	<h2>添加询价信息</h2>
	<hr/>
@can('inquiry_sheets_create')
    {!! Form::open(array('url' => 'department6/inquiry_sheets/mstore', 'class'=>'panel-wrapper collapse in container-fluid', 'id' => 'formMain', 'files' => true)) !!}
        @include('department6.inquiry_sheets._form',
        	[
        		'submitButtonText' => '提交',
				'attr' => '',
				'btnclass' => 'btn btn-primary',
				'attrdisable' => 'readonly',
        	])

    {!! Form::close() !!}

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

@else
	<div class="alert alert-warning alert-block">
        <i class="fa fa-warning"></i>
        {{'无权限'}}
    </div>
@endcan

@section('script')
    <script src="{{asset('js/inline-attachment.js')}}"></script>
    <script src="{{asset('js/input.inline-attachment.js')}}"></script>
	<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
	<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('js/jquery-editable-select.js') }}"></script>
	<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">


	<script type="text/javascript">
		jQuery(document).ready(function(e) {
            var item_num1 = 1;
			var item_num2 = 1;
			var item_num3 = 1;

            var v_val;
            v_val=$(this).val();
            var url = '{{ config('app.url') }}';
            if(v_val !=''){
                $("#showImg").attr("src",url + v_val);
            }

// 			$('#selectPartid')
// 					.editableSelect({
// 						effects: 'slide',
// 					})
// 					.on('select.editable-select', function (e, li) {
//                    // console.log(li.val() + li.text());
// 						if (li.val() > 0)
// 							$('input[name=part_id]').val(li.val());
// 						else
// 							$('input[name=part_id]').val('');
// //                    console.log($('#project_id').val());
// 					});

            inlineAttachment.editors.input.attachToInput(document.getElementById("prod_photo"), {
                uploadUrl:'{{route('upload.images')}}',
                extraParams: {
                    '_token': '{{csrf_token()}}',
                },
                onFileUploadResponse: function(xhr) {
                    var result = JSON.parse(xhr.responseText),
                        filename = result[this.settings.jsonFieldName];

                    if (result && filename) {
                        var newValue;
                        if (typeof this.settings.urlText === 'function') {
                            newValue = this.settings.urlText.call(this, filename, result);
                        } else {
                            newValue = this.settings.urlText.replace(this.filenameTag, filename);
                        }
                        var text = this.editor.getValue().replace(this.lastValue, newValue);
                        this.editor.setValue(text);
                        this.settings.onFileUploaded.call(this, filename);
                    }
                    return false;
                }
            });
			$(function () {
				// $( "#sortable1" ).sortable();
				// $( "#sortable2" ).sortable();
				// $( "#sortable3" ).sortable();
			});

			$("#prod_photo").blur(function () {
				var v_val;
				v_val=$(this).val();
                var url = '{{ config('app.url') }}';
                if(v_val !=''){
                    $("#showImg").attr("src",url + v_val);
                }
			});


			 $("#btnSubmit").click(function() {
                 var itemArray1 = new Array();
				 var itemArray2 = new Array();
				 var itemArray3 = new Array();
				 var isok=true;
				if( $('#FOB_SH_price').val().trim() !="" && !$.isNumeric($('#FOB_SH_price').val()))
				{
					alert('大价格必须数字类型');
					return false;
				}
				 if( $('#customername').val().trim() =="" )
				 {
					 alert('客户不能为空');
					 return false;
				 }
				 if( $('#prod_photo').val().trim() =="" )
				 {
					 alert('产品照片不能为空');
					 return false;
				 }
				 if( $('#supplier_stock_number').val().trim() =="" )
				 {
					 alert('供应商编号不能为空');
					 return false;
				 }
				 if( $('#prod_size').val().trim() =="" )
				 {
					 alert('产品尺寸不能为空');
					 return false;
				 }
				 if( $('#prod_qty').val().trim() !="" && !$.isNumeric($('#prod_qty').val()))
				 {
					 alert('产品数量必须数字类型');
					 return false;
				 }
				 if( $('#process_tax').val().trim() !="" && !$.isNumeric($('#process_tax').val()))
				 {
					 alert('加工税必须数字类型');
					 return false;
				 }
				 if( $('#length_carton').val().trim() !="" && !$.isNumeric($('#length_carton').val()))
				 {
					 alert('L(箱长度)必须数字类型');
					 return false;
				 }
				 if( $('#width_carton').val().trim() !="" && !$.isNumeric($('#width_carton').val()))
				 {
					 alert('W(箱宽度)必须数字类型');
					 return false;
				 }
				 if( $('#high_carton').val().trim() !="" && !$.isNumeric($('#high_carton').val()))
				 {
					 alert('H(箱高度)必须数字类型');
					 return false;
				 }
				 if( $('#qty_percarton').val().trim() !="" && !$.isNumeric($('#qty_percarton').val()))
				 {
					 alert('每箱数量必须整形类型');
					 return false;
				 }
				 if( $('#exchange_rate').val().trim() !="" && !$.isNumeric($('#exchange_rate').val()))
				 {
					 alert('汇率必须数字类型');
					 return false;
				 }
				 // if( $('#import_rate').val().trim() !="" && !$.isNumeric($('#import_rate').val()))
				 // if( !validationNumber(document.getElementById("import_rate"),6,3))
				 if ($('#import_rate').val().trim() !="" && !$.isNumeric($('#import_rate').val()))
				 {
					 // alert('进口税率必须数字类型');
					 return false;
				 }

                $("div[name='container_item_purchasedetail").each(function(i){
                    var itemObject = new Object();
                    var container = $(this);
                    // alert(container.find("select[name='partid']").val());
					if ((container.find("select[name='partid']").val() =="" || container.find("select[name='partid']").val() == null )&& isok)
					{
						var j=i+1;
						isok=false;
						alert('部位面料信息第'+ j + '行中的部位不能为空!');
						return ;
					}
                    itemObject.partid = container.find("select[name='partid']").val();
                    itemObject.fabric_desc = container.find("input[name='fabric_desc']").val();
                    itemObject.composition = container.find("input[name='composition']").val();
                    itemObject.valid_width = container.find("input[name='valid_width']").val();
                    itemObject.edge_to_edge_width = container.find("input[name='edge_to_edge_width']").val();
                    itemObject.qty = container.find("input[name='qty']").val();
                    itemObject.price = container.find("input[name='price']").val();
					itemObject.outprice = container.find("input[name='outprice']").val();
                    itemObject.total_qty = container.find("input[name='total_qty']").val();
                    itemObject.total_price = container.find("input[name='total_price']").val();
					itemObject.total_outprice = container.find("input[name='total_outprice']").val();
                    itemObject.factoryname = container.find("input[name='factoryname']").val();

                    itemArray1.push(itemObject);

                });

				 $("div[name='container_item_ingredientdetail']").each(function(i){
					 var itemObject = new Object();
					 var container = $(this);

					 if ((container.find("select[name='ingredientid']").val() =="" ||  container.find("select[name='ingredientid']").val() == null) && isok)
					 {
						var j=i+1;
						 isok=false;
					 	alert('辅料信息中第'+ j + '行的辅料不能为空!');
						 return ;
					 }
					 itemObject.ingredientid = container.find("select[name='ingredientid']").val();
					 itemObject.qty = container.find("input[name='qty']").val();
					 itemObject.price = container.find("input[name='price']").val();
					 itemObject.outprice = container.find("input[name='outprice']").val();
					 itemObject.total_qty = container.find("input[name='total_qty']").val();
					 itemObject.total_price = container.find("input[name='total_price']").val();
					 itemObject.total_outprice = container.find("input[name='total_outprice']").val();
					 itemObject.remark_factory = container.find("input[name='remark_factory']").val();
					 itemObject.ingredient_desc = container.find("input[name='ingredient_desc']").val();

					 itemArray2.push(itemObject);
				 });

				 $("div[name='container_item_processdetail']").each(function(i){
					 var itemObject = new Object();
					 var container = $(this);

					 if ((container.find("select[name='processid']").val() =="" || container.find("select[name='processid']").val() == null) && isok)
					 {
						 var j=i+1;
						 isok=false;
						 alert('加工信息中第'+ j + '行的加工不能为空!');
						 return ;
					 }

					 itemObject.processid = container.find("select[name='processid']").val();
					 itemObject.price = container.find("input[name='price']").val();
					 itemObject.total_price = container.find("input[name='total_price']").val();

					 itemArray3.push(itemObject);

				 });

                $("#items_string1").val(JSON.stringify(itemArray1));
				$("#items_string2").val(JSON.stringify(itemArray2));
				$("#items_string3").val(JSON.stringify(itemArray3));

				 // alert(isok);
				if(isok)
				{
					$("form#formMain").submit();
				}
				else { return false;}
				// else
				// {
				// 	alert('数据有问题，无法提交');
				// 	return false;
				// }
				//

			 });

			function validationNumber(e, len,num) {
				var regu = /^[0-9]+\.?[0-9]*$/;
				// alert(e.value.length);
				if (e.value != "") {
					if (!regu.test(e.value)) {

						alert(e.name + "请输入正确的数字");
						e.focus();
						return false;
					} else {
						if(e.value.length>len)
						{
							alert(e.name +"超过总位数:" + len);
							e.focus();
							return false;
						}
						else {
							if (e.value.indexOf('.') > -1) {
								if (e.value.split('.')[1].length > num) {
									// e.value = e.value.substring(0, e.value.length - 1);
									alert(e.name +"小数位超过:" + num);
									e.focus();
									return false;
								}
							}
						}
						return true;
					}
				}
				return true;
			};

            $('#btnAddPurchasedetialItem').click(function() {
				item_num1++;
				var trColor;
				if (item_num1 % 2 == 0) {
					trColor = "even";
				}else {
					trColor = "odd";
				}

                var  itemHtml = '<div class="item-row margin-top-5 ' + trColor + '">\
                <div name="container_item_purchasedetail">\
                	<div class="row">\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="partid" class="control-label">部位</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<select id="partid_' + String(item_num1) + '" class="form-control" name="partid" >\
											<option value="" disabled selected>--请选择--</option>\
											@foreach($parts as $part)
													 <option  value="{{ $part->id }}">{{ $part->name }}</option>\
											@endforeach
										</select>\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="fabric_desc" class="control-label">面料</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control"  name="fabric_desc" type="text" id="fabric_desc_' + String(item_num1) + '">\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="composition" class="control-label">成分</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control"  name="composition" type="text" id="composition_' + String(item_num1) + '">\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="valid_width" class="control-label">有效门幅</label>\
								<div class="row">\
									<div class="col-xs-10">\
										<input class="form-control"  type="text" id="valid_width_' + String(item_num1) + '" name="valid_width" >\
									</div>\
									<div class="col-xs-1 text-right ">\
										<button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="edge_to_edge_width" class="control-label">边到边门幅</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control"  type="text" id="edge_to_edge_width_' + String(item_num1) + '" name="edge_to_edge_width" >\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="qty" class="control-label">用料</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control qty"   type="text" id="qty_' + String(item_num1) + '" name="qty" >\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="price" class="control-label">工厂单价</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control price"  type="text" id="price_' + String(item_num1) + '" name="price" >\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="outprice" class="control-label">报出单价</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control outprice"  type="text" id="price_' + String(item_num1) + '" name="outprice" >\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
					    <div class="col-xs-3">\
							<div class="form-group">\
								<label for="total_price" class="control-label">工厂费用合计</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control total_price"  type="text" id="total_price_' + String(item_num1) + '" name="total_price" disabled="disabled" >\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="total_outprice" class="control-label">报出费用合计</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control total_outprice"  type="text" id="total_outprice_' + String(item_num1) + '" name="total_outprice" disabled="disabled" >\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="total_qty" class="control-label">用料合计</label>\
									<div class="row">\
										<div class="col-xs-12">\
											<input class="form-control total_qty"  type="text" id="total_qty_' + String(item_num1) + '" name="total_qty" disabled="disabled" >\
										</div>\
									</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="factoryname" class="control-label">工厂</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control"  type="text" id="factoryname_' + String(item_num1) + '" name="factoryname" >\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
				</div>\
			</div>';
				$(itemHtml).hide().appendTo("#sortable1").fadeIn(500);
				// alert(itemHtml);
            });

			$("#btnAddIngedientdetailItem").click(function() {
				item_num2++;
				var trColor;
				if (item_num2 % 2 == 0) {
					trColor = "even";
				}else {
					trColor = "odd";
				}
				var itemHtml = '<div class="item-row margin-top-5 ' + trColor + '">\
				<div name="container_item_ingredientdetail">\
					<div class="row">\
                	<div class="col-xs-3">\
						<div class="form-group">\
							<label for="ingredientid" class="control-label">辅料</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<select id="ingredientid_' + String(item_num2) + '" class="form-control" name="ingredientid" >\
									<option value="" disabled selected>--请选择--</option>\
									@foreach($ingredients as $ingredient)
										<option  value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>\
									@endforeach
									</select>\
								</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="qty" class="control-label">用料</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control qty"  type="text" id="qty_' + String(item_num2) + '" name="qty" >\
									</div>\
								</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="price" class="control-label">工厂单价</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<input class="form-control price"  type="text" id="price_' + String(item_num2) + '" name="price" >\
                				</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="outprice" class="control-label">报出单价</label>\
							<div class="row">\
								<div class="col-xs-11">\
									<input class="form-control outprice"  type="text" id="price_' + String(item_num2) + '" name="outprice" >\
                				</div>\
                				<div class="col-xs-1 text-right ">\
									<button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
								</div>\
							</div>\
						</div>\
					</div>\
					</div>\
					<div class="row">\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="total_price" class="control-label">工厂费用合计</label>\
								<div class="row">\
									<div class="col-xs-10">\
										<input class="form-control total_price"  type="text" id="total_price_' + String(item_num2) + '" name="total_price" disabled="disabled">\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="total_outprice" class="control-label">报出费用合计</label>\
								<div class="row">\
									<div class="col-xs-10">\
										<input class="form-control total_outprice"  type="text" id="total_outprice_' + String(item_num2) + '" name="total_outprice" disabled="disabled">\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="total_qty" class="control-label">用料合计</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control total_qty"  type="text" id="total_qty_' + String(item_num2) + '" name="total_qty" disabled="disabled">\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="remark_factory" class="control-label">工厂提供</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control"  type="text" id="remark_factory_' + String(item_num2) + '" name="remark_factory" >\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="ingredient_desc" class="control-label">辅料说明</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<input class="form-control"  type="text" id="ingredient_desc_' + String(item_num2) + '" name="ingredient_desc" >\
									</div>\
								</div>\
							</div>\
						</div>\
					</div>\
				</div>\
				</div>\
			</div>';
				$(itemHtml).hide().appendTo("#sortable2").fadeIn(500);
			});

			$("#btnAddProcessdetailItem").click(function() {
				item_num3++;
				var trColor;
				if (item_num3 % 2 == 0) {
					trColor = "even";
				}else {
					trColor = "odd";
				}
				{{--{{$processes}};--}}
				var itemHtml = '<div class="item-row margin-top-5 '+ trColor +'">\
				<div name="container_item_processdetail">\
					<div class="row">\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="processid" class="control-label">加工费</label>\
								<div class="row">\
									<div class="col-xs-12">\
										<select id="processid_' + String(item_num3) + '" class="form-control" name="processid"  >\
										<option value="" disabled selected>--请选择--</option> \
										@foreach($processes as $process)
											<option  value="{{ $process->id }}">{{ $process->name }}</option>\
										@endforeach
										</select>\
									</div>\
								</div>\
							</div>\
						</div>\
						<div class="col-xs-3">\
							<div class="form-group">\
								<label for="price" class="control-label">费用价格</label>\
									<div class="row">\
										<div class="col-xs-11">\
											<input class="form-control price"  type="text" id="price_' + String(item_num3) + '" name="price" >\
										</div>\
										<div class="col-xs-1 text-right ">\
											<button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
										</div>\
									</div>\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>';

				$(itemHtml).hide().appendTo("#sortable3").fadeIn(500);
			});

			$('#formMain').on('click','.remove-item', function () {
				$(this).closest('.item-row').fadeOut(300, function() {
					$(this).remove();
					calculateTotal();
				});
			});

			$('#formMain').on('keyup change','.qty, .price,.outprice,#length_carton,#width_carton,#high_carton,#qty_percarton,#process_tax,#exchange_rate,#risk_rate', function () {
				var quantity = $(this).closest('.item-row').find('.qty').val();

				var perItemCost = $(this).closest('.item-row').find('.price').val();
				var perItemOutCost = $(this).closest('.item-row').find('.outprice').val();
				var  prod_qty =$('#prod_qty').val();
				var amount = (quantity*perItemCost);
				var outamount= (quantity * perItemOutCost);
				var perItemQty =parseFloat(quantity) * parseFloat(prod_qty);

				$(this).closest('.item-row').find('.total_price').val(amount.toFixed(2));
				$(this).closest('.item-row').find('.total_qty').val(perItemQty.toFixed(2));
				$(this).closest('.item-row').find('.total_outprice').val(outamount.toFixed(2));
				// alert($(this).closest('.item-row').children('div').attr('name'));

				calculateTotal();

			});

			function calculateTotal() {
				var vamount=0;
				var vprod_qty =$('#prod_qty').val();
				var vamountPurchase=0;
				var vamountOutPurchase=0;
				var vamountIngredient=0;
				var vamountOutIngredient=0;
				var vamountCost=0;
				var vprocessCost=0;
				var vpurchaseCost=0;
				var vtotalCost=0;
				// var purchasecost=0;
				// var integrientcost=0;
				$(".price").each(function(index,element) {

					// alert($(this).closest('.item-row').children('div').attr('name'));
					if($(this).closest('.item-row').children('div').attr('name') == 'container_item_processdetail')
					{
						var perProcessItemCost = $(this).closest('.item-row').find('.price').val();
						vamount = (perProcessItemCost * vprod_qty) + vamount;
					}

					if($(this).closest('.item-row').children('div').attr('name') == 'container_item_purchasedetail')
					{
						var perPurchaseItemCost = $(this).closest('.item-row').find('.total_price').val();
						var perPurchaseItemOutCost = $(this).closest('.item-row').find('.total_outprice').val();
						vamountPurchase = parseFloat(perPurchaseItemCost) + parseFloat(vamountPurchase);
						vamountOutPurchase = parseFloat(perPurchaseItemOutCost) + parseFloat(vamountOutPurchase);
					}
					//
					if($(this).closest('.item-row').children('div').attr('name') == 'container_item_ingredientdetail')
					{
						var perIngredientItemCost = $(this).closest('.item-row').find('.total_price').val();
						var perIngredientItemOutCost = $(this).closest('.item-row').find('.total_outprice').val();
						vamountIngredient = parseFloat(perIngredientItemCost) + parseFloat(vamountIngredient);
						vamountOutIngredient = parseFloat(perIngredientItemOutCost) + parseFloat(vamountOutIngredient);
					}

				});
				if(isNaN(vamountIngredient))
				{
					vamountIngredient=0;
				}
				if(isNaN(vamountPurchase))
				{
					vamountPurchase=0;
				}
				if(isNaN(vamountOutIngredient))
				{
					vamountOutIngredient=0;
				}
				if(isNaN(vamountOutPurchase))
				{
					vamountOutPurchase=0;
				}
				vamountCost= parseFloat(vamountPurchase) + parseFloat(vamountIngredient);
				var vamountOutCost= parseFloat(vamountOutPurchase) + parseFloat(vamountOutIngredient);
				// alert(vamountCost);
				$('#process_costs').val(vamount.toFixed(2));
				$('#purchase_costs').val(vamountCost.toFixed(2));
				$('#purchase_outcosts').val(vamountOutCost.toFixed(2));
				vprocessCost=$('#process_costs').val();
				vpurchaseCost=$('#purchase_costs').val();
				var vpurchaseOutCost=$('#purchase_outcosts').val();
				vtotalCost=parseFloat(vprocessCost) + parseFloat(vpurchaseCost);
				var vtotalOutCost=parseFloat(vprocessCost) + parseFloat(vpurchaseOutCost);
				if(isNaN(vtotalCost )|| vtotalCost=="" || vtotalCost=="Infinity" )
					vtotalCost=0
				$('#total_costs').val(vtotalCost.toFixed(2));

				if(isNaN(vtotalOutCost )|| vtotalOutCost=="" || vtotalOutCost=="Infinity" )
					vtotalOutCost=0
				$('#total_outcosts').val(vtotalOutCost.toFixed(2));

				var processtax=$('#process_tax').val();
				if(isNaN(processtax )|| processtax=="" || processtax=="Infinity" )
					processtax=0
				var process_taxcosts=parseFloat(processtax) + parseFloat(vprocessCost);
				if(isNaN(process_taxcosts )|| process_taxcosts=="" || process_taxcosts=="Infinity" )
					process_taxcosts=0
				$('#process_taxcosts').val(process_taxcosts.toFixed(2));

				var volL=$('#length_carton').val();
				var volW=$('#width_carton').val();
				var volH=$('#high_carton').val();
				// alert(valL);
				var qty_percarton=$('#qty_percarton').val();
				var vol_carton= parseFloat(volL) *parseFloat(volW) * parseFloat(volH).toFixed(2);
				var total_vol = parseFloat(vol_carton)/parseFloat(qty_percarton)/1000000 * parseFloat(vprod_qty);
				if(isNaN(total_vol )|| total_vol=="" || total_vol=="Infinity" )
				{
					$('#vol_total').val(0);
				}
				else
				{
					$('#vol_total').val(parseFloat(total_vol.toFixed(0)));
				}

				var qty_container = 60 *1000000/parseFloat(vol_carton) * parseFloat(qty_percarton);
				if(isNaN(qty_container) || qty_container=="")
					qty_container=0;
				$('#qty_container').val(parseFloat(qty_container).toFixed(0));
				var inland_freight = 850 /parseFloat(qty_container);
				// alert(inland_freight);
				if(isNaN(inland_freight) || inland_freight=="" || inland_freight=="Infinity")
					inland_freight=0;
				$('#inland_freight').val(parseFloat(inland_freight).toFixed(2));
				var arlington_ocean_freight=4900 / parseFloat(qty_container);
				if(isNaN(arlington_ocean_freight) || arlington_ocean_freight=="" || arlington_ocean_freight=="Infinity")
					arlington_ocean_freight=0;
				$('#arlington_ocean_freight').val(parseFloat(arlington_ocean_freight).toFixed(2));
				var atc_ocean_freight = 5200 /parseFloat(qty_container);
				if(isNaN(atc_ocean_freight) || atc_ocean_freight=="" || atc_ocean_freight=="Infinity")
					atc_ocean_freight=0;
				$('#atc_ocean_freight').val(parseFloat(atc_ocean_freight).toFixed(2));

				var inland_freight =$('#inland_freight').val();
				var exchange_rate=$('#exchange_rate').val();
				var risk_rate=$('#risk_rate').val();
				var fob_shanghai = (parseFloat(vtotalCost) /exchange_rate + parseFloat(inland_freight))/(1-risk_rate);
				if(isNaN(fob_shanghai) || fob_shanghai=="" || fob_shanghai=="Infinity")
					fob_shanghai=0;
				$('#fob_shanghai').val(fob_shanghai.toFixed(2));
				var arlington_ocean_freight =$('#arlington_ocean_freight').val();
				if(isNaN(arlington_ocean_freight) || arlington_ocean_freight=="" || arlington_ocean_freight=="Infinity")
					arlington_ocean_freight=0;
				var arlington_ldp =parseFloat(fob_shanghai) * 0.8 * 1.145 + parseFloat(arlington_ocean_freight);
				if(isNaN(arlington_ldp) || arlington_ldp=="" || arlington_ldp=="Infinity")
					arlington_ldp=0;
				$('#arlington_ldp').val(arlington_ldp.toFixed(2));
				var atc_ocean_freight = $('#atc_ocean_freight').val();
				var atc_ldp = parseFloat(fob_shanghai) * 0.8 * 1.145 + parseFloat(atc_ocean_freight);
				if(isNaN(atc_ldp) || atc_ldp=="" || atc_ldp=="Infinity")
					atc_ldp=0;
				$('#atc_ldp').val(atc_ldp.toFixed(2));

			}

			$('#prod_qty').on('keyup change',function () {
				var prod_qty=$(this).val();
				$('.total_qty').each(function (index,element) {
				var quantity = $(this).closest('.item-row').find('.qty').val();
				var perItemQty =(parseFloat(quantity) * parseFloat(prod_qty));
				$(this).val(perItemQty.toFixed(2));
				})
				calculateTotal();
			})
		});
	</script>
@endsection
@stop
