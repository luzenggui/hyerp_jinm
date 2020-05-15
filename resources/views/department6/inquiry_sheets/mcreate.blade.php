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

	<script type="text/javascript">
		jQuery(document).ready(function(e) {
            var item_num1 = 1;
			var item_num2 = 1;
			var item_num3 = 1;

            inlineAttachment.editors.input.attachToInput(document.getElementById("content"), {
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
				$( "#sortable1" ).sortable();
				$( "#sortable2" ).sortable();
				$( "#sortable3" ).sortable();
			});


			 $("#btnSubmit").click(function() {
                 var itemArray1 = new Array();
				 var itemArray2 = new Array();
				 var itemArray3 = new Array();



                $("div[name='container_item_purchasedetail").each(function(i){
                    var itemObject = new Object();
                    var container = $(this);

                    itemObject.partid = container.find("select[name='partid']").val();
                    itemObject.fabric_desc = container.find("input[name='fabric_desc']").val();
                    itemObject.composition = container.find("input[name='composition']").val();
                    itemObject.valid_width = container.find("input[name='valid_width']").val();
                    itemObject.edge_to_edge_width = container.find("input[name='edge_to_edge_width']").val();
                    itemObject.qty = container.find("input[name='qty']").val();
                    itemObject.price = container.find("input[name='price']").val();
                    itemObject.total_qty = container.find("input[name='total_qty']").val();
                    itemObject.total_price = container.find("input[name='total_price']").val();
                    itemObject.factoryname = container.find("input[name='factoryname']").val();

                    itemArray1.push(itemObject);

                });

				 $("div[name='container_item_ingredientdetail']").each(function(i){
					 var itemObject = new Object();
					 var container = $(this);

					 itemObject.ingredientid = container.find("select[name='ingredientid']").val();
					 itemObject.qty = container.find("input[name='qty']").val();
					 itemObject.price = container.find("input[name='price']").val();
					 itemObject.total_qty = container.find("input[name='total_qty']").val();
					 itemObject.total_price = container.find("input[name='total_price']").val();
					 itemObject.remark_factory = container.find("input[name='remark_factory']").val();

					 itemArray2.push(itemObject);
				 });

				 $("div[name='container_item_processdetail']").each(function(i){
					 var itemObject = new Object();
					 var container = $(this);
					 <?php  Log::info(11111);   ?>
					 itemObject.processid = container.find("select[name='processid']").val();
					 itemObject.price = container.find("input[name='price']").val();
					 itemObject.total_price = container.find("input[name='total_price']").val();

					 itemArray3.push(itemObject);
				 });

                $("#items_string1").val(JSON.stringify(itemArray1));
				$("#items_string2").val(JSON.stringify(itemArray2));
				$("#items_string3").val(JSON.stringify(itemArray3));


				$("form#formMain").submit();

			 });


            $('#btnAddPurchasedetialItem').click(function() {
				item_num1++;

                var  itemHtml = '<div class="col-xs-12 item-row margin-top-5">\
                <div name="container_item_purchasedetail">\
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
									<input class="form-control"  name="fabric_desc" type="text" id="fabric_desc_' + String(item_num1) + '">\
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
									<input class="form-control"  type="text" id="qty_' + String(item_num1) + '" name="qty" >\
                				</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="price" class="control-label">面料单价</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<input class="form-control"  type="text" id="price_' + String(item_num1) + '" name="price" >\
                				</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="total_qty" class="control-label">用料合计</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<input class="form-control"  type="text" id="total_qty_' + String(item_num1) + '" name="total_qty" >\
                				</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="total_price" class="control-label">费用合计</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<input class="form-control"  type="text" id="total_price_' + String(item_num1) + '" name="total_price" >\
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
			</div>';
				$(itemHtml).hide().appendTo("#sortable1").fadeIn(500);
            });

			$("#btnAddIngedientdetailItem").click(function() {
				item_num2++;

				var itemHtml = '<div class="col-xs-12 item-row margin-top-5">\
				<div name="container_item_ingredientdetail">\
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
										<input class="form-control"  type="text" id="qty_' + String(item_num2) + '" name="qty" >\
									</div>\
								</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="price" class="control-label">单价</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<input class="form-control"  type="text" id="price_' + String(item_num2) + '" name="price" >\
                				</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="total_price" class="control-label">费用合计</label>\
							<div class="row">\
								<div class="col-xs-10">\
									<input class="form-control"  type="text" id="total_price_\' + String(item_num2) + \'" name="total_price" >\
                				</div>\
                				<div class="col-xs-1 text-right ">\
										<button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
								</div>\
							</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="total_qty" class="control-label">用料合计</label>\
							<div class="row">\
								<div class="col-xs-12">\
									<input class="form-control"  type="text" id="total_qty_' + String(item_num2) + '" name="total_qty" >\
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
				{{--{{$processes}};--}}
				var itemHtml = '<div class="col-xs-12 item-row margin-top-5">\
				<div name="container_item_processdetail">\
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
									<div class="col-xs-12">\
										<input class="form-control"  type="text" id="price_' + String(item_num3) + '" name="price" >\
									</div>\
								</div>\
						</div>\
					</div>\
					<div class="col-xs-3">\
						<div class="form-group">\
							<label for="total_price" class="control-label">费用合计</label>\
							<div class="row">\
								<div class="col-xs-11">\
									<input class="form-control"  type="text" id="total_price_' + String(item_num3) + '" name="total_price" >\
								</div>\
								<div class="col-xs-1 text-right ">\
									<button type="button" class="btn btn-circle remove-item" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
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
					// calculateTotal();
				});
			});

		});
	</script>
@endsection
@stop
