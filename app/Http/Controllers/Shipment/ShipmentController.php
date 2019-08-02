<?php

namespace App\Http\Controllers\Shipment;

use App\Mail\FileUploaded;
use App\Models\Shipment\Shipment;
use App\Models\Shipment\Shipmentattachment;
use App\Models\Shipment\Shipmentattachmentrecord;
use App\Models\Shipment\Shipmentitem;
use App\Models\Shipment\Userforwarder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel, Log;
use Auth, Mail, Storage;

class ShipmentController extends Controller
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
        $shipments = $this->searchrequest($request)->paginate(10);
//        $shipments = Shipment::latest('created_at')->paginate(15);
        return view('shipment.shipments.index', compact('shipments', 'inputs'));
    }

    public function filemonitor(Request $request)
    {
        //
        $inputs = $request->all();
        $shipments = $this->searchrequest($request)->paginate(10);
//        $shipments = Shipment::latest('created_at')->paginate(15);
        return view('shipment.shipments.filemonitor', compact('shipments', 'inputs'));
    }

    public function shipmenttracking(Request $request)
    {
        //
        $inputs = $request->all();
        $shipments = $this->searchrequest($request)->paginate(10);
//        $shipments = Shipment::latest('created_at')->paginate(15);
        return view('shipment.shipments.shipmenttracking', compact('shipments', 'inputs'));
    }

    public function search(Request $request)
    {
        // dd(substr($request->header('referer'), strlen($request->header('origin'))));
        // dd($request->header('origin'));
        // dd($request->header('referer'));
        // dd($request->server('HTTP_REFERER'));

        // $key = $request->input('key');
        // $approvalstatus = $request->input('approvalstatus');

        // $supplier_ids = [];
        // $purchaseorder_ids = [];
        // if (strlen($key) > 0)
        // {
        //     $supplier_ids = DB::connection('sqlsrv')->table('vsupplier')->where('name', 'like', '%'.$key.'%')->pluck('id');
        //     $purchaseorder_ids = DB::connection('sqlsrv')->table('vpurchaseorder')->where('descrip', 'like', '%'.$key.'%')->pluck('id');
        // }

        // $query = Paymentrequest::latest('created_at');

        // if (strlen($key) > 0)
        // {
        //     $query->whereIn('supplier_id', $supplier_ids)
        //         ->orWhereIn('pohead_id', $purchaseorder_ids);
        // }

        // if ($approvalstatus <> '')
        // {
        //     if ($approvalstatus == "1")
        //         $query->where('approversetting_id', '>', '0');
        //     else
        //         $query->where('approversetting_id', $approvalstatus);
        // }

        // $paymentrequests = $query->paginate(10);

        $key = $request->input('key');
        $inputs = $request->all();
        $shipments = $this->searchrequest($request)->paginate(10);
//        $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();

        return view('shipment.shipments.index', compact('shipments', 'inputs'));
    }

    public function searchfilemonitor(Request $request)
    {
        $inputs = $request->all();
        $shipments = $this->searchrequest($request)->paginate(10);
//        $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();

        return view('shipment.shipments.filemonitor', compact('shipments', 'inputs'));
    }

    public function searchshipmenttracking(Request $request)
    {
        $inputs = $request->all();
        $shipments = $this->searchrequest($request)->paginate(10);
//        $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();

        return view('shipment.shipments.shipmenttracking', compact('shipments', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Shipment::orderBy('invoice_number', 'desc');

        if ($request->has('key') && strlen($request->get('key')) > 0)
        {
            $key = $request->get('key');

            $db_driver = config('database.connections.' . env('DB_CONNECTION', 'mysql') . '.driver');
            if ($db_driver == "sqlsrv")
                $query->where(function ($query) use ($key) {
                    $query->where('customer_name', 'like', '%' . $key . '%')
                        ->orWhere('invoice_number', 'like', '%' . $key . '%')
                        ->orWhere('contract_number', 'like', '%' . $key . '%')
                        ->orWhere('bill_no', 'like', '%' . $key . '%')
                        ->orWhere('ship_company', 'like', '%' . $key . '%')
                        ->orWhere('customs_no', 'like', '%' . $key . '%');
                });
            elseif ($db_driver == "pgsql")
                $query->where(function ($query) use ($key) {
                    $query->where('customer_name', 'ilike', '%' . $key . '%')
                        ->orWhere('invoice_number', 'ilike', '%' . $key . '%')
                        ->orWhere('contract_number', 'ilike', '%' . $key . '%')
                        ->orWhere('bill_no', 'ilike', '%' . $key . '%')
                        ->orWhere('ship_company', 'ilike', '%' . $key . '%')
                        ->orWhere('customs_no', 'ilike', '%' . $key . '%');
                });
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

        if (Auth::user()->isForwarder())
        {
            $forwarders = Userforwarder::where('user_id', Auth::user()->id)->pluck('forwarder');
            $query->whereIn('forwarder', $forwarders);
        }



        $shipments = $query->select('*');
//        dd($shipments);

        // $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();
        // dd($purchaseorders->pluck('id'));

        return $shipments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('shipment.shipments.create');
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
        $this->validate($request, [
            'issue_blank' => 'required',
        ]);
        $input = $request->all();
        $shipment = Shipment::create($input);


        return redirect('shipment/shipments');
    }

    public function import()
    {
        //
        return view('shipment.shipments.import');
    }

    public function importstore(Request $request)
    {
        //
        $input = $request->all();
        $file = $request->file('file');
//        $file = array_get($input,'file');
        $excel = [];
//        Log::info($file->getPathName());
//        Log::info($file->getRealPath());
//        dd($file->public_path());
//        Log::info($request->getSession().getServletContext()->getReadPath("/xx"));

        // !! set config/excel.php
        // 'force_sheets_collection' => true,   // !!
        Excel::load($file->getRealPath(), function ($reader) use (&$excel) {
            $reader->each(function ($sheet) use (&$reader) {
//                Log::info('sheet');
//                Log::info($sheet);
                $rowindex = 2;
                $shipment = null;
                $sheet->each(function ($row) use (&$rowindex, &$shipment, &$reader) {
                    Log::info($row);
                    if ($rowindex > 3)
                    {
                        Log::info($rowindex);
                        Log::info($row);
                        $input = array_values($row->toArray());
//                        dd($input);
                        if (count($input) >= 74)
                        {
                            if (!empty($input[3]))
                            {
                                $shipment = Shipment::where('invoice_number', $input[3])->first();
                                if (!isset($shipment))
                                {
                                    $input['dept'] = $input[0];
                                    $input['customer_name'] = $input[1];
                                    $input['customer_address'] = $input[2];
                                    $input['invoice_number'] = $input[3];
                                    $input['oversea_fty_ci_no'] = $input[4];
                                    $input['contract_number'] = $input[5];
                                    $input['type'] = $input[6];
                                    $input['purchaseorder_number'] = $input[7];
                                    $input['buyer_po_no'] = $input[8];
                                    $input['cargo_description'] = $input[9];
                                    $input['hs_code'] = $input[10];
                                    $input['processing_plant'] = $input[11];
                                    $input['trade_type'] = $input[12];
                                    $input['dest_country'] = $input[13];
                                    $input['dest_port'] = $input[14];
                                    $input['incoterm'] = $input[15];
                                    $input['ship_by'] = $input[16];
                                    $input['crd'] = $input[17];
                                    $input['dcd_date'] = $input[18];
                                    $input['shipment_no'] = $input[19];
                                    $input['forwarder'] = $input[20];
                                    $input['etd'] = $input[21];
                                    $input['eta'] = $input[22];
                                    $input['deliver_no'] = $input[23];
                                    $input['arrived_wh_date'] = $input[24];
                                    $input['customs_no'] = $input[25];
                                    $input['customs_declaration_no'] = $input[26];
                                    $input['customs_declaration_return'] = $input[27];
                                    $input['bill_no'] = $input[28];
                                    $input['issue_blank'] = $input[29];
                                    $input['issue_blank_address'] = $input[30];
                                    $input['issue_blank_swift'] = $input[31];
                                    $input['negotiation_ci_date'] = $input[32];
                                    $input['negotiation_date'] = $input[33];
                                    $input['tradecard_login_date'] = $input[34];
                                    $input['tradecard_confirmation_date'] = $input[35];
                                    $input['payment_by'] = $input[36];
                                    $input['qty_for_customs'] = $input[37];
                                    $input['amount_for_customs'] = $input[38];
                                    $input['qty_for_customer'] = $input[39];
                                    $input['amount_for_customer'] = $input[40];
                                    $input['amount_customer_payment'] = $input[41];
                                    $input['customer_payment_date'] = $input[42];
                                    $input['different_column_ao_vs_am'] = $input[43];
                                    $input['percent_different_column_ao_vs_am'] = $input[44];
                                    $input['first_sale'] = $input[45];
                                    $input['wuxi_obtain_amount'] = $input[46];
                                    $input['pmj_obtain_amount'] = $input[47];
                                    $input['account_period'] = $input[48];
                                    $input['payment_schedule'] = $input[49];
                                    $input['finance_amount'] = $input[50];
                                    $input['freight_charge_usd'] = $input[51];
                                    $input['freight_charge_rmb'] = $input[52];
                                    $input['volume'] = $input[53];
                                    $input['insurance_charge'] = $input[54];
                                    $input['tariff'] = $input[55];
                                    $input['reparations_charge'] = $input[56];
                                    $input['commission1'] = $input[57];
                                    $input['commission2'] = $input[58];
                                    $input['commission3'] = $input[59];
                                    $input['credit_insurance_customers'] = $input[60];
                                    $input['credit_insurance_account_period'] = $input[61];
                                    $input['credit_insurance_limited'] = $input[62];
                                    $input['bill_of_draft_date'] = $input[63];
                                    $input['bill_of_draft_blank'] = $input[64];
                                    $input['fob_amount'] = $input[65];
                                    $input['cc_date'] = $input[66];
                                    $input['sale_date'] = $input[67];
                                    $input['gw_for_pl'] = $input[68];
                                    $input['nw_for_pl'] = $input[69];
                                    $input['cm_rate'] = $input[70];
                                    $input['ship_company'] = $input[71];
                                    $input['container_number'] = $input[72];
                                    $input['memo'] = $input[73];
                                    $shipment = Shipment::create($input);
                                }
                                else
                                    $shipment = null;
                            }
                            else
                            {
                                if (empty($input[3]) && !empty($input[5]) && isset($shipment))
                                {
                                    $input['shipment_id'] = $shipment->id;
                                    $input['contract_number'] = $input[5];
                                    $input['purchaseorder_number'] = $input[7];
                                    $input['qty_for_customer'] = $input[39];
                                    $input['amount_for_customer'] = $input[40];
                                    $input['volume'] = $input[53];
                                    Shipmentitem::create($input);
                                }
                            }
                        }
                    }
                    $rowindex++;
                });
            });
//            foreach ($reader->get() as $sheet)
//            {
//                foreach ($sheet as $row)
//                {
//                    dd($row);
//                }
//            }
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            Log::info('highestRow: ' . $highestRow);
            Log::info('highestColumn: ' . $highestColumn);

            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++)
            {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);

                $excel[] = $rowData[0];
            }
        });
//        dd($file->getRealPath());
//        Shipment::create($input);

        return redirect('shipment/shipments');
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
        $shipment = Shipment::findOrFail($id);
        return view('shipment.shipments.show', compact('shipment'));
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
        $shipment = Shipment::findOrFail($id);
        return view('shipment.shipments.edit', compact('shipment'));
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
        $this->validate($request, [
            'issue_blank' => 'required',
        ]);

        $shipment = Shipment::findOrFail($id);
        $shipment->update($request->all());

        if (isset($shipment))
        {
            $types = ['SI', 'CI', 'PL', 'PLA', 'RMA', 'BC', 'bank_permit', 'BTB_DOCS', 'ECD', 'BL', 'others'];
            foreach ($types as $type)
            {
                $file = $request->file($type);
                if (isset($file))
                {
                    $path = $file->store('public/shipment/' . $shipment->id);

                    $shipmentattachment = Shipmentattachment::where('shipment_id', $shipment->id)->where('type', $type)->first();
                    if (!isset($shipmentattachment))
                        $shipmentattachment = new Shipmentattachment();
                    $shipmentattachment->shipment_id = $shipment->id;
                    $shipmentattachment->type = $type;
                    $shipmentattachment->filename = $file->getClientOriginalName();
                    $shipmentattachment->path = $path;     // add a '/' in the head.
                    $shipmentattachment->save();
                }
            }
        }

        return redirect('shipment/shipments');
    }

    public function editshipmenttracking($id)
    {
        //
        $shipment = Shipment::findOrFail($id);
        return view('shipment.shipments.editshipmenttracking', compact('shipment'));
    }

    public function updateshipmenttracking(Request $request, $id)
    {
        //
        $shipment = Shipment::findOrFail($id);
        $shipment->update($request->all());

        if (isset($shipment))
        {
            $types = ['SI', 'CI', 'PL', 'PLA', 'RMA', 'BC', 'bank_permit', 'BTB_DOCS', 'ECD', 'BL', 'others'];
            foreach ($types as $type)
            {
                $file = $request->file($type);
                if (isset($file))
                {
                    $path = $file->store('public/shipment/' . $shipment->id);

                    $shipmentattachment = Shipmentattachment::where('shipment_id', $shipment->id)->where('type', $type)->first();
                    if (!isset($shipmentattachment))
                        $shipmentattachment = new Shipmentattachment();
                    $shipmentattachment->shipment_id = $shipment->id;
                    $shipmentattachment->type = $type;
                    $shipmentattachment->filename = $file->getClientOriginalName();
                    $shipmentattachment->path = $path;     // add a '/' in the head.
                    $shipmentattachment->save();

                    Log::info(json_encode(config('custom.shipment.mailto.shipmenttracking_bc')));
                    if ($type == "BC")
                    {
                        Mail::send('shipment.shipments.shipmenttracking_mail', ['shipment' => $shipment, 'shipmentattachment' => $shipmentattachment], function ($message) use ($shipment, $shipmentattachment) {
                            $message->to(config('custom.shipment.mailto.shipmenttracking_bc'), '123')->subject($shipment->invoice_number . ', BC file has uploaded');
                        });
                    }
                    if ($type == "BL")
                    {
                        Mail::send('shipment.shipments.shipmenttracking_mail', ['shipment' => $shipment, 'shipmentattachment' => $shipmentattachment], function ($message) use ($shipment, $shipmentattachment) {
                            $message->to(config('custom.shipment.mailto.shipmenttracking_bl'), '123')->subject($shipment->invoice_number . ', BL file has uploaded.');
                        });
                    }

//                    $shipments = Shipment::where('id', $shipment->id)->get();
//                    Mail::to('seahouse@126.com')->send(new FileUploaded($shipments));
                }
            }
        }

//        Mail::send('shipment.shipments.shipmenttracking2', [], function ($message) {
//            $message->to('260822310@qq.com', '123')->subject('zhuti');
//        });

        return redirect('shipment/shipments/shipmenttracking');
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
        Shipment::destroy($id);
        return redirect('shipment/shipments');
    }

    public function shipmentitems($shipment_id)
    {
        $shipmentitems = Shipmentitem::where('shipment_id', $shipment_id)->paginate(10);
        return view('shipment.shipmentitems.index', compact('shipmentitems', 'shipment_id'));
    }

    public function export(Request $request)
    {
        Log::info('export');
        Log::info($request->all());
        Excel::load('exceltemplate/Shipments.xls', function($reader) use ($request) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);

            $indexrow = 4;
            $this->searchrequest($request)->chunk(10, function ($shipments) use ($sheet, &$indexrow)  {
                foreach ($shipments as $shipment)
                {
                    $sheet->setCellValue('A' . $indexrow, $shipment->dept);
                    $sheet->setCellValue('B' . $indexrow, $shipment->customer_name);
                    $sheet->setCellValue('C' . $indexrow, $shipment->customer_address);
                    $sheet->setCellValue('D' . $indexrow, $shipment->invoice_number);
                    $sheet->setCellValue('E' . $indexrow, $shipment->oversea_fty_ci_no);
                    $sheet->setCellValue('F' . $indexrow, $shipment->contract_number);
                    $sheet->setCellValue('G' . $indexrow, $shipment->type);
                    $sheet->setCellValue('H' . $indexrow, $shipment->purchaseorder_number);
                    $sheet->setCellValue('I' . $indexrow, $shipment->buyer_po_no);
                    $sheet->setCellValue('J' . $indexrow, $shipment->cargo_description);
                    $sheet->setCellValue('K' . $indexrow, $shipment->hs_code);
                    $sheet->setCellValue('L' . $indexrow, $shipment->processing_plant);
                    $sheet->setCellValue('M' . $indexrow, $shipment->trade_type);
                    $sheet->setCellValue('N' . $indexrow, $shipment->dest_country);
                    $sheet->setCellValue('O' . $indexrow, $shipment->dest_port);
                    $sheet->setCellValue('P' . $indexrow, $shipment->incoterm);
                    $sheet->setCellValue('Q' . $indexrow, $shipment->ship_by);
                    $sheet->setCellValue('R' . $indexrow, $shipment->crd);
                    $sheet->setCellValue('S' . $indexrow, $shipment->dcd_date);
                    $sheet->setCellValue('T' . $indexrow, $shipment->shipment_no);
                    $sheet->setCellValue('U' . $indexrow, $shipment->forwarder);
                    $sheet->setCellValue('V' . $indexrow, $shipment->etd);
                    $sheet->setCellValue('W' . $indexrow, $shipment->eta);
                    $sheet->setCellValue('X' . $indexrow, $shipment->deliver_no);
                    $sheet->setCellValue('Y' . $indexrow, $shipment->arrived_wh_date);
                    $sheet->setCellValue('Z' . $indexrow, $shipment->customs_no);
                    $sheet->setCellValue('AA' . $indexrow, $shipment->customs_declaration_no);
                    $sheet->setCellValue('AB' . $indexrow, $shipment->customs_declaration_return);
                    $sheet->setCellValue('AC' . $indexrow, $shipment->bill_no);
                    $sheet->setCellValue('AD' . $indexrow, $shipment->issue_blank);
                    $sheet->setCellValue('AE' . $indexrow, $shipment->issue_blank_address);
                    $sheet->setCellValue('AF' . $indexrow, $shipment->issue_blank_swift);
                    $sheet->setCellValue('AG' . $indexrow, $shipment->negotiation_ci_date);
                    $sheet->setCellValue('AH' . $indexrow, $shipment->negotiation_date);
                    $sheet->setCellValue('AI' . $indexrow, $shipment->tradecard_login_date);
                    $sheet->setCellValue('AJ' . $indexrow, $shipment->tradecard_confirmation_date);
                    $sheet->setCellValue('AK' . $indexrow, $shipment->payment_by);
                    $sheet->setCellValue('AL' . $indexrow, $shipment->qty_for_customs);
                    $sheet->setCellValue('AM' . $indexrow, $shipment->amount_for_customs);
                    $sheet->setCellValue('AN' . $indexrow, $shipment->qty_for_customer);
                    $sheet->setCellValue('AO' . $indexrow, $shipment->amount_for_customer);
                    $sheet->setCellValue('AP' . $indexrow, $shipment->amount_customer_payment);
                    $sheet->setCellValue('AQ' . $indexrow, $shipment->customer_payment_date);
                    $sheet->setCellValue('AR' . $indexrow, $shipment->different_column_ao_vs_am);
                    $sheet->setCellValue('AS' . $indexrow, $shipment->percent_different_column_ao_vs_am);
                    $sheet->setCellValue('AT' . $indexrow, $shipment->first_sale);
                    $sheet->setCellValue('AU' . $indexrow, $shipment->wuxi_obtain_amount);
                    $sheet->setCellValue('AV' . $indexrow, $shipment->pmj_obtain_amount);
                    $sheet->setCellValue('AW' . $indexrow, $shipment->account_period);
                    $sheet->setCellValue('AX' . $indexrow, $shipment->payment_schedule);
                    $sheet->setCellValue('AY' . $indexrow, $shipment->finance_amount);
                    $sheet->setCellValue('AZ' . $indexrow, $shipment->freight_charge_usd);
                    $sheet->setCellValue('BA' . $indexrow, $shipment->freight_charge_rmb);
                    $sheet->setCellValue('BB' . $indexrow, $shipment->volume);
                    $sheet->setCellValue('BC' . $indexrow, $shipment->insurance_charge);
                    $sheet->setCellValue('BD' . $indexrow, $shipment->tariff);
                    $sheet->setCellValue('BE' . $indexrow, $shipment->reparations_charge);
                    $sheet->setCellValue('BF' . $indexrow, $shipment->commission1);
                    $sheet->setCellValue('BG' . $indexrow, $shipment->commission2);
                    $sheet->setCellValue('BH' . $indexrow, $shipment->commission3);
                    $sheet->setCellValue('BI' . $indexrow, $shipment->credit_insurance_customers);
                    $sheet->setCellValue('BJ' . $indexrow, $shipment->credit_insurance_account_period);
                    $sheet->setCellValue('BK' . $indexrow, $shipment->credit_insurance_limited);
                    $sheet->setCellValue('BL' . $indexrow, $shipment->bill_of_draft_date);
                    $sheet->setCellValue('BM' . $indexrow, $shipment->bill_of_draft_blank);
                    $sheet->setCellValue('BN' . $indexrow, $shipment->fob_amount);
                    $sheet->setCellValue('BO' . $indexrow, $shipment->cc_date);
                    $sheet->setCellValue('BP' . $indexrow, $shipment->sale_date);
                    $sheet->setCellValue('BQ' . $indexrow, $shipment->gw_for_pl);
                    $sheet->setCellValue('BR' . $indexrow, $shipment->nw_for_pl);
                    $sheet->setCellValue('BS' . $indexrow, $shipment->cm_rate);
                    $sheet->setCellValue('BT' . $indexrow, $shipment->ship_company);
                    $sheet->setCellValue('BU' . $indexrow, $shipment->container_number);
                    $sheet->setCellValue('BV' . $indexrow, $shipment->memo);
                    $indexrow++;

                    foreach ($shipment->shipmentitems as $shipmentitem)
                    {
                        $sheet->setCellValue('F' . $indexrow, $shipmentitem->contract_number);
                        $sheet->setCellValue('H' . $indexrow, $shipmentitem->purchaseorder_number);
                        $sheet->setCellValue('AN' . $indexrow, $shipmentitem->qty_for_customer);
                        $sheet->setCellValue('AO' . $indexrow, $shipmentitem->amount_for_customer);
                        $sheet->setCellValue('BB' . $indexrow, $shipmentitem->volume);
                        $indexrow++;
                    }
                }
            });
//            Shipment::orderBy('created_at')->chunk(5, function ($shipments) use ($sheet, &$indexrow) {
//                foreach ($shipments as $shipment)
//                {
//                    $sheet->setCellValue('A' . $indexrow, $shipment->dept);
//
//                    $indexrow++;
//                }
//            });
//            $excel->sheet('Sheetname', function($sheet) {
//                // Sheet manipulation
//                $paymentrequests = $this->search2()->toArray();
//                dd($paymentrequests["data"]);
//                $sheet->fromArray($paymentrequests["data"]);
//            });

//            // Set the title
//            $excel->setTitle('Our new awesome title');
//
//            // Chain the setters
//            $excel->setCreator('Maatwebsite')
//                ->setCompany('Maatwebsite');
//
//            // Call them separately
//            $excel->setDescription('A demonstration to change the file properties');

        })->store('xlsx', public_path('download/shipment'));

