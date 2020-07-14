<?php

namespace App\Http\Controllers\Department6;

use App\Models\Department6\Ingredient;
use App\Models\Department6\Ingredientdetail;
use App\Models\Department6\Inquiry_sheets;
use App\Models\Department6\Orderingredient;
use App\Models\Department6\Order;
use App\Models\Department6\Part;
use App\Models\Department6\Process;
use App\Models\Department6\Orderprocess;
use App\Models\Department6\Orderpart;
use App\Models\Department6\Processdetail;
use App\Models\Department6\Purchasedetail;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;

class Inquiry_sheetsController extends Controller
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
        $inquiry_sheets = $this->searchrequest($request)->paginate('10');

        return view('department6.inquiry_sheets.index', compact('inquiry_sheets', 'inputs'));

    }

    public function search(Request $request)
    {
        //
        $inputs = $request->all();

        //dd($inputs);
        $inquiry_sheets = $this->searchrequest($request)->paginate('10');

        return view('department6.inquiry_sheets.index', compact('inquiry_sheets','inputs'));
    }

    public function searchrequest($request)
    {
        $key = $request->input('key');


        $query = Inquiry_sheets::latest('created_at');

        if (strlen($key) > 0)
        {
            $query->where('supplier_stock_number', 'like', '%'.$key.'%');
        }



        $inquiry_sheets = $query->select('*');

        // $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();
        // dd($purchaseorders->pluck('id'));

        return $inquiry_sheets;
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
        return view('department6/inquiry_sheets/mcreate',compact('parts','processes','ingredients'));
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
//        dd($input);
//        Log::info($input);
//        Log::info(json_decode(json_decode($input['items_string1'])[0]));
        //        dd($input);
        $purchasedetails = json_decode($input['items_string1']);
        $ingredientdetails = json_decode($input['items_string2']);
        $processdetails = json_decode($input['items_string3']);

        $inquiry_sheet = Inquiry_sheets::create(array('customername'=>$input['customername'],
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
                          'purchase_outcosts'=>isset($input['purchase_outcosts'])? $input['purchase_outcosts']:null,
                          'total_outcosts'=>isset($input['total_outcosts'])? $input['total_outcosts']:null,
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
                          'exchange_rate'=>isset($input['exchange_rate'])? $input['exchange_rate']:null,
          ));
        $inquiry_sheetid=$inquiry_sheet->id;

        foreach ($purchasedetails as $purchasedetail) {
              Purchasedetail::create(array('inquiry_sheetid'=>$inquiry_sheetid,'partid'=>$purchasedetail->partid,
                  'fabric_desc'=>isset($purchasedetail->fabric_desc)? $purchasedetail->fabric_desc:null,
                  'composition'=>isset($purchasedetail->composition)? $purchasedetail->composition:null,
                  'valid_width'=>isset($purchasedetail->valid_width)? $purchasedetail->valid_width:null,
                  'edge_to_edge_width'=>isset($purchasedetail->edge_to_edge_width)? $purchasedetail->edge_to_edge_width:null,
                  'qty'=>isset($purchasedetail->qty) && trim($purchasedetail->qty)!=''? $purchasedetail->qty:null,
                  'price'=>isset($purchasedetail->price) && trim($purchasedetail->price) !=''? $purchasedetail->price:null,
                  'outprice'=>isset($purchasedetail->outprice) && trim($purchasedetail->outprice) !=''? $purchasedetail->outprice:null,
                  'total_qty'=>isset($purchasedetail->total_qty)&& trim($purchasedetail->total_qty) !=''? $purchasedetail->total_qty:null,
                  'total_price'=>isset($purchasedetail->total_price)&& trim($purchasedetail->total_price) !=''? $purchasedetail->total_price:null,
                  'total_outprice'=>isset($purchasedetail->total_outprice)&& trim($purchasedetail->total_outprice) !=''? $purchasedetail->total_outprice:null,
                  'factoryname'=>isset($purchasedetail->factoryname)? $purchasedetail->factoryname:null));
                    }
        foreach ($ingredientdetails as $ingredientdetail) {
            Ingredientdetail::create(array('inquiry_sheetid'=>$inquiry_sheetid,'ingredientid'=>$ingredientdetail->ingredientid,
                'qty'=>isset($ingredientdetail->qty) && trim($ingredientdetail->qty)!=''? $ingredientdetail->qty:null,
                'price'=>isset($ingredientdetail->price) && trim($ingredientdetail->price)!='' ? $ingredientdetail->price:null,
                'outprice'=>isset($ingredientdetail->outprice) && trim($ingredientdetail->outprice)!='' ? $ingredientdetail->outprice:null,
                'total_qty'=>isset($ingredientdetail->total_qty) && trim($ingredientdetail->total_qty)!=''? $ingredientdetail->total_qty:null,
                'total_price'=>isset($ingredientdetail->total_price) && trim($ingredientdetail->total_price)!=''? $ingredientdetail->total_price:null,
                'total_outprice'=>isset($ingredientdetail->total_outprice) && trim($ingredientdetail->total_outprice)!=''? $ingredientdetail->total_outprice:null,
                'remark_factory'=>isset($ingredientdetail->remark_factory)? $ingredientdetail->remark_factory:null,
                'ingredient_desc'=>isset($ingredientdetail->ingredient_desc)? $ingredientdetail->ingredient_desc:null));
        }
        foreach ($processdetails as $processdetail) {
            Processdetail::create(array('inquiry_sheetid'=>$inquiry_sheetid,'processid'=>$processdetail->processid,
                'price'=>isset($processdetail->price)&& trim($processdetail->price)!='' ? $processdetail->price:null));
        }
//        dd('创建成功.');
        return redirect('department6/inquiry_sheets');
    }

    public function copywinbidding($id)
    {
//        dd($id);
        $newingredientsheet=Inquiry_sheets::find($id)->replicate();
        $newingredientsheet->save();

        $oldingredientdetails=Ingredientdetail::where('inquiry_sheetid',$id);
        foreach($oldingredientdetails as $oldingredientdetail)
        {
            $newingredientdetail=$oldingredientdetail->replicate();
            $newingredientdetail->save();
        }

        $oldprocessdetails=Processdetail::where('inquiry_sheetid',$id);
        foreach($oldprocessdetails as $oldprocessdetail)
        {
            $newprocessdetail=$oldprocessdetail->replicate();
            $newprocessdetail->save();
        }

        $oldpurchasedetails=Purchasedetail::where('inquiry_sheetid',$id);
        foreach($oldpurchasedetails as $oldpurchasedetail)
        {
            $newpurchasedetail=$oldpurchasedetail->replicate();
            $newpurchasedetail->save();
        }

        return redirect('department6/inquiry_sheets');
        
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
        $inquiry_sheet = Inquiry_sheets::findOrFail($id);
        $parts=Part::select('*')->get();
        $processes=Process::select('*')->get();
        $ingredients=Ingredient::select('*')->get();
        $purchasedetails =$inquiry_sheet->purchasedetail();
        $ingredientdetails=$inquiry_sheet->ingredientdetail();
        $processdetails=$inquiry_sheet->processdetail();

        return view('department6/inquiry_sheets/edit',compact('inquiry_sheet','parts','processes','ingredients','purchasedetails','ingredientdetails','processdetails'));

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


        $input = $request->all();
        Log::info($input);

        $inquiry_sheet = Inquiry_sheets::findOrFail($id);
//        Log::info($order);
        $inquiry_sheet->customername=$input['customername'];
        $inquiry_sheet->prod_description=$input['prod_description'];
        $inquiry_sheet->prod_photo=$input['prod_photo'];
        $inquiry_sheet->prod_size=$input['prod_size'];
        $inquiry_sheet->customer_item_name=$input['customer_item_name'];
        $inquiry_sheet->supplier_stock_number=$input['supplier_stock_number'];
        $inquiry_sheet->UPC =$input['UPC'];
        $inquiry_sheet->prod_qty=$input['prod_qty'];
        $inquiry_sheet->FOB_SH_price=$input['FOB_SH_price'];
        $inquiry_sheet->ingredients_note=$input['ingredients_note'];
        $inquiry_sheet->packing_note=$input['packing_note'];
        $inquiry_sheet->remark_factory=$input['remark_factory'];
        $inquiry_sheet->process_costs=$input['process_costs'];
        $inquiry_sheet->purchase_costs=$input['purchase_costs'];
        $inquiry_sheet->purchase_outcosts=$input['purchase_outcosts'];
        $inquiry_sheet->process_taxcosts=$input['process_taxcosts'];
        $inquiry_sheet->total_costs=$input['total_costs'];
        $inquiry_sheet->total_costs=$input['total_outcosts'];
        $inquiry_sheet->remark=$input['remark'];
        $inquiry_sheet->length_carton=$input['length_carton'];
        $inquiry_sheet->width_carton=$input['width_carton'];
        $inquiry_sheet->high_carton=$input['high_carton'];
        $inquiry_sheet->qty_percarton=$input['qty_percarton'];
        $inquiry_sheet->vol_total=$input['vol_total'];
        $inquiry_sheet->qty_container=$input['qty_container'];
        $inquiry_sheet->inland_freight=$input['inland_freight'];
        $inquiry_sheet->arlington_ocean_freight=$input['arlington_ocean_freight'];
        $inquiry_sheet->atc_ocean_freight=$input['atc_ocean_freight'];
        $inquiry_sheet->risk_rate=$input['risk_rate'];
        $inquiry_sheet->fob_shanghai=$input['fob_shanghai'];
        $inquiry_sheet->import_rate=$input['import_rate'];
        $inquiry_sheet->arlington_ldp=$input['arlington_ldp'];
        $inquiry_sheet->atc_ldp=$input['atc_ldp'];
        $inquiry_sheet->process_tax=$input['process_tax'];
        $inquiry_sheet->exchange_rate=$input['exchange_rate'];
        $inquiry_sheet->save();

        $purchasedetails = json_decode($input['items_string1']);
        $ingredientdetails = json_decode($input['items_string2']);
        $processdetails = json_decode($input['items_string3']);


//        Log::info($orderprocesses);
//        dd(array_map('reset',$orderparts));

        Purchasedetail::where('inquiry_sheetid',$id)->delete();

        foreach ($purchasedetails as $purchasedetail)
        {
            Purchasedetail::create(array('inquiry_sheetid'=>$id,'partid'=>$purchasedetail->partid,
                'fabric_desc'=>isset($purchasedetail->fabric_desc)? $purchasedetail->fabric_desc:null,
                'composition'=>isset($purchasedetail->composition)? $purchasedetail->composition:null,
                'valid_width'=>isset($purchasedetail->valid_width)? $purchasedetail->valid_width:null,
                'edge_to_edge_width'=>isset($purchasedetail->edge_to_edge_width)? $purchasedetail->edge_to_edge_width:null,
                'qty'=>isset($purchasedetail->qty) && trim($purchasedetail->qty)!=''? $purchasedetail->qty:null,
                'price'=>isset($purchasedetail->price) && trim($purchasedetail->price) !=''? $purchasedetail->price:null,
                'outprice'=>isset($purchasedetail->outprice) && trim($purchasedetail->outprice) !=''? $purchasedetail->outprice:null,
                'total_qty'=>isset($purchasedetail->total_qty)&& trim($purchasedetail->total_qty) !=''? $purchasedetail->total_qty:null,
                'total_price'=>isset($purchasedetail->total_price)&& trim($purchasedetail->total_price) !=''? $purchasedetail->total_price:null,
                'total_outprice'=>isset($purchasedetail->total_outprice)&& trim($purchasedetail->total_outprice) !=''? $purchasedetail->total_outprice:null,
                'factoryname'=>isset($purchasedetail->factoryname)? $purchasedetail->factoryname:null));

        }

        Ingredientdetail::where('inquiry_sheetid',$id)->delete();
        foreach ($ingredientdetails as $ingredientdetail)
        {
            Ingredientdetail::create(array('inquiry_sheetid'=>$id,'ingredientid'=>$ingredientdetail->ingredientid,
                'qty'=>isset($ingredientdetail->qty) && trim($ingredientdetail->qty)!=''? $ingredientdetail->qty:null,
                'price'=>isset($ingredientdetail->price) && trim($ingredientdetail->price)!='' ? $ingredientdetail->price:null,
                'outprice'=>isset($ingredientdetail->outprice) && trim($ingredientdetail->outprice)!='' ? $ingredientdetail->outprice:null,
                'total_qty'=>isset($ingredientdetail->total_qty) && trim($ingredientdetail->total_qty)!=''? $ingredientdetail->total_qty:null,
                'total_price'=>isset($ingredientdetail->total_price) && trim($ingredientdetail->total_price)!=''? $ingredientdetail->total_price:null,
                'total_outprice'=>isset($ingredientdetail->total_outprice) && trim($ingredientdetail->total_outprice)!=''? $ingredientdetail->total_outprice:null,
                'remark_factory'=>isset($ingredientdetail->remark_factory)? $ingredientdetail->remark_factory:null,
                'ingredient_desc'=>isset($ingredientdetail->ingredient_desc)? $ingredientdetail->ingredient_desc:null));
        }

        Processdetail::where('inquiry_sheetid',$id)->delete();
        foreach ($processdetails as $processdetail)
        {
            Processdetail::create(array('inquiry_sheetid'=>$id,'processid'=>$processdetail->processid,
                'price'=>isset($processdetail->price)&& trim($processdetail->price)!='' ? $processdetail->price:null));
        }

        return redirect('department6/inquiry_sheets');
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
        Ingredientdetail::where('inquiry_sheetid',$id)->delete();
        Processdetail::where('inquiry_sheetid',$id)->delete();
        Purchasedetail::where('inquiry_sheetid',$id)->delete();
        Inquiry_sheets::destroy($id);

        return redirect('department6/inquiry_sheets');
    }

    public function export($inquiry_sheetid)
    {
        //
//        dd($inquiry_sheetid);
        Excel::load('exceltemplate/Quote.xlsx', function ($reader) use ($inquiry_sheetid) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $inquiry_sheet=Inquiry_sheets::where('id',$inquiry_sheetid)->first();
            $purchasedetails=$inquiry_sheet->purchasedetail;
            $ingredientdetails=$inquiry_sheet->ingredientdetail;
            $processdetails=$inquiry_sheet->processdetail;

//            dd($purchasedetails);
            $detail_startrow = 2;
            $detail_row = $detail_startrow;
            $process_row= $detail_startrow;

            $sheet->setCellValue('A' . $detail_row, $inquiry_sheet->customername);
            $sheet->setCellValue('B' . $detail_row, $inquiry_sheet->prod_description);
            $sheet->setCellValue('D' . $detail_row, $inquiry_sheet->prod_size);
            $sheet->setCellValue('E' . $detail_row, $inquiry_sheet->customer_item_name);
            $sheet->setCellValue('F' . $detail_row, $inquiry_sheet->supplier_stock_number);
            $sheet->setCellValue('G' . $detail_row, $inquiry_sheet->UPC);
            $sheet->setCellValue('H' . $detail_row, $inquiry_sheet->FOB_SH_price);
            $sheet->setCellValue('I' . $detail_row, $inquiry_sheet->fob_shanghai);
            $sheet->setCellValue('J' . $detail_row, $inquiry_sheet->ingredients_note);
            $sheet->setCellValue('K' . $detail_row, $inquiry_sheet->packing_note);
            $sheet->setCellValue('V' . $detail_row, $inquiry_sheet->remark_factory);
            $sheet->setCellValue('Y' . $detail_row, $inquiry_sheet->process_taxcosts);
            $sheet->setCellValue('Z' . $detail_row, $inquiry_sheet->total_costs);
            $sheet->setCellValue('AA' . $detail_row, $inquiry_sheet->total_outcosts);
            $sheet->setCellValue('AB' . $detail_row, $inquiry_sheet->remark);
            $sheet->setCellValue('AC' . $detail_row, $inquiry_sheet->length_carton);
            $sheet->setCellValue('AD' . $detail_row, $inquiry_sheet->width_carton);
            $sheet->setCellValue('AE' . $detail_row, $inquiry_sheet->high_carton);
            $sheet->setCellValue('AF' . $detail_row, $inquiry_sheet->qty_percarton);
            $sheet->setCellValue('AG' . $detail_row, $inquiry_sheet->vol_total);
            $sheet->setCellValue('AH' . $detail_row, $inquiry_sheet->qty_container);
            $sheet->setCellValue('AI' . $detail_row, $inquiry_sheet->inland_freight);
            $sheet->setCellValue('AJ' . $detail_row, $inquiry_sheet->arlington_ocean_freight);
            $sheet->setCellValue('AK' . $detail_row, $inquiry_sheet->atc_ocean_freight);
            $sheet->setCellValue('AL' . $detail_row, $inquiry_sheet->risk_rate);
            $sheet->setCellValue('AM' . $detail_row, $inquiry_sheet->fob_shanghai);
            $sheet->setCellValue('AN' . $detail_row, $inquiry_sheet->import_rate);
            $sheet->setCellValue('AO' . $detail_row, $inquiry_sheet->arlington_ldp);
            $sheet->setCellValue('AP' . $detail_row, $inquiry_sheet->arlington_ldp);

            if(isset($purchasedetails)) {
                foreach ($purchasedetails as $purchasedetail) {

                    $sheet->setCellValue('L' . $detail_row, $purchasedetail->part->name);
                    $sheet->setCellValue('M' . $detail_row, $purchasedetail->fabric_desc);
                    $sheet->setCellValue('N' . $detail_row, $purchasedetail->composition);
                    $sheet->setCellValue('O' . $detail_row, $purchasedetail->valid_width);
                    $sheet->setCellValue('P' . $detail_row, $purchasedetail->edge_to_edge_width);
                    $sheet->setCellValue('Q' . $detail_row, $purchasedetail->qty);
                    $sheet->setCellValue('R' . $detail_row, $purchasedetail->price);
                    $sheet->setCellValue('S' . $detail_row, $purchasedetail->outprice);
                    $sheet->setCellValue('T' . $detail_row, $inquiry_sheet->prod_qty);
                    $sheet->setCellValue('U' . $detail_row, $purchasedetail->total_qty);
                    $detail_row++;
                }
            }

            if(isset($ingredientdetails)) {
                foreach ($ingredientdetails as $ingredientdetail) {

                    $sheet->setCellValue('L' . $detail_row, $ingredientdetail->ingredientpart->name);
                    $sheet->setCellValue('Q' . $detail_row, $ingredientdetail->qty);
                    $sheet->setCellValue('R' . $detail_row, $ingredientdetail->price);
                    $sheet->setCellValue('S' . $detail_row, $ingredientdetail->outprice);
                    $sheet->setCellValue('T' . $detail_row, $inquiry_sheet->prod_qty);
                    $sheet->setCellValue('U' . $detail_row, $ingredientdetail->total_qty);
                    $detail_row++;
                }
            }

            if(isset($processdetails)) {
                foreach ($processdetails as $processdetail) {

                    $sheet->setCellValue('W' . $process_row, $processdetail->process->name);
                    $sheet->setCellValue('X' . $process_row, $processdetail->price);
                    $process_row++;
                }

            }
        })->export('xlsx');
    }
    /***
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 中标
     */
    public function winbidding($id)
    {
        //

        $inquiry_sheet = Inquiry_sheets::FindOrFail($id);
        $purchasedetails = Purchasedetail::where('inquiry_sheetid',$id)->get();
        $ingredietdetails = Ingredientdetail::where('inquiry_sheetid',$id)->get();
        $processdetails = Processdetail::where('inquiry_sheetid',$id)->get();
//        dd($purchasedetails->count());
        $order=Order::create(array('customername'=>$inquiry_sheet->customername,
            'prod_description'=>isset($inquiry_sheet->prod_description)? $inquiry_sheet->prod_description:null,
            'prod_photo'=>$inquiry_sheet->prod_photo,
            'prod_size'=>isset($inquiry_sheet->prod_size)? $inquiry_sheet->prod_size:null,
            'customer_item_name'=>isset($inquiry_sheet->customer_item_name)? $inquiry_sheet->customer_item_name:null,
            'supplier_stock_number'=>$inquiry_sheet->supplier_stock_number,
            'UPC'=>isset($inquiry_sheet->UPC)? $inquiry_sheet->UPC:null,
            'prod_qty'=>isset($inquiry_sheet->prod_qty)? $inquiry_sheet->prod_qty:null,
            'FOB_SH_price'=>isset($inquiry_sheet->FOB_SH_price)? $inquiry_sheet->FOB_SH_price:null,
            'ingredients_note'=>isset($inquiry_sheet->ingredients_note)? $inquiry_sheet->ingredients_note:null,
            'packing_note'=>isset($inquiry_sheet->packing_note)? $inquiry_sheet->packing_note:null,
            'remark_factory'=>isset($inquiry_sheet->remark_factory)? $inquiry_sheet->remark_factory:null,
            'process_costs'=>isset($inquiry_sheet->process_costs)? $inquiry_sheet->process_costs:null,
            'purchase_costs'=>isset($inquiry_sheet->purchase_costs)? $inquiry_sheet->purchase_costs:null,
            'purchase_outcosts'=>isset($inquiry_sheet->purchase_outcosts)? $inquiry_sheet->purchase_outcosts:null,
            'process_taxcosts'=>isset($inquiry_sheet->process_taxcosts)? $inquiry_sheet->process_taxcosts:null,
            'total_costs'=>isset($inquiry_sheet->total_costs)? $inquiry_sheet->total_costs:null,
            'total_outcosts'=>isset($inquiry_sheet->total_outcosts)? $inquiry_sheet->total_outcosts:null,
            'remark'=>isset($inquiry_sheet->remark)? $inquiry_sheet->remark:null,
            'length_carton'=>isset($inquiry_sheet->length_carton)? $inquiry_sheet->length_carton:null,
            'width_carton'=>isset($inquiry_sheet->width_carton)? $inquiry_sheet->width_carton:null,
            'high_carton'=>isset($inquiry_sheet->high_carton)? $inquiry_sheet->high_carton:null,
            'qty_percarton'=>isset($inquiry_sheet->qty_percarton)? $inquiry_sheet->qty_percarton:null,
            'vol_total'=>isset($inquiry_sheet->vol_total)? $inquiry_sheet->vol_total:null,
            'qty_container'=>isset($inquiry_sheet->qty_container)? $inquiry_sheet->qty_container:null,
            'inland_freight'=>isset($inquiry_sheet->inland_freight)? $inquiry_sheet->inland_freight:null,
            'arlington_ocean_freight'=>isset($inquiry_sheet->arlington_ocean_freight)? $inquiry_sheet->arlington_ocean_freight:null,
            'atc_ocean_freight'=>isset($inquiry_sheet->atc_ocean_freight)? $inquiry_sheet->atc_ocean_freight:null,
            'risk_rate'=>isset($inquiry_sheet->risk_rate)? $inquiry_sheet->risk_rate:null,
            'fob_shanghai'=>isset($inquiry_sheet->fob_shanghai)? $inquiry_sheet->fob_shanghai:null,
            'import_rate'=>isset($inquiry_sheet->import_rate)? $inquiry_sheet->import_rate:null,
            'arlington_ldp'=>isset($inquiry_sheet->arlington_ldp)? $inquiry_sheet->arlington_ldp:null,
            'atc_ldp'=>isset($inquiry_sheet->atc_ldp)? $inquiry_sheet->atc_ldp:null,
            'process_tax'=>isset($inquiry_sheet->process_tax)? $inquiry_sheet->process_tax:null,
            'exchange_rate'=>isset($inquiry_sheet->exchange_rate)? $inquiry_sheet->exchange_rate:null,
        ));

        $orderid=$order->id;
////        dd($mcitempurchase);
//
//        // create mcitempurchaseitems

//        $totaltotalprice = 0.0;
        foreach ($purchasedetails as $purchasedetail) {
//            dd($purchasedetail);
            Orderpart::create(array('orderid'=>$orderid,'partid'=>$purchasedetail->partid,
                'fabric_desc'=>isset($purchasedetail->fabric_desc)? $purchasedetail->fabric_desc:null,
                'composition'=>isset($purchasedetail->composition)? $purchasedetail->composition:null,
                'valid_width'=>isset($purchasedetail->valid_width)? $purchasedetail->valid_width:null,
                'edge_to_edge_width'=>isset($purchasedetail->edge_to_edge_width)? $purchasedetail->edge_to_edge_width:null,
                'qty'=>isset($purchasedetail->qty) && trim($purchasedetail->qty)!=''? $purchasedetail->qty:null,
                'price'=>isset($purchasedetail->price) && trim($purchasedetail->price) !=''? $purchasedetail->price:null,
                'outprice'=>isset($purchasedetail->outprice) && trim($purchasedetail->outprice) !=''? $purchasedetail->outprice:null,
                'total_qty'=>isset($purchasedetail->total_qty)&& trim($purchasedetail->total_qty) !=''? $purchasedetail->total_qty:null,
                'total_price'=>isset($purchasedetail->total_price)&& trim($purchasedetail->total_price) !=''? $purchasedetail->total_price:null,
                'total_outprice'=>isset($purchasedetail->total_outprice)&& trim($purchasedetail->total_outprice) !=''? $purchasedetail->total_outprice:null,
                'factoryname'=>isset($purchasedetail->factoryname)? $purchasedetail->factoryname:null));
        }
        foreach ($ingredietdetails as $ingredietdetail) {
            Orderingredient::create(array('orderid'=>$orderid,'ingredientid'=>$ingredietdetail->ingredientid,
                'qty'=>isset($ingredietdetail->qty) && trim($ingredietdetail->qty)!=''? $ingredietdetail->qty:null,
                'price'=>isset($ingredietdetail->price) && trim($ingredietdetail->price)!='' ? $ingredietdetail->price:null,
                'outprice'=>isset($ingredietdetail->outprice) && trim($ingredietdetail->outprice)!='' ? $ingredietdetail->outprice:null,
                'total_qty'=>isset($ingredietdetail->total_qty) && trim($ingredietdetail->total_qty)!=''? $ingredietdetail->total_qty:null,
                'total_price'=>isset($ingredietdetail->total_price) && trim($ingredietdetail->total_price)!=''? $ingredietdetail->total_price:null,
                'total_outprice'=>isset($ingredietdetail->total_outprice) && trim($ingredietdetail->total_outprice)!=''? $ingredietdetail->total_outprice:null,
                'remark_factory'=>isset($ingredietdetail->remark_factory)? $ingredietdetail->remark_factory:null,
                'ingredient_desc'=>isset($ingredietdetail->ingredient_desc)? $ingredietdetail->ingredient_desc:null));
        }
        foreach ($processdetails as $processdetail) {
            Orderprocess::create(array('orderid'=>$orderid,'processid'=>$processdetail->processid,
                'price'=>isset($processdetail->price)&& trim($processdetail->price)!='' ? $processdetail->price:null));
        }

        return redirect('department6/inquiry_sheets');
    }
}
