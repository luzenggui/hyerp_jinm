<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Poitem;
use App\Models\Purchase\Poitemroll;
use App\Models\Purchase\Purchaseorder;
use App\Models\Purchase\Uservendor;
use App\Models\Purchaseorderc\Poitemc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, Excel, Log;

class PurchaseorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
//        $purchaseorders = Purchaseorder::latest('created_at')->paginate(10);
        $purchaseorders = $this->searchrequest($request);
        $inputs = $request->all();
        return view('purchase.purchaseorders.index', compact('purchaseorders', 'inputs'));
    }

    public function searchrequest($request)
    {
//        dd($request->all());
        $query = Purchaseorder::latest('created_at');

        if ($request->has('createdatestart') && $request->has('createdateend'))
        {
            $query->whereRaw("DATEDIFF(DAY, create_time, '" . $request->input('createdatestart') . "') <= 0 and DATEDIFF(DAY, create_time, '" . $request->input('createdateend') . "') >=0");

        }

        if ($request->has('creator_name'))
        {
            $query->where('creator_name', $request->input('creator_name'));
        }

        if ($request->has('key') && strlen($request->input('key')) > 0)
        {
            $query->where('remark', 'like', '%' . $request->input('key') . '%');
        }

//        // xmjlsgrz_sohead_id
//        if ($request->has('xmjlsgrz_sohead_id') && $request->input('xmjlsgrz_sohead_id') > 0)
//        {
//            $query->where('xmjlsgrz_sohead_id', $request->input('xmjlsgrz_sohead_id'));
//        }

        // xmjlsgrz_project_id
        if ($request->has('xmjlsgrz_project_id') && $request->input('xmjlsgrz_project_id') > 0)
        {
            $soheadids = Salesorder_hxold::where('project_id', $request->input('xmjlsgrz_project_id'))->pluck('id');
//            dd($soheadids);
            $query->whereIn('xmjlsgrz_sohead_id', $soheadids);
        }

        if (Auth::user()->isVendor())
        {
            $vendor_ids = Uservendor::where('user_id', Auth::user()->id)->pluck('vendor_id');
//            dd($vendor_ids);
            $query->whereIn('vendor_id', $vendor_ids);
        }

        $items = $query->select('*')
            ->paginate(10);

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

    public function storeseperate(Request $request)
    {
        $this->validate($request, [
            'number'                    => 'required',
//            'descrip'                   => 'required',
            'vendor_id'                 => 'required|integer|min:1',
            'orderdate'                 => 'required',
            'poheadc_id'                => 'required|integer|min:1',
//            'items_string'               => 'required',
//            'tonnage'               => 'required|numeric',
//            'drawingchecker_id'     => 'required|integer|min:1',
//            'drawingcount'          => 'required|integer|min:1',
//            'drawingattachments.*'  => 'required|file',
//            'images.*'                => 'required|image',
        ]);
        $input = $request->all();
//        dd($input);

        // 判断明细数量是否超量，前端已有余量显示，但如果存在多人操作系统，前端的显示不会实时刷新，所以这里继续判断
        $items_string = json_decode($input['items_string']);
        foreach ($items_string as $value) {
            if ($value->poitemc_id > 0 && $value->quantity > 0)
            {
                $poitemc = Poitemc::find($value->poitemc_id);
                if (isset($poitemc))
                {
                    if ($poitemc->quantity < ($poitemc->poitems->sum('quantity') + $value->quantity))
                        dd($poitemc->material_code . '超出了最大量，无法继续分单。');
                }
            }
        }

//        dd($input);
        $purchaseorder = Purchaseorder::create($input);
        // 创建明细信息
        if (isset($purchaseorder))
        {
            $items_string = json_decode($input['items_string']);
            foreach ($items_string as $value) {
                if ($value->poitemc_id > 0 && $value->quantity > 0)
                {
                    $item_array = json_decode(json_encode($value), true);
                    $item_array['pohead_id'] = $purchaseorder->id;
                    Poitem::create($item_array);
                }
            }
        }

        return redirect('purchase/purchaseorders');
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
        $purchaseorder = Purchaseorder::findOrFail($id);
        return view('purchase.purchaseorders.edit', compact('purchaseorder'));
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
        $purchaseorder = Purchaseorder::findOrFail($id);
        $purchaseorder->update($request->all());

//        // 临时处理：将所有的fabric_width的值赋为PO订单中的值
//        foreach ($purchaseorder->poitems as $poitem)
//        {
//            foreach ($poitem->poitemrolls as $poitemroll)
//            {
//                if ($poitemroll->fabric_width <= 0.0)
//                {
//                    $value = 0.0;
//                    $fabric_width = $poitem->poitemc->fabric_width;
//                    $pattern1 = '/\((\d+)/';        // 带括号
//                    $pattern2 = '/(\d+)/';          // 不带括号
//                    if (preg_match($pattern1, $fabric_width, $match))
//                        $value = $match[1];
//                    elseif (preg_match($pattern2, $fabric_width, $match))
//                        $value = $match[1];
//                    if ($value > 0.0)
//                    {
//                        $poitemroll->update(['fabric_width' => $value]);
//                    }
//                }
//            }
//        }


        return redirect('purchase/purchaseorders');
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
        Purchaseorder::destroy($id);
        return redirect('purchase/purchaseorders');
    }

    public function detail($id)
    {
        $poitems = Poitem::latest('created_at')->where('pohead_id', $id)->paginate(10);
        return view('purchase.poitems.index', compact('poitems', 'id'));
    }

    public function packing($id)
    {
        $poitems = Poitem::where('pohead_id', $id)->paginate(10);
        return view('purchase.purchaseorders.packing', compact('poitems', 'id'));
    }

    public function getitemsbyorderkey($key = "")
    {
        //
        $purchaseorders = Purchaseorder::where(function ($query) use ($key) {
                $query->where('number', 'like', '%'.$key.'%')
//                    ->orWhere('descrip', 'like', '%'.$key.'%')
                ;
            })->orderBy('created_at', 'desc')
            ->paginate(20);
        return $purchaseorders;
    }

    public function exportcontract($id)
    {
        Excel::load('exceltemplate/contract.xlsx', function ($reader) use ($id) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $pohead = Purchaseorder::find($id);
            if (isset($pohead))
            {
                $sheet->setCellValue('E2', "合同编号NO：" . $pohead->number);
                $orderdate = Carbon::parse($pohead->orderdate);
                $submitdate = Carbon::parse($pohead->submitdate);
                $sheet->setCellValue('A3', "From:无锡金茂/彭文琴 " . $orderdate->format('Y.m.d'));

                $detail_startrow = 10;
                $detail_row = $detail_startrow;
                $poitems = $pohead->poitems;
                $currentitemcount = 1;
                foreach ($poitems as $poitem)
                {
                    if ($currentitemcount > 1)
                    {
                        $sheet->insertNewRowBefore($detail_row, 5);
                    }
                    $sheet->setCellValue('A' . $detail_row, $poitem->chinesedescrip);
                    $fabric_description = trim($poitem->poitemc->fabric_description);
                    $sheet->setCellValue('B' . $detail_row, $poitem->poitemc->yarn_count . " " . $poitem->poitemc->construction . " " . $poitem->poitemc->fabric_width);
                    $sheet->setCellValue('A' . ($detail_row+1), substr($fabric_description, 0, strpos($fabric_description, "::")));
                    $sheet->setCellValue('G' . ($detail_row+1), $submitdate->format('Y.m.d'));
                    $sheet->setCellValue('A' . ($detail_row+2), substr($fabric_description, strpos($fabric_description, "::") + 2, strrpos($fabric_description, "::") - strpos($fabric_description, "::") - 2));
                    $sheet->setCellValue('B' . ($detail_row+3), $poitem->poitemc->color_desc1);
                    $sheet->setCellValue('C' . ($detail_row+3), $poitem->poitemc->pattern);
                    $sheet->setCellValue('D' . ($detail_row+3), $poitem->quantity);
                    $sheet->setCellValue('E' . ($detail_row+3), $poitem->unitprice);
                    $sheet->setCellValue('F' . ($detail_row+3), "=D".($detail_row+3)."*E".($detail_row+3));

                    $detail_row += 5;
                    $currentitemcount += 1;
                    Log::info($detail_row);
                }
                if ($detail_row > $detail_startrow)
                {
                    $sheet->setCellValue('D' . $detail_row, "=SUM(D".$detail_startrow.":D".($detail_row-1).")");
                    $sheet->setCellValue('F' . $detail_row, "=SUM(F".$detail_startrow.":F".($detail_row-1).")");
                    $sheet->setCellValue('B' . ($detail_row+11), '=C'.$detail_row.'&"码/"&E'.$detail_row.'&"元"');
                }

                $current_row = $detail_startrow + ($currentitemcount-1) * 5 + 33;
                $today = Carbon::today();
                $sheet->setCellValue('F' . $current_row, $today->year . "年");
                $sheet->setCellValue('G' . $current_row, $today->month . "月" . $today->day . "日");
            }

        })->export('xlsx');
    }

    public function importpacking($pohead_id)
    {
        //
        return view('purchase.purchaseorders.importpacking', compact('pohead_id'));
    }

    public function storeimportpacking(Request $request, $pohead_id)
    {
        //
//        $input = $request->all();
        $pohead = Purchaseorder::findOrFail($pohead_id);
        $file = $request->file('file');
        $excel = [];
//        Log::info($file->getPathName());
//        Log::info($file->getRealPath());
//        Log::info($request->getSession().getServletContext()->getReadPath("/xx"));

        $sheet_index = 0;

        // !! set config/excel.php
        // 'force_sheets_collection' => true,   // !!
        Excel::load($file->getRealPath(), function ($reader) use (&$excel, &$sheet_index, $pohead) {
            $objExcel = $reader->getExcel();
            $reader->each(function ($sheet) use (&$objExcel, &$sheet_index, $pohead) {
                $sh = $objExcel->getSheet($sheet_index);
//                Log::info($sh);
                if ($sheet_index == 0)
                {
                    $value_B2 = $sh->getCell('B2')->getValue();
                    Log::info('value_B2: ' . $value_B2);
                    if ($value_B2 != $pohead->poheadc->purchase_order_number)
                        dd('导入的文件信息与该客户订单不符。');
                }
                else
                {
                    $rowindex = 2;
                    $sheet->each(function ($row) use (&$rowindex, &$shipment, &$reader, $pohead) {
                        Log::info($row);
                        if ($rowindex > 3)
                        {
                            Log::info($rowindex);
                            $input = array_values($row->toArray());
//                        dd($input);
                            if (count($input) >= 6)
                            {
                                if (!empty($input[2]))
                                {
                                    $patt_color = $input[2];
                                    $color = trim(substr($patt_color, strpos($patt_color, " ") + 2));
                                    Log::info('color: ' . $color);
                                    $poitem = Poitem::leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id')
                                        ->where('pohead_id', $pohead->id)->where('poitemcs.color_desc1', $color)->select('poitems.*')->first();
                                    if (isset($poitem))
                                    {
                                        $data = [];
                                        $data['poitem_id'] = $poitem->id;
                                        $data['roll_number'] = $input[1];
                                        $data['quantity_shipped'] = $input[3];
                                        $data['gross_weight'] = $input[4];
                                        $data['gross_unit'] = 'KG';
                                        $data['fabric_width'] = $poitem->fabric_width();
                                        $data['qa_status'] = 'ACCEPT';
                                        $data['net_weight'] = $input[5];
                                        $data['net_unit'] = 'KG';

                                        $nextid = 1;
                                        $last_poitemroll = Poitemroll::orderBy('id', 'desc')->first();
                                        if (isset($last_poitemroll))
                                            $nextid = $last_poitemroll->id + 1;
                                        $nextid = str_pad($nextid, 7, '0', STR_PAD_LEFT);
                                        $ucc_number = config('custom.edi.ucc_pre') . $nextid;
                                        //            Log::info('ucc number before: ' . $ucc_number);
                                        $ucc_number .= PoitemController::checksum($ucc_number);
                                        $data['ucc_number'] = $ucc_number;

                                        $data['dyelotseries'] = $input[0];
//                                        dd($data);
                                        $poitemroll = Poitemroll::create($data);
                                    }
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
//                                    Shipmentitem::create($input);
                                    }
                                }
                            }
                        }
                        $rowindex++;
                    });
                }
                $sheet_index++;
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

        return redirect('purchase/purchaseorders');
    }
}
