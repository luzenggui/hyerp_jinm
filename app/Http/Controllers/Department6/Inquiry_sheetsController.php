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
use Log;

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
        Log::info($input);
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
////        dd($mcitempurchase);
//
//        // create mcitempurchaseitems

//        $totaltotalprice = 0.0;
        foreach ($purchasedetails as $purchasedetail) {
              Purchasedetail::create(array('inquiry_sheetid'=>$inquiry_sheetid,'partid'=>$purchasedetail->partid,
                  'fabric_desc'=>isset($purchasedetail->fabric_desc)? $purchasedetail->fabric_desc:null,
                  'composition'=>isset($purchasedetail->composition)? $purchasedetail->composition:null,
                  'valid_width'=>isset($purchasedetail->valid_width)? $purchasedetail->valid_width:null,
                  'edge_to_edge_width'=>isset($purchasedetail->edge_to_edge_width)? $purchasedetail->edge_to_edge_width:null,
                  'qty'=>isset($purchasedetail->qty) && trim($purchasedetail->qty)!=''? $purchasedetail->qty:null,
                  'price'=>isset($purchasedetail->price) && trim($purchasedetail->price) !=''? $purchasedetail->price:null,
                  'total_qty'=>isset($purchasedetail->total_qty)&& trim($purchasedetail->total_qty) !=''? $purchasedetail->total_qty:null,
                  'total_price'=>isset($purchasedetail->total_price)&& trim($purchasedetail->total_price) !=''? $purchasedetail->total_price:null,
                  'factoryname'=>isset($purchasedetail->factoryname)? $purchasedetail->factoryname:null));
                    }
        foreach ($ingredientdetails as $ingredientdetail) {
            Ingredientdetail::create(array('inquiry_sheetid'=>$inquiry_sheetid,'ingredientid'=>$ingredientdetail->ingredientid,
                'qty'=>isset($ingredientdetail->qty) && trim($ingredientdetail->qty)!=''? $ingredientdetail->qty:null,
                'price'=>isset($ingredientdetail->price) && trim($ingredientdetail->price)!='' ? $ingredientdetail->price:null,
                'total_qty'=>isset($ingredientdetail->total_qty) && trim($ingredientdetail->total_qty)!=''? $ingredientdetail->total_qty:null,
                'total_price'=>isset($ingredientdetail->total_price) && trim($ingredientdetail->total_price)!=''? $ingredientdetail->total_price:null,
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
        $inquiry_sheet->process_taxcosts=$input['process_taxcosts'];
        $inquiry_sheet->total_costs=$input['total_costs'];
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
                'total_qty'=>isset($purchasedetail->total_qty)&& trim($purchasedetail->total_qty) !=''? $purchasedetail->total_qty:null,
                'total_price'=>isset($purchasedetail->total_price)&& trim($purchasedetail->total_price) !=''? $purchasedetail->total_price:null,
                'factoryname'=>isset($purchasedetail->factoryname)? $purchasedetail->factoryname:null));

        }

        Ingredientdetail::where('inquiry_sheetid',$id)->delete();
        foreach ($ingredientdetails as $ingredientdetail)
        {
            Ingredientdetail::create(array('inquiry_sheetid'=>$id,'ingredientid'=>$ingredientdetail->ingredientid,
                'qty'=>isset($ingredientdetail->qty) && trim($ingredientdetail->qty)!=''? $ingredientdetail->qty:null,
                'price'=>isset($ingredientdetail->price) && trim($ingredientdetail->price)!='' ? $ingredientdetail->price:null,
                'total_qty'=>isset($ingredientdetail->total_qty) && trim($ingredientdetail->total_qty)!=''? $ingredientdetail->total_qty:null,
                'total_price'=>isset($ingredientdetail->total_price) && trim($ingredientdetail->total_price)!=''? $ingredientdetail->total_price:null,
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
            'process_taxcosts'=>isset($inquiry_sheet->process_taxcosts)? $inquiry_sheet->process_taxcosts:null,
            'total_costs'=>isset($inquiry_sheet->total_costs)? $inquiry_sheet->total_costs:null,
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
                'total_qty'=>isset($purchasedetail->total_qty)&& trim($purchasedetail->total_qty) !=''? $purchasedetail->total_qty:null,
                'total_price'=>isset($purchasedetail->total_price)&& trim($purchasedetail->total_price) !=''? $purchasedetail->total_price:null,
                'factoryname'=>isset($purchasedetail->factoryname)? $purchasedetail->factoryname:null));
        }
        foreach ($ingredietdetails as $ingredietdetail) {
            Orderingredient::create(array('orderid'=>$orderid,'ingredientid'=>$ingredietdetail->ingredientid,
                'qty'=>isset($ingredietdetail->qty) && trim($ingredietdetail->qty)!=''? $ingredietdetail->qty:null,
                'price'=>isset($ingredietdetail->price) && trim($ingredietdetail->price)!='' ? $ingredietdetail->price:null,
                'total_qty'=>isset($ingredietdetail->total_qty) && trim($ingredietdetail->total_qty)!=''? $ingredietdetail->total_qty:null,
                'total_price'=>isset($ingredietdetail->total_price) && trim($ingredietdetail->total_price)!=''? $ingredietdetail->total_price:null,
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