//        $newfilename = 'export_' . Carbon::now()->format('YmdHis') . substr($filename, strpos($filename, "."));
        $newfilename = 'export_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Log::info($newfilename);
        rename(public_path('download/shipment/Shipments.xlsx'), public_path('download/shipment/' . $newfilename));

        Log::info(route('shipment.shipments.downloadfile', ['filename' => $newfilename]));
        return route('shipment.shipments.downloadfile', ['filename' => $newfilename]);

    }

    public function exportpvh(Request $request)
    {
        Log::info($request->all());
        Excel::load('exceltemplate/PVHShipment.xls', function($reader) use ($request) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);

            $indexrow = 2;
            $this->searchrequest($request)->chunk(100, function ($shipments) use ($sheet, &$indexrow)  {
                foreach ($shipments as $shipment)
                {
                    $sheet->setCellValue('A' . $indexrow, $shipment->invoice_number);
                    $sheet->setCellValue('B' . $indexrow, $shipment->dest_port);
                    $sheet->setCellValue('C' . $indexrow, $shipment->contract_number);
                    $sheet->setCellValue('D' . $indexrow, $shipment->purchaseorder_number);
                    $sheet->setCellValue('E' . $indexrow, $shipment->ship_company);
                    $sheet->setCellValue('F' . $indexrow, $shipment->bill_no);
                    $sheet->setCellValue('G' . $indexrow, $shipment->container_number);
                    $sheet->setCellValue('H' . $indexrow, $shipment->etd);
                    $sheet->setCellValue('I' . $indexrow, $shipment->eta);
//                    $sheet->setCellValue('I' . $indexrow, $shipment->buyer_po_no);
//                    $sheet->setCellValue('J' . $indexrow, $shipment->cargo_description);
//                    $sheet->setCellValue('K' . $indexrow, $shipment->hs_code);
//                    $sheet->setCellValue('L' . $indexrow, $shipment->processing_plant);
//                    $sheet->setCellValue('M' . $indexrow, $shipment->trade_type);
//                    $sheet->setCellValue('N' . $indexrow, $shipment->dest_country);
//                    $sheet->setCellValue('O' . $indexrow, $shipment->dest_port);
//                    $sheet->setCellValue('P' . $indexrow, $shipment->incoterm);
//                    $sheet->setCellValue('Q' . $indexrow, $shipment->ship_by);
//                    $sheet->setCellValue('R' . $indexrow, $shipment->crd);
//                    $sheet->setCellValue('S' . $indexrow, $shipment->dcd_date);
//                    $sheet->setCellValue('T' . $indexrow, $shipment->shipment_no);
//                    $sheet->setCellValue('U' . $indexrow, $shipment->forwarder);
//                    $sheet->setCellValue('V' . $indexrow, $shipment->etd);
//                    $sheet->setCellValue('W' . $indexrow, $shipment->eta);
//                    $sheet->setCellValue('X' . $indexrow, $shipment->deliver_no);
//                    $sheet->setCellValue('Y' . $indexrow, $shipment->arrived_wh_date);
//                    $sheet->setCellValue('Z' . $indexrow, $shipment->customs_no);
//                    $sheet->setCellValue('AA' . $indexrow, $shipment->customs_declaration_no);
//                    $sheet->setCellValue('AB' . $indexrow, $shipment->customs_declaration_return);
//                    $sheet->setCellValue('AC' . $indexrow, $shipment->bill_no);
//                    $sheet->setCellValue('AD' . $indexrow, $shipment->issue_blank);
//                    $sheet->setCellValue('AE' . $indexrow, $shipment->issue_blank_address);
//                    $sheet->setCellValue('AF' . $indexrow, $shipment->issue_blank_swift);
//                    $sheet->setCellValue('AG' . $indexrow, $shipment->negotiation_ci_date);
//                    $sheet->setCellValue('AH' . $indexrow, $shipment->negotiation_date);
//                    $sheet->setCellValue('AI' . $indexrow, $shipment->tradecard_login_date);
//                    $sheet->setCellValue('AJ' . $indexrow, $shipment->tradecard_confirmation_date);
//                    $sheet->setCellValue('AK' . $indexrow, $shipment->payment_by);
//                    $sheet->setCellValue('AL' . $indexrow, $shipment->qty_for_customs);
//                    $sheet->setCellValue('AM' . $indexrow, $shipment->amount_for_customs);
//                    $sheet->setCellValue('AN' . $indexrow, $shipment->qty_for_customer);
//                    $sheet->setCellValue('AO' . $indexrow, $shipment->amount_for_customer);
//                    $sheet->setCellValue('AP' . $indexrow, $shipment->amount_customer_payment);
//                    $sheet->setCellValue('AQ' . $indexrow, $shipment->customer_payment_date);
//                    $sheet->setCellValue('AR' . $indexrow, $shipment->different_column_ao_vs_am);
//                    $sheet->setCellValue('AS' . $indexrow, $shipment->percent_different_column_ao_vs_am);
//                    $sheet->setCellValue('AT' . $indexrow, $shipment->first_sale);
//                    $sheet->setCellValue('AU' . $indexrow, $shipment->wuxi_obtain_amount);
//                    $sheet->setCellValue('AV' . $indexrow, $shipment->pmj_obtain_amount);
//                    $sheet->setCellValue('AW' . $indexrow, $shipment->account_period);
//                    $sheet->setCellValue('AX' . $indexrow, $shipment->payment_schedule);
//                    $sheet->setCellValue('AY' . $indexrow, $shipment->finance_amount);
//                    $sheet->setCellValue('AZ' . $indexrow, $shipment->freight_charge_usd);
//                    $sheet->setCellValue('BA' . $indexrow, $shipment->freight_charge_rmb);
//                    $sheet->setCellValue('BB' . $indexrow, $shipment->volume);
//                    $sheet->setCellValue('BC' . $indexrow, $shipment->insurance_charge);
//                    $sheet->setCellValue('BD' . $indexrow, $shipment->tariff);
//                    $sheet->setCellValue('BE' . $indexrow, $shipment->reparations_charge);
//                    $sheet->setCellValue('BF' . $indexrow, $shipment->commission1);
//                    $sheet->setCellValue('BG' . $indexrow, $shipment->commission2);
//                    $sheet->setCellValue('BH' . $indexrow, $shipment->commission3);
//                    $sheet->setCellValue('BI' . $indexrow, $shipment->credit_insurance_customers);
//                    $sheet->setCellValue('BJ' . $indexrow, $shipment->credit_insurance_account_period);
//                    $sheet->setCellValue('BK' . $indexrow, $shipment->credit_insurance_limited);
//                    $sheet->setCellValue('BL' . $indexrow, $shipment->bill_of_draft_date);
//                    $sheet->setCellValue('BM' . $indexrow, $shipment->bill_of_draft_blank);
//                    $sheet->setCellValue('BN' . $indexrow, $shipment->fob_amount);
//                    $sheet->setCellValue('BO' . $indexrow, $shipment->cc_date);
//                    $sheet->setCellValue('BP' . $indexrow, $shipment->sale_date);
//                    $sheet->setCellValue('BQ' . $indexrow, $shipment->gw_for_pl);
//                    $sheet->setCellValue('BR' . $indexrow, $shipment->nw_for_pl);
//                    $sheet->setCellValue('BS' . $indexrow, $shipment->cm_rate);
//                    $sheet->setCellValue('BT' . $indexrow, $shipment->ship_company);
//                    $sheet->setCellValue('BU' . $indexrow, $shipment->container_number);
//                    $sheet->setCellValue('BV' . $indexrow, $shipment->memo);
                    $indexrow++;

                    foreach ($shipment->shipmentitems as $shipmentitem)
                    {
                        $sheet->setCellValue('C' . $indexrow, $shipmentitem->contract_number);
//                        $sheet->setCellValue('H' . $indexrow, $shipmentitem->purchaseorder_number);
//                        $sheet->setCellValue('AN' . $indexrow, $shipmentitem->qty_for_customer);
//                        $sheet->setCellValue('AO' . $indexrow, $shipmentitem->amount_for_customer);
//                        $sheet->setCellValue('BB' . $indexrow, $shipmentitem->volume);
                        $indexrow++;
                    }
                }
            });

        })->store('xlsx', public_path('download/shipment'));
        Log::info(route('shipment.shipments.downloadfile', ['filename' => 'PVHShipment.xlsx']));
        return route('shipment.shipments.downloadfile', ['filename' => 'PVHShipment.xlsx']);
    }

    public function exportshipmenttracking(Request $request)
    {
        //

        $filename = 'forwarder_' . Carbon::now()->format('YmdHis');

        Log::info($filename);
        Log::info($request->all());
        Excel::create($filename, function($excel) use ($request) {
            $excel->sheet('Sheetname', function($sheet) use ($request) {
                $items_t = $this->searchrequest($request)->get();
                $dataArray = json_decode(json_encode($items_t), true);
                $data = [];
                foreach ($dataArray as $item)
                {
                    array_push($data, array_only($item, ['invoice_number', 'customs_no', 'customer_name', 'dest_port', 'etd', 'etd_transport_date', 'bill_no', 'ship_company', 'container_number']));
                }
//                dd($data);
//                dd(json_decode(json_encode($items_t), true));
//                $paymentrequests = $this->search2()->toArray();
//                $sheet->freezeFirstRow();
//                $sheet->setColumnFormat(array(
//                    'C' => 'yyyy-mm-dd',
//                    'G' => '0.00%'
//                ));
                $sheet->fromArray($data);
                $dataArray = json_decode(json_encode($items_t), true);

//                // 修改：原来是根据数据的key来设置标题
//                // 考虑到无法处理中文标题，修改此代码
//                $titleshows = explode(',', $report->titleshow);
//                if (count($titleshows) > 1)
//                    $sheet->appendRow($titleshows);
//                else
//                {
//                    list($keys, $values) = array_divide(array_first($dataArray));
//                    $sheet->appendRow($keys);
//                }

//                foreach ($dataArray as $value)
//                    $sheet->appendRow($value);

//                $sheet->fromModel($items_t);
//                $sheet->protect('password');
//                $sheet->setColumnFormat(array('G' => '0%'));
//                $sheet->row(1, function ($row) {
//                    $row->setBackground('#000000');
//                });
//                $sheet->appendRow(array(
//                    'appended', 54546, '2017-05-01', 1, 1, 1, '0.5'
//                ));
            });


//            $objExcel = $reader->getExcel();
//            $sheet = $objExcel->getSheet(0);
//
//            $indexrow = 4;
//            $this->searchrequest($request)->chunk(10, function ($shipments) use ($sheet, &$indexrow)  {
//                foreach ($shipments as $shipment)
//                {
//                    $sheet->setCellValue('A' . $indexrow, $shipment->dept);
//                    $sheet->setCellValue('B' . $indexrow, $shipment->customer_name);
//                    $sheet->setCellValue('C' . $indexrow, $shipment->customer_address);
//                    $sheet->setCellValue('D' . $indexrow, $shipment->invoice_number);
//                    $sheet->setCellValue('E' . $indexrow, $shipment->oversea_fty_ci_no);
//                    $sheet->setCellValue('F' . $indexrow, $shipment->contract_number);
//                    $sheet->setCellValue('G' . $indexrow, $shipment->type);
//                    $sheet->setCellValue('H' . $indexrow, $shipment->purchaseorder_number);
//                    $sheet->setCellValue('I' . $indexrow, $shipment->buyer_po_no);
//                    $sheet->setCellValue('J' . $indexrow, $shipment->cargo_description);
//                    $sheet->setCellValue('K' . $indexrow, $shipment->hs_code);
//                    $sheet->setCellValue('L' . $indexrow, $shipment->processing_plant);
//                    $sheet->setCellValue('M' . $indexrow, $shipment->trade_type);
//                    $sheet->setCellValue('N' . $indexrow, $shipment->dest_country);
//                    $sheet->setCellValue('O' . $indexrow, $shipment->dest_port);
//                    $sheet->setCellValue('P' . $indexrow, $shipment->incoterm);
//                    $sheet->setCellValue('Q' . $indexrow, $shipment->ship_by);
//                    $sheet->setCellValue('R' . $indexrow, $shipment->crd);
//                    $sheet->setCellValue('S' . $indexrow, $shipment->dcd_date);
//                    $sheet->setCellValue('T' . $indexrow, $shipment->shipment_no);
//                    $sheet->setCellValue('U' . $indexrow, $shipment->forwarder);
//                    $sheet->setCellValue('V' . $indexrow, $shipment->etd);
//                    $sheet->setCellValue('W' . $indexrow, $shipment->eta);
//                    $sheet->setCellValue('X' . $indexrow, $shipment->deliver_no);
//                    $sheet->setCellValue('Y' . $indexrow, $shipment->arrived_wh_date);
//                    $sheet->setCellValue('Z' . $indexrow, $shipment->customs_no);
//                    $sheet->setCellValue('AA' . $indexrow, $shipment->customs_declaration_no);
//                    $sheet->setCellValue('AB' . $indexrow, $shipment->customs_declaration_return);
//                    $sheet->setCellValue('AC' . $indexrow, $shipment->bill_no);
//                    $sheet->setCellValue('AD' . $indexrow, $shipment->issue_blank);
//                    $sheet->setCellValue('AE' . $indexrow, $shipment->issue_blank_address);
//                    $sheet->setCellValue('AF' . $indexrow, $shipment->issue_blank_swift);
//                    $sheet->setCellValue('AG' . $indexrow, $shipment->negotiation_ci_date);
//                    $sheet->setCellValue('AH' . $indexrow, $shipment->negotiation_date);
//                    $sheet->setCellValue('AI' . $indexrow, $shipment->tradecard_login_date);
//                    $sheet->setCellValue('AJ' . $indexrow, $shipment->tradecard_confirmation_date);
//                    $sheet->setCellValue('AK' . $indexrow, $shipment->payment_by);
//                    $sheet->setCellValue('AL' . $indexrow, $shipment->qty_for_customs);
//                    $sheet->setCellValue('AM' . $indexrow, $shipment->amount_for_customs);
//                    $sheet->setCellValue('AN' . $indexrow, $shipment->qty_for_customer);
//                    $sheet->setCellValue('AO' . $indexrow, $shipment->amount_for_customer);
//                    $sheet->setCellValue('AP' . $indexrow, $shipment->amount_customer_payment);
//                    $sheet->setCellValue('AQ' . $indexrow, $shipment->customer_payment_date);
//                    $sheet->setCellValue('AR' . $indexrow, $shipment->different_column_ao_vs_am);
//                    $sheet->setCellValue('AS' . $indexrow, $shipment->percent_different_column_ao_vs_am);
//                    $sheet->setCellValue('AT' . $indexrow, $shipment->first_sale);
//                    $sheet->setCellValue('AU' . $indexrow, $shipment->wuxi_obtain_amount);
//                    $sheet->setCellValue('AV' . $indexrow, $shipment->pmj_obtain_amount);
//                    $sheet->setCellValue('AW' . $indexrow, $shipment->account_period);
//                    $sheet->setCellValue('AX' . $indexrow, $shipment->payment_schedule);
//                    $sheet->setCellValue('AY' . $indexrow, $shipment->finance_amount);
//                    $sheet->setCellValue('AZ' . $indexrow, $shipment->freight_charge_usd);
//                    $sheet->setCellValue('BA' . $indexrow, $shipment->freight_charge_rmb);
//                    $sheet->setCellValue('BB' . $indexrow, $shipment->volume);
//                    $sheet->setCellValue('BC' . $indexrow, $shipment->insurance_charge);
//                    $sheet->setCellValue('BD' . $indexrow, $shipment->tariff);
//                    $sheet->setCellValue('BE' . $indexrow, $shipment->reparations_charge);
//                    $sheet->setCellValue('BF' . $indexrow, $shipment->commission1);
//                    $sheet->setCellValue('BG' . $indexrow, $shipment->commission2);
//                    $sheet->setCellValue('BH' . $indexrow, $shipment->commission3);
//                    $sheet->setCellValue('BI' . $indexrow, $shipment->credit_insurance_customers);
//                    $sheet->setCellValue('BJ' . $indexrow, $shipment->credit_insurance_account_period);
//                    $sheet->setCellValue('BK' . $indexrow, $shipment->credit_insurance_limited);
//                    $sheet->setCellValue('BL' . $indexrow, $shipment->bill_of_draft_date);
//                    $sheet->setCellValue('BM' . $indexrow, $shipment->bill_of_draft_blank);
//                    $sheet->setCellValue('BN' . $indexrow, $shipment->fob_amount);
//                    $sheet->setCellValue('BO' . $indexrow, $shipment->cc_date);
//                    $sheet->setCellValue('BP' . $indexrow, $shipment->sale_date);
//                    $sheet->setCellValue('BQ' . $indexrow, $shipment->gw_for_pl);
//                    $sheet->setCellValue('BR' . $indexrow, $shipment->nw_for_pl);
//                    $sheet->setCellValue('BS' . $indexrow, $shipment->cm_rate);
//                    $sheet->setCellValue('BT' . $indexrow, $shipment->ship_company);
//                    $sheet->setCellValue('BU' . $indexrow, $shipment->container_number);
//                    $sheet->setCellValue('BV' . $indexrow, $shipment->memo);
//                    $indexrow++;
//
//                    foreach ($shipment->shipmentitems as $shipmentitem)
//                    {
//                        $sheet->setCellValue('F' . $indexrow, $shipmentitem->contract_number);
//                        $sheet->setCellValue('H' . $indexrow, $shipmentitem->purchaseorder_number);
//                        $sheet->setCellValue('AN' . $indexrow, $shipmentitem->qty_for_customer);
//                        $sheet->setCellValue('AO' . $indexrow, $shipmentitem->amount_for_customer);
//                        $sheet->setCellValue('BB' . $indexrow, $shipmentitem->volume);
//                        $indexrow++;
//                    }
//                }
//            });
//            Shipment::orderBy('created_at')->chunk(5, function ($shipments) use ($sheet, &$indexrow) {
//                foreach ($shipments as $shipment)
//                {
//                    $sheet->setCellValue('A' . $indexrow, $shipment->dept);
//
//                    $indexrow++;
//                }
//            });
//            $excel->sheet('Sheetname', function($sheet) {
//                // Sheet manipulation
//                $paymentrequests = $this->search2()->toArray();
//                dd($paymentrequests["data"]);
//                $sheet->fromArray($paymentrequests["data"]);
//            });

//            // Set the title
//            $excel->setTitle('Our new awesome title');
//
//            // Chain the setters
//            $excel->setCreator('Maatwebsite')
//                ->setCompany('Maatwebsite');
//
//            // Call them separately
//            $excel->setDescription('A demonstration to change the file properties');

        })->store('xlsx', public_path('download/shipment'));

        Log::info(route('shipment.shipments.downloadfile', ['filename' =>  $filename . '.xlsx']));
        return route('shipment.shipments.downloadfile', ['filename' => $filename . '.xlsx']);
    }

    // https://www.cnblogs.com/cyclzdblog/p/7670695.html
    public function downloadfile($filename)
    {
//        Log::info('filename: ' . $filename);
//        $newfilename = substr($filename, 0, strpos($filename, ".")) . Carbon::now()->format('YmdHis') . substr($filename, strpos($filename, "."));
//        Log::info($newfilename);
//        rename(public_path('download/shipment/' . $filename), public_path('download/shipment/' . $newfilename));
        $file = public_path('download/shipment/' . $filename);
        Log::info('file path:' . $file);
        return response()->download($file);
    }

    public function uploadfile(Request $request)
    {
        //
//        Log::info($request->all());
        $popoverhtml = '';
        if ($request->has('shipment_id') && $request->has('type'))
        {
            $shipment = Shipment::find($request->input('shipment_id'));
            if (isset($shipment))
            {
                $type = $request->input('type');
                $file = $request->file('file');
                if (isset($file))
                {
                    $filename = $shipment->invoice_number . '_' . $type . '_' . Carbon::now()->format('Ymd') . '_' . Carbon::now()->format('His'). '.' . $file->getClientOriginalExtension();
//                    $path = $file->store('public/shipment/' . $shipment->id);
                    $path = $file->storeAs('public/shipment/' . $shipment->id, $filename);

                    $shipmentattachment = Shipmentattachment::where('shipment_id', $shipment->id)->where('type', $type)->first();
                    if (!isset($shipmentattachment))
                        $shipmentattachment = new Shipmentattachment();
                    $shipmentattachment->shipment_id = $shipment->id;
                    $shipmentattachment->type = $type;
                    $shipmentattachment->filename = $file->getClientOriginalName();
                    $shipmentattachment->path = $path;     // add a '/' in the head.
                    $shipmentattachment->save();

                    // add record
                    $shipmentattachmentrecord = new Shipmentattachmentrecord();
                    $shipmentattachmentrecord->shipment_id = $shipment->id;
                    $shipmentattachmentrecord->type = $type;
                    $shipmentattachmentrecord->filename = $file->getClientOriginalName();
                    $shipmentattachmentrecord->path = $path;     // add a '/' in the head.
                    $shipmentattachmentrecord->operation_type = 'Upload';
                    $shipmentattachmentrecord->operator = Auth::user()->name;
                    $shipmentattachmentrecord->save();

                    $this->sendMailMsg($shipment, $type, $shipmentattachment);

                    $popoverhtml = '<a tabindex="0" role="button" class="btn btn-sm btn-success filehandler" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-trigger="focus" 
                                            data-content="<a href=\'' . Storage::url($path) . '\' target=\'_blank\' class=\'btn btn-sm\'>View</a>
                                            <button class=\'btn btn-sm\' data-toggle=\'modal\' data-target=\'#uploadAttachModal\' data-shipment_id=\'' . $shipment->id . '\' data-type=\'' . $type . '\' type=\'button\'>Re-upload</button>
                                            <button class=\'btn btn-sm\' data-toggle=\'modal\' data-target=\'#clearAttachModal\' data-shipment_id=\'' . $shipment->id . '\' data-type=\'' . $type . '\' type=\'button\'>Clear</button>">V</a>';
                    Log::info($popoverhtml);
                }
            }
        }

        $data = [
            'errcode' => 0,
            'errmsg' => 'Upload Sucess.',
            'popoverhtml' => $popoverhtml,
        ];
        return response()->json($data);
    }

    public function clearfile(Request $request)
    {
        //
//        Log::info($request->all());
        $popoverhtml = '';
        if ($request->has('shipment_id') && $request->has('type'))
        {
            $shipment = Shipment::find($request->input('shipment_id'));
            if (isset($shipment))
            {
                $type = $request->input('type');
//                $file = $request->file('file');

                $shipmentattachments = Shipmentattachment::where('shipment_id', $shipment->id)->where('type', $type)->get();
                foreach ($shipmentattachments as $shipmentattachment)
                {
                    if (isset($shipmentattachment))
                    {
                        $filename = $shipmentattachment->filename;
                        $path = $shipmentattachment->path;
                        $shipmentattachment->delete();

                        // add record
                        $shipmentattachmentrecord = new Shipmentattachmentrecord();
                        $shipmentattachmentrecord->shipment_id = $shipment->id;
                        $shipmentattachmentrecord->type = $type;
                        $shipmentattachmentrecord->filename = $filename;
                        $shipmentattachmentrecord->path = $path;     // add a '/' in the head.
                        $shipmentattachmentrecord->operation_type = 'Delete';
                        $shipmentattachmentrecord->operator = Auth::user()->name;
                        $shipmentattachmentrecord->save();
                    }
                }

                $popoverhtml = '<button class="btn btn-sm" data-toggle="modal" data-target="#uploadAttachModal" data-shipment_id="' . $shipment->id . '" data-type="' . $type . '" type="button">+</button>';

                Log::info($popoverhtml);
            }
        }

        $data = [
            'errcode' => 0,
            'errmsg' => 'Clear Success.',
            'popoverhtml' => $popoverhtml,
        ];
        return response()->json($data);
    }

    private function sendMailMsg($shipment, $type, $shipmentattachment)
    {
        if ($type == "SI" || $type == "CI" || $type == "ECD" || $type == "BL")
        {
            Mail::send('shipment.shipments.shipmenttracking_mail', ['shipment' => $shipment, 'shipmentattachment' => $shipmentattachment], function ($message) use ($shipment, $type, $shipmentattachment) {
                $message->to(config('custom.shipment.mailto.shipmenttracking'), '123')->subject($shipment->invoice_number . ', ' . $type . ' file has uploaded');
            });
        }
    }
}
