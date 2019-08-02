<?php

namespace App\Http\Controllers\Purchaseorderc;

use App\Models\Purchaseorderc\Poheadc;
use App\Models\Purchaseorderc\Poitemc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel, Log;

class PurchaseordercController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $inputs = $request->all();
        $purchaseorders = $this->searchrequest($request)->paginate(10);
        return view('purchaseorderc.purchaseordercs.index', compact('purchaseorders', 'inputs'));
//        $purchaseorders = Poheadc::latest('created_at')->paginate(10);
//        return view('purchaseorderc.purchaseordercs.index', compact('purchaseorders'));
    }

    public function search(Request $request)
    {
//        $key = $request->input('key');
        $inputs = $request->all();
        $purchaseorders = $this->searchrequest($request)->paginate(10);

        return view('purchaseorderc.purchaseordercs.index', compact('purchaseorders', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Poheadc::latest('created_at');

        if ($request->has('key') && strlen($request->get('key')) > 0)
        {
            $key = $request->get('key');
            $query->where(function ($query) use ($key) {
                $query->where('purchase_order_number', 'like', '%' . $key . '%')
                    ->orWhere('supplier_name', 'like', '%' . $key . '%');
            });

//            $db_driver = config('database.connections.' . env('DB_CONNECTION', 'mysql') . '.driver');
//            if ($db_driver == "sqlsrv")
//                $query->where(function ($query) use ($key) {
//                    $query->where('customer_name', 'like', '%' . $key . '%')
//                        ->orWhere('invoice_number', 'like', '%' . $key . '%')
//                        ->orWhere('contract_number', 'like', '%' . $key . '%')
//                        ->orWhere('bill_no', 'like', '%' . $key . '%')
//                        ->orWhere('ship_company', 'like', '%' . $key . '%')
//                        ->orWhere('customs_no', 'like', '%' . $key . '%');
//                });
//            elseif ($db_driver == "pgsql")
//                $query->where(function ($query) use ($key) {
//                    $query->where('customer_name', 'ilike', '%' . $key . '%')
//                        ->orWhere('invoice_number', 'ilike', '%' . $key . '%')
//                        ->orWhere('contract_number', 'ilike', '%' . $key . '%')
//                        ->orWhere('bill_no', 'ilike', '%' . $key . '%')
//                        ->orWhere('ship_company', 'ilike', '%' . $key . '%')
//                        ->orWhere('customs_no', 'ilike', '%' . $key . '%');
//                });
        }

        if ($request->has('createdatestart') && $request->has('createdateend'))
        {
            $enddate = Carbon::parse($request->input('createdateend'))->addDay();
            $query->whereRaw('created_at between \'' . $request->input('createdatestart') . '\' and \'' . $enddate->toDateString() . '\'');


        }

        if ($request->has('etdstart') && $request->has('etdend'))
        {
//            $enddate = Carbon::parse($request->input('etdend'))->addDay();
            $query->whereRaw('etd between \'' . $request->input('etdstart') . '\' and \'' . $request->input('etdend') . '\'');

        }

        if ($request->has('amount_for_customer') && strlen($request->get('amount_for_customer')) > 0)
        {
            $query->where('amount_for_customer', $request->get('amount_for_customer_opt'), $request->get('amount_for_customer'));
        }

        if ($request->has('invoice_number_type') && strlen($request->get('invoice_number_type')) > 0)
        {
            $query->where('invoice_number', 'like', '%' . $request->get('invoice_number_type') . '%');
        }




        $items = $query->select('*');
//        dd($shipments);

        // $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();
        // dd($purchaseorders->pluck('id'));

        return $items;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $purchaseorder = Poheadc::findOrFail($id);
        $purchaseorder->readed = true;
        $purchaseorder->save();
        return view('purchaseorderc.purchaseordercs.show', compact('purchaseorder'));
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
        $purchaseorder = Poheadc::findOrFail($id);
        return view('purchaseorderc.purchaseordercs.edit', compact('purchaseorder'));
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
    }

    public function detail($id)
    {
        $poitems = Poitemc::where('poheadc_id', $id)->orderBy('fabric_sequence_no')->paginate(10);
        return view('purchaseorderc.poitemcs.index', compact('poitems', 'id'));
    }

    public function seperate($id)
    {
        $purchaseorder = Poheadc::findOrFail($id);
        return view('purchaseorderc.purchaseordercs.seperate', compact('purchaseorder'));
    }

    public function exportpo($id)
    {
        Excel::load('exceltemplate/CustomerPO.xlsx', function ($reader) use ($id) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $poheadc = Poheadc::find($id);
            if (isset($poheadc))
            {
                $data_interchange_datetime = Carbon::parse($poheadc->data_interchange_datetime);
                $sheet->setCellValue('D5', $data_interchange_datetime->format('M d, Y'));
                $sheet->setCellValue('G5', $data_interchange_datetime->format('M d, Y'));
                $sheet->setCellValue('D6', $poheadc->salesman_name);
                $sheet->setCellValue('G6', $poheadc->purchase_order_number);
                $sheet->setCellValue('G10', $poheadc->supplier_name);

                $totalprice = 0.0;
                $totalquantity = 0;
                $detail_startrow = 34;
                $detail_row = $detail_startrow;
                $currentitemcount = 1;
                foreach ($poheadc->poitemcs as $poitemc)
                {
                    if ($currentitemcount > 1)
                    {
                        $sheet->insertNewRowBefore($detail_row, 14);

                        $sheet->setCellValue('B' . $detail_row, $sheet->getCell('B'.($detail_row-14))->getValue());
                        $sheet->setCellValue('E' . $detail_row, $sheet->getCell('E'.($detail_row-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+1), $sheet->getCell('B'.($detail_row+1-14))->getValue());
                        $sheet->setCellValue('D' . ($detail_row+1), $sheet->getCell('D'.($detail_row+1-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+2), $sheet->getCell('B'.($detail_row+2-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+3), $sheet->getCell('B'.($detail_row+3-14))->getValue());
                        $sheet->setCellValue('C' . ($detail_row+3), $sheet->getCell('C'.($detail_row+3-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+4), $sheet->getCell('B'.($detail_row+4-14))->getValue());
                        $sheet->setCellValue('E' . ($detail_row+4), $sheet->getCell('E'.($detail_row+4-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+5), $sheet->getCell('B'.($detail_row+5-14))->getValue());
                        $sheet->setCellValue('E' . ($detail_row+5), $sheet->getCell('E'.($detail_row+5-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+6), $sheet->getCell('B'.($detail_row+6-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+7), $sheet->getCell('B'.($detail_row+7-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+8), $sheet->getCell('B'.($detail_row+8-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+9), $sheet->getCell('B'.($detail_row+9-14))->getValue());
                        $sheet->setCellValue('B' . ($detail_row+10), $sheet->getCell('B'.($detail_row+10-14))->getValue());
                        $sheet->setCellValue('E' . ($detail_row+11), $sheet->getCell('E'.($detail_row+11-14))->getValue());
                    }

                    $totalprice += $poitemc->quantity * $poitemc->unit_price;
                    $totalquantity += $poitemc->quantity;

                    $sheet->setCellValue('A' . $detail_row, $poitemc->fabric_sequence_no);
                    $sheet->setCellValue('D' . $detail_row, $poitemc->material_code);
                    $fabric_description = trim($poitemc->fabric_description);
                    $sheet->setCellValue('D' . ($detail_row+2), substr($fabric_description, 0, strpos($fabric_description, "::")));
                    $sheet->setCellValue('D' . ($detail_row+5), $poitemc->construction);
                    $sheet->setCellValue('G' . ($detail_row+2), substr($fabric_description, strpos($fabric_description, "::") + 2, strrpos($fabric_description, "::") - strpos($fabric_description, "::") - 2));
                    $sheet->setCellValue('D' . ($detail_row+6), $poitemc->yarn_count);
                    $sheet->setCellValue('D' . ($detail_row+7), $poitemc->fabric_width);
                    $sheet->setCellValue('G' . ($detail_row+11), $poitemc->unit_price);

                    $detail_row += 14;
                    $currentitemcount += 1;
                }
                $sheet->setCellValue('G29', 'USD ' . $totalprice);
                $sheet->setCellValue('G30', 'USD ' . $totalprice);

                $detail_startrow = 53 + ($currentitemcount-2) * 14;
                $detail_row = $detail_startrow;
                $currentitemcount = 1;
                foreach ($poheadc->poitemcs as $poitemc)
                {
                    if ($currentitemcount > 1)
                    {
                        $sheet->insertNewRowBefore($detail_row, 1);
                    }

                    $sheet->setCellValue('A' . $detail_row, $poitemc->fabric_sequence_no);
                    Log::info('D' . $detail_row . ':' . $poitemc->color_desc1);
                    $sheet->setCellValue('D' . $detail_row, $poitemc->color_desc1);
                    $sheet->setCellValue('E' . $detail_row, $poitemc->quantity);
                    $shipment_date = Carbon::parse($poitemc->shipment_date);
                    $sheet->setCellValue('G' . $detail_row, $shipment_date->format('M d, Y'));

                    $detail_row += 1;
                    $currentitemcount += 1;
                }
                $currentrow = $detail_startrow + 2 + ($currentitemcount-2) * 1;
                Log::info('E' . $currentrow . ', totalquantity:' . $totalquantity);
                $sheet->setCellValue('E' . $currentrow, $totalquantity);
                $sheet->setCellValue('G' . $currentrow, 'Line amount USD ' . $totalprice);

//                $poitems = $poheadc->poitems;
//                foreach ($poitems as $poitem)
//                {
//                    if ($currentitemcount > 1)
//                    {
//                        $sheet->insertNewRowBefore($detail_row, 5);
//                    }
//                    $sheet->setCellValue('A' . $detail_row, $poitem->chinesedescrip);
//                    $fabric_description = trim($poitem->poitemc->fabric_description);
//                    $sheet->setCellValue('A' . ($detail_row+1), substr($fabric_description, 0, strpos($fabric_description, "::")));
//                    $sheet->setCellValue('B' . ($detail_row+1), $poitem->poitemc->yarn_count . " " . $poitem->poitemc->construction . " " . $poitem->poitemc->fabric_width);
//                    $sheet->setCellValue('F' . ($detail_row+1), $data_interchange_datetime->copy()->addDay(30)->format('Y.m.d'));
//                    $sheet->setCellValue('A' . ($detail_row+2), substr($fabric_description, strpos($fabric_description, "::") + 2, strrpos($fabric_description, "::") - strpos($fabric_description, "::") - 2));
//                    $sheet->setCellValue('B' . ($detail_row+3), $poitem->poitemc->color_desc1);
//                    $sheet->setCellValue('C' . ($detail_row+3), $poitem->quantity);
//                    $sheet->setCellValue('D' . ($detail_row+3), $poitem->unitprice);
//                    $sheet->setCellValue('E' . ($detail_row+3), "=C".($detail_row+3)."*D".($detail_row+3));
//
//                    $detail_row += 5;
//                    $currentitemcount += 1;
//                    Log::info($detail_row);
//                }



            }


        })->export('xlsx');
    }
}
