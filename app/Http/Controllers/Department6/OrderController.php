<?php

namespace App\Http\Controllers\Department6;

use App\Models\Department6\Ingredient;
use App\Models\Department6\Orderingredient;
use App\Models\Department6\Order;
use App\Models\Department6\Part;
use App\Models\Department6\Process;
use App\Models\Department6\Orderpart;
use App\Models\Department6\Orderprocess;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $request = request();
        $inputs = $request->all();
        $orders = $this->searchrequest($request)->paginate('10');

        return view('department6.orders.index', compact('orders', 'inputs'));

    }

    public function search(Request $request)
    {
        //
        $inputs = $request->all();

        //dd($inputs);
        $orders = $this->searchrequest($request)->paginate('10');

        return view('department6.orders.index', compact('orders','inputs'));
    }

    public function searchrequest($request)
    {
        $key = $request->input('key');


        $query = Order::latest('created_at');

        if (strlen($key) > 0)
        {
            $query->where('supplier_stock_number', 'like', '%'.$key.'%');
        }



        $orders = $query->select('*');

        // $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();
        // dd($purchaseorders->pluck('id'));

        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mcreate()
    {
        //
        $parts=Part::select('*')->get();
        $processes=Process::select('*')->get();
        $ingredients=Ingredient::select('*')->get();
//        dd($parts->count('*'));
        return view('department6/orders/mcreate',compact('parts','processes','ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mstore(Request $request)
    {
        //
        $input = $request->all();
//        Log::info($request);
//        Log::info($input);
//        Log::info(json_decode(json_decode($input['items_string1'])[0]));
        //        dd($input);
        $orderparts = json_decode($input['items_string1']);
        $orderingredients = json_decode($input['items_string2']);
        $orderprocesses = json_decode($input['items_string3']);

        $order = Order::create(array('customername'=>$input['customername'],
            'prod_description'=>isset($input['prod_description'])? $input['prod_description']:null,
            'prod_photo'=>$input['prod_photo'],
            'prod_size'=>isset($input['prod_size'])? $input['prod_size']:null,
            'customer_item_name'=>isset($input['customer_item_name'])? $input['customer_item_name']:null,
            'supplier_stock_number'=>$input['supplier_stock_number'],
            'UPC'=>isset($input['UPC'])? $input['UPC']:null,
            'prod_qty'=>isset($input['prod_qty'])? $input['prod_qty']:null,
            'FOB_SH_price'=>isset($input['FOB_SH_price'])? $input['FOB_SH_price']:null,
            'ingredients_note'=>isset($input['ingredients_note'])? $input['ingredients_note']:null,
            'packing_note'=>isset($input['packing_note'])? $input['packing_note']:null,
            'remark_factory'=>isset($input['remark_factory'])? $input['remark_factory']:null,
            'process_costs'=>isset($input['process_costs'])? $input['process_costs']:null,
            'process_taxcosts'=>isset($input['process_taxcosts'])? $input['process_taxcosts']:null,
            'purchase_costs'=>isset($input['purchase_costs'])? $input['purchase_costs']:null,
            'total_costs'=>isset($input['total_costs'])? $input['total_costs']:null,
            'remark'=>isset($input['remark'])? $input['remark']:null,
            'length_carton'=>isset($input['length_carton'])? $input['length_carton']:null,
            'width_carton'=>isset($input['width_carton'])? $input['width_carton']:null,
            'high_carton'=>isset($input['high_carton'])? $input['high_carton']:null,
            'qty_percarton'=>isset($input['qty_percarton'])? $input['qty_percarton']:null,
            'vol_total'=>isset($input['vol_total'])? $input['vol_total']:null,
            'qty_container'=>isset($input['qty_container'])? $input['qty_container']:null,
            'inland_freight'=>isset($input['inland_freight'])? $input['inland_freight']:null,
            'arlington_ocean_freight'=>isset($input['arlington_ocean_freight'])? $input['arlington_ocean_freight']:null,
            'atc_ocean_freight'=>isset($input['atc_ocean_freight'])? $input['atc_ocean_freight']:null,
            'risk_rate'=>isset($input['risk_rate'])? $input['risk_rate']:null,
            'fob_shanghai'=>isset($input['fob_shanghai'])? $input['fob_shanghai']:null,
            'import_rate'=>isset($input['import_rate'])? $input['import_rate']:null,
            'arlington_ldp'=>isset($input['arlington_ldp'])? $input['arlington_ldp']:null,
            'atc_ldp'=>isset($input['atc_ldp'])? $input['atc_ldp']:null,
            'process_tax'=>isset($input['process_tax'])? $input['process_tax']:null,
            'exchange_rate'=>isset($input['exchange_rate'])? $input['exchange_rate']:null
        ));
        $orderid=$order->id;

        foreach ($orderparts as $orderpart) {
            Orderpart::create(array('orderid'=>$orderid,'partid'=>$orderpart->partid,
                'fabric_desc'=>isset($orderpart->fabric_desc)? $orderpart->fabric_desc:null,
                'composition'=>isset($orderpart->composition)? $orderpart->composition:null,
                'valid_width'=>isset($orderpart->valid_width)? $orderpart->valid_width:null,
                'edge_to_edge_width'=>isset($orderpart->edge_to_edge_width)? $orderpart->edge_to_edge_width:null,
                'qty'=>isset($orderpart->qty) && trim($orderpart->qty)!=''? $orderpart->qty:null,
                'price'=>isset($orderpart->price) && trim($orderpart->price) !=''? $orderpart->price:null,
                'total_qty'=>isset($orderpart->total_qty)&& trim($orderpart->total_qty) !=''? $orderpart->total_qty:null,
                'total_price'=>isset($orderpart->total_price)&& trim($orderpart->total_price) !=''? $orderpart->total_price:null,
                'factoryname'=>isset($orderpart->factoryname)? $orderpart->factoryname:null));
        }
        foreach ($orderingredients as $orderingredient) {
            Orderingredient::create(array('orderid'=>$orderid,'ingredientid'=>$orderingredient->ingredientid,
                'qty'=>isset($orderingredient->qty) && trim($orderingredient->qty)!=''? $orderingredient->qty:null,
                'price'=>isset($orderingredient->price) && trim($orderingredient->price)!='' ? $orderingredient->price:null,
                'total_qty'=>isset($orderingredient->total_qty) && trim($orderingredient->total_qty)!=''? $orderingredient->total_qty:null,
                'total_price'=>isset($orderingredient->total_price) && trim($orderingredient->total_price)!=''? $orderingredient->total_price:null,
                'remark_factory'=>isset($orderingredient->remark_factory)? $orderingredient->remark_factory:null,
                'ingredient_desc'=>isset($orderingredient->ingredient_desc)? $orderingredient->ingredient_desc:null
            ));
        }
        foreach ($orderprocesses as $orderprocess) {
            Orderprocess::create(array('orderid'=>$orderid,'processid'=>$orderprocess->processid,
                'price'=>isset($orderprocess->price)&& trim($orderprocess->price)!='' ? $orderprocess->price:null));
        }
//        dd('创建成功.');
        return redirect('department6/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $order = Order::findOrFail($id);
        $parts=Part::select('*')->get();
        $processes=Process::select('*')->get();
        $ingredients=Ingredient::select('*')->get();
        $orderparts =$order->orderpart();
        $orderingredients=$order->orderingredient();
        $orderprocesses=$order->orderprocess();

        return view('department6/orders/edit',compact('order','parts','processes','ingredients','orderparts','orderingredients','orderprocesses'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
//        $purchasedetailids= array();
//        $ingredientdetailids=array();
//        $processdetailids=array();

        $input = $request->all();
        Log::info($input);

        $order = Order::findOrFail($id);
//        Log::info($order);
        $order->customername=$input['customername'];
        $order->prod_description=$input['prod_description'];
        $order->prod_photo=$input['prod_photo'];
        $order->prod_size=$input['prod_size'];
        $order->customer_item_name=$input['customer_item_name'];
        $order->supplier_stock_number=$input['supplier_stock_number'];
        $order->UPC =$input['UPC'];
        $order->prod_qty=$input['prod_qty'];
        $order->FOB_SH_price=$input['FOB_SH_price'];
        $order->ingredients_note=$input['ingredients_note'];
        $order->packing_note=$input['packing_note'];
        $order->remark_factory=$input['remark_factory'];
        $order->process_costs=$input['process_costs'];
        $order->purchase_costs=$input['purchase_costs'];
        $order->process_taxcosts=$input['process_taxcosts'];
        $order->total_costs=$input['total_costs'];
        $order->remark=$input['remark'];
        $order->length_carton=$input['length_carton'];
        $order->width_carton=$input['width_carton'];
        $order->high_carton=$input['high_carton'];
        $order->qty_percarton=$input['qty_percarton'];
        $order->vol_total=$input['vol_total'];
        $order->qty_container=$input['qty_container'];
        $order->inland_freight=$input['inland_freight'];
        $order->arlington_ocean_freight=$input['arlington_ocean_freight'];
        $order->atc_ocean_freight=$input['atc_ocean_freight'];
        $order->risk_rate=$input['risk_rate'];
        $order->fob_shanghai=$input['fob_shanghai'];
        $order->import_rate=$input['import_rate'];
        $order->arlington_ldp=$input['arlington_ldp'];
        $order->atc_ldp=$input['atc_ldp'];
        $order->process_tax=$input['process_tax'];
        $order->eachange_rate=$input['eachange_rate'];
        $order->save();

        $orderparts = json_decode($input['items_string1']);
        $orderingredients = json_decode($input['items_string2']);
        $orderprocesses = json_decode($input['items_string3']);

//        Log::info($orderprocesses);
//        dd(array_map('reset',$orderparts));

        Orderpart::where('orderid',$id)->delete();

        foreach ($orderparts as $orderpart)
        {
            Log::info($orderpart->fabric_desc);
            Orderpart::create(array('orderid'=>$id,'partid'=>$orderpart->partid,
                'fabric_desc'=>isset($orderpart->fabric_desc)? $orderpart->fabric_desc:null,
                'composition'=>isset($orderpart->composition)? $orderpart->composition:null,
                'valid_width'=>isset($orderpart->valid_width)? $orderpart->valid_width:null,
                'edge_to_edge_width'=>isset($orderpart->edge_to_edge_width)? $orderpart->edge_to_edge_width:null,
                'qty'=>isset($orderpart->qty) && trim($orderpart->qty)!=''? $orderpart->qty:null,
                'price'=>isset($orderpart->price) && trim($orderpart->price) !=''? $orderpart->price:null,
                'total_qty'=>isset($orderpart->total_qty)&& trim($orderpart->total_qty) !=''? $orderpart->total_qty:null,
                'total_price'=>isset($orderpart->total_price)&& trim($orderpart->total_price) !=''? $orderpart->total_price:null,
                'factoryname'=>isset($orderpart->factoryname)? $orderpart->factoryname:null));

        }


        Orderingredient::where('orderid',$id)->delete();
        foreach ($orderingredients as $orderingredient)
        {
            Orderingredient::create(array('orderid'=>$id,'ingredientid'=>$orderingredient->ingredientid,
                'qty'=>isset($orderingredient->qty) && trim($orderingredient->qty)!=''? $orderingredient->qty:null,
                'price'=>isset($orderingredient->price) && trim($orderingredient->price)!='' ? $orderingredient->price:null,
                'total_qty'=>isset($orderingredient->total_qty) && trim($orderingredient->total_qty)!=''? $orderingredient->total_qty:null,
                'total_price'=>isset($orderingredient->total_price) && trim($orderingredient->total_price)!=''? $orderingredient->total_price:null,
                'remark_factory'=>isset($orderingredient->remark_factory)? $orderingredient->remark_factory:null,
                'ingredient_desc'=>isset($orderingredient->ingredient_desc)? $orderingredient->ingredient_desc:null));
        }

        Orderprocess::where('orderid',$id)->delete();
        foreach ($orderprocesses as $orderprocess)
        {
            Orderprocess::create(array('orderid'=>$id,'processid'=>$orderprocess->processid,
                'price'=>isset($orderprocess->price)&& trim($orderprocess->price)!='' ? $orderprocess->price:null));
        }

        return redirect('department6/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Orderprocess::where('orderid',$id)->delete();
        Orderpart::where('orderid',$id)->delete();
        Orderingredient::where('orderid',$id)->delete();
        Order::destroy($id);

        return redirect('department6/orders');
    }

    /**
     * export to excel/pdf.
     *
     * @return \Illuminate\Http\Response
     */
    public function byprocessexport($orderid)
    {
        //
//        dd(1111);
        Excel::load('exceltemplate/contractprocess.xlsx', function ($reader) use ($orderid) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $order = Order::find($orderid);
            if (isset($order))
            {
                $sheet->setCellValue('A8',  $order->customer_item_name);
                $sheet->setCellValue('B8',  $order->prod_description);
                $sheet->setCellValue('G8',  $order->prod_qty);
                $sheet->setCellValue('H8',  $order->process_taxcosts);
            }

        })->export('xlsx');
    }

    public function byfabircexport($orderid)
    {
        //
//        dd(1111);
        Excel::load('exceltemplate/contractfabric.xlsx', function ($reader) use ($orderid) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $orderparts=Orderpart::select('*')->where('orderid',$orderid)->get();
            if (isset($orderparts))
            {
                $detail_startrow = 8;
                $detail_row = $detail_startrow;
                $currentitemcount = 1;
                foreach ($orderparts as $orderpart)
                {

                    if ($currentitemcount > 1)
                    {
                        $sheet->insertNewRowBefore($detail_row, 1);
                    }
                    $sheet->setCellValue('A' . $detail_row, $orderpart->composition);
                    $sheet->setCellValue('B' . $detail_row, '同确认样');
                    $sheet->setCellValue('C' . $detail_row, $orderpart->valid_width);
                    $sheet->setCellValue('D' . $detail_row, $orderpart->edge_to_edge_width);
                    $sheet->setCellValue('E' . $detail_row, $orderpart->fabric_desc);
                    $sheet->setCellValue('G' . $detail_row, $orderpart->total_qty);
                    $sheet->setCellValue('H' . $detail_row, $orderpart->price);

                    $objValidation1 = $sheet->getCell('F' . $detail_row)->getDataValidation();
                    $objValidation1->setType('list')
                        ->setErrorStyle('information')
                        ->setAllowBlank(false)
                        ->setShowInputMessage(true)
                        ->setShowErrorMessage(true)
                        ->setShowDropDown(true)
                        ->setErrorTitle('输入的值有误')
                        ->setError('您输入的值不在下拉框列表内.')
                        ->setPromptTitle('')
                        ->setPrompt('')
                        ->setFormula1('"米,公斤"');

                    $sheet->setCellValue('I' . $detail_row, "=G".$detail_row."*H". $detail_row );
                    $sheet->setCellValue('J' . $detail_row, "=I".($detail_row+18)."+15");
                    $detail_row += 1;
                    $currentitemcount += 1;
//                    Log::info($detail_row);
                }

            }

        })->export('xlsx');
    }

    public function byingredientexport($orderid)
    {
        //
//        dd(1111);
        Excel::load('exceltemplate/contractingredient.xlsx', function ($reader) use ($orderid) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();


            $orderingredients=Orderingredient::select('*')->where('orderid',$orderid)->get();
            $order =Order::FindorFail($orderid);
            if (isset($orderingredients))
            {
                $detail_startrow = 8;
                $detail_row = $detail_startrow;
                $currentitemcount = 1;

                foreach ($orderingredients as $orderingredient)
                {

                    if ($currentitemcount > 1)
                    {
                        $sheet->insertNewRowBefore($detail_row, 1);
                    }
                    $sheet->setCellValue('A' . $detail_row, $orderingredient->ingredient->name);
                    $sheet->setCellValue('B' . $detail_row, $orderingredient->ingredient_desc);
                    $sheet->setCellValue('C' . $detail_row, $order->customer_item_name);
                    $sheet->setCellValue('D' . $detail_row, $order->UPC);
                    $sheet->setCellValue('E' . $detail_row, '只');
                    $sheet->setCellValue('F' . $detail_row, $orderingredient->total_qty);
                    $sheet->setCellValue('G' . $detail_row, $orderingredient->price);
                    $sheet->setCellValue('H' . $detail_row, "=G".$detail_row."*F". $detail_row);
                    $sheet->setCellValue('I' . $detail_row, "=H".($detail_row+18)."+15");
                    $sheet ->getStyle('I' . $detail_row)->getNumberFormat()->setFormatCode("yyyy-mm-dd");
//                    $sheet->setFormatCode(array('I'. $detail_row => 'yyyy-mm-dd'));
                    $detail_row += 1;
                    $currentitemcount += 1;
//                    Log::info($detail_row);
                }
                Log::info($detail_row);
                $sheet->setCellValue('F' . ($detail_row+1), "=SUM(F".$detail_startrow.":F". $detail_row.")");
                $sheet->setCellValue('H' . ($detail_row+1), "=SUM(H".$detail_startrow.":H". $detail_row.")");
            }

        })->export('xlsx');
    }
}
