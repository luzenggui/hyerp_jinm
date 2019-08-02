<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Asn;
use App\Models\Purchase\Asnitem;
use App\Models\Purchase\Asnorder;
use App\Models\Purchase\Asnshipment;
use App\Models\Purchase\Poitemroll;
use App\Models\Purchase\Purchaseorder;
use App\Models\Purchase\Uservendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel, Log, Auth;
use Illuminate\Support\Facades\Artisan;

class AsnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $asns = $this->searchrequest($request);
        $inputs = $request->all();
//        $asns = Asn::latest('created_at')->paginate(10);
        return view('purchase.asns.index', compact('asns', 'inputs'));
    }

    public function searchrequest($request)
    {
//        dd($request->all());
        $query = Asn::latest('created_at');

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
            $pohead_ids = Purchaseorder::whereIn('vendor_id', $vendor_ids)->pluck('id');
            $asnshipment_ids = Asnorder::whereIn('pohead_id', $pohead_ids)->pluck('asnshipment_id');
            $asn_ids = Asnshipment::whereIn('id', $asnshipment_ids)->pluck('asn_id');
//            dd($vendor_ids);
            $query->whereIn('id', $asn_ids);
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
        return view('purchase.asns.create');
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
        $input = $request->all();
        if (!$request->has('interchange_datetime'))
            $input['interchange_datetime'] = Carbon::now()->toDateTimeString();
        $maxasn = Asn::OrderBy('interchange_control_number', 'desc')->first();
        $maxnum = 1;
        if (isset($maxasn))
            $maxnum = $maxasn->interchange_control_number + 1;
        $maxnum = str_pad($maxnum, 9, "0", STR_PAD_LEFT);
        $input['interchange_control_number'] = $maxnum;
        if (!$request->has('data_interchange_datetime'))
            $input['data_interchange_datetime'] = Carbon::now()->toDateTimeString();
        if (!$request->has('transaction_set_control_no'))
            $input['transaction_set_control_no'] = "0001";
//        dd($input);

        $asn = Asn::create($input);
        if (isset($asn))
        {
            $input['asn_id'] = $asn->id;
            if (isset($input['gross_unit']))
                $input['gross_unit'] = strtoupper($input['gross_unit']);
            $asnshipment = Asnshipment::create($input);

            if (isset($asnshipment))
            {
                $input['asnshipment_id'] = $asnshipment->id;
                Asnorder::create($input);
            }
        }

        return redirect('purchase/asns');
    }

    public function packingstore(Request $request)
    {
        //
        $input = $request->all();
        if (strlen($input['items_string']) < 1)
            dd('未设置任何打包数据，保存ASN失败。');

        $number = Carbon::now()->toDateTimeString();
        $input['number'] = $number;

        $asn = Asn::create($input);

        if (isset($asn))
        {
            $asnitems = json_decode($input['items_string']);
            foreach ($asnitems as $asnitem) {
                $item_array = json_decode(json_encode($asnitem), true);
                $item_array['asn_id'] = $asn->id;

                Asnitem::create($item_array);
            }
        }
        return redirect('purchase/asns');
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
        $asn = Asn::findOrFail($id);
        return view('purchase.asns.edit', compact('asn'));
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
        $asn = Asn::findOrFail($id);
        $asn->update($request->all());

        $input = $request->all();
        if (isset($input['gross_unit']))
            $input['gross_unit'] = strtoupper($input['gross_unit']);
        $asn->asnshipments->first()->update($input);

        $asn->asnshipments->first()->asnorders->first()->update($input);

        return redirect('purchase/asns');
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
        Asn::destroy($id);
        return redirect('purchase/asns');
    }

    public function detail($id)
    {
        $asnitems = Asnitem::where('asn_id', $id)->paginate(10);
        return view('purchase.asnitems.index', compact('asnitems', 'id'));
    }

    public function asnshipments($id)
    {
        $asnshipments = Asnshipment::where('asn_id', $id)->paginate(10);
        return view('purchase.asnshipments.index', compact('asnshipments', 'id'));
    }

    public function labelpreprint($id)
    {
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T");
//        echo '<img src="data:image/png,' . DNS1D::getBarcodePNG("4", "C39+") . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T");

//        echo DNS1D::getBarcodeSVG("4445645656", "C39");
//        echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
//        echo DNS2D::getBarcodePNGPath("4445645656", "PDF417");
//        echo DNS2D::getBarcodeSVG("4445645656", "DATAMATRIX");
//        echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG("4", "PDF417") . '" alt="barcode"   />';

        // Width and Height example
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33);
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33);
//        echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33);
//        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';

        // Color
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33,"green");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33,"green");
//        echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1)) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0));
//        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1)) . '" alt="barcode"   />';

        // Show Text
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33,"green", true);
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33,"green", true);
//        echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0), true);
//        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodeHTML("4445645656", "C128");

        // 2D Barcodes
//        echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
//        echo DNS2D::getBarcodePNGPath("4445645656", "PDF417");
//        echo DNS2D::getBarcodeSVG("4445645656", "DATAMATRIX");

        // 1D Barcodes
//        echo DNS1D::getBarcodeHTML("4445645656", "C39");
//        echo DNS1D::getBarcodeHTML("4445645656", "C39+");
//        echo DNS1D::getBarcodeHTML("4445645656", "C39E");
//        echo DNS1D::getBarcodeHTML("4445645656", "C39E+");
//        echo DNS1D::getBarcodeHTML("4445645656", "C93");
//        echo DNS1D::getBarcodeHTML("4445645656", "S25");
//        echo DNS1D::getBarcodeHTML("4445645656", "S25+");
//        echo DNS1D::getBarcodeHTML("4445645656", "I25");
//        echo DNS1D::getBarcodeHTML("4445645656", "I25+");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128A");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128B");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128C");
//        echo DNS1D::getBarcodeHTML("44455656", "EAN2");
//        echo DNS1D::getBarcodeHTML("4445656", "EAN5");
//        echo DNS1D::getBarcodeHTML("4445", "EAN8");
//        echo DNS1D::getBarcodeHTML("4445", "EAN13");
//        echo DNS1D::getBarcodeHTML("4445645656", "UPCA");
//        echo DNS1D::getBarcodeHTML("4445645656", "UPCE");
//        echo DNS1D::getBarcodeHTML("4445645656", "MSI");
//        echo DNS1D::getBarcodeHTML("4445645656", "MSI+");
//        echo DNS1D::getBarcodeHTML("4445645656", "POSTNET");
//        echo DNS1D::getBarcodeHTML("4445645656", "PLANET");
//        echo DNS1D::getBarcodeHTML("4445645656", "RMS4CC");
//        echo DNS1D::getBarcodeHTML("4445645656", "KIX");
//        echo DNS1D::getBarcodeHTML("4445645656", "IMB");
//        echo DNS1D::getBarcodeHTML("4445645656", "CODABAR");
//        echo DNS1D::getBarcodeHTML("4445645656", "CODE11");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T");

        $asn = Asn::findOrFail($id);
        $asnitems = Asnitem::where('asn_id', $id)->paginate(10);
        return view('purchase.asns.labelpreprint', compact('asn', 'asnitems', 'id'));
    }

    public function labelprint($id)
    {
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T");
//        echo '<img src="data:image/png,' . DNS1D::getBarcodePNG("4", "C39+") . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T");

//        echo DNS1D::getBarcodeSVG("4445645656", "C39");
//        echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
//        echo DNS2D::getBarcodePNGPath("4445645656", "PDF417");
//        echo DNS2D::getBarcodeSVG("4445645656", "DATAMATRIX");
//        echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG("4", "PDF417") . '" alt="barcode"   />';

        // Width and Height example
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33);
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33);
//        echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33);
//        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';

        // Color
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33,"green");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33,"green");
//        echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1)) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0));
//        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1)) . '" alt="barcode"   />';

        // Show Text
//        echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33,"green", true);
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33,"green", true);
//        echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0), true);
//        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />';
//        echo DNS1D::getBarcodeHTML("4445645656", "C128");

        // 2D Barcodes
//        echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
//        echo DNS2D::getBarcodePNGPath("4445645656", "PDF417");
//        echo DNS2D::getBarcodeSVG("4445645656", "DATAMATRIX");

        // 1D Barcodes
//        echo DNS1D::getBarcodeHTML("4445645656", "C39");
//        echo DNS1D::getBarcodeHTML("4445645656", "C39+");
//        echo DNS1D::getBarcodeHTML("4445645656", "C39E");
//        echo DNS1D::getBarcodeHTML("4445645656", "C39E+");
//        echo DNS1D::getBarcodeHTML("4445645656", "C93");
//        echo DNS1D::getBarcodeHTML("4445645656", "S25");
//        echo DNS1D::getBarcodeHTML("4445645656", "S25+");
//        echo DNS1D::getBarcodeHTML("4445645656", "I25");
//        echo DNS1D::getBarcodeHTML("4445645656", "I25+");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128A");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128B");
//        echo DNS1D::getBarcodeHTML("4445645656", "C128C");
//        echo DNS1D::getBarcodeHTML("44455656", "EAN2");
//        echo DNS1D::getBarcodeHTML("4445656", "EAN5");
//        echo DNS1D::getBarcodeHTML("4445", "EAN8");
//        echo DNS1D::getBarcodeHTML("4445", "EAN13");
//        echo DNS1D::getBarcodeHTML("4445645656", "UPCA");
//        echo DNS1D::getBarcodeHTML("4445645656", "UPCE");
//        echo DNS1D::getBarcodeHTML("4445645656", "MSI");
//        echo DNS1D::getBarcodeHTML("4445645656", "MSI+");
//        echo DNS1D::getBarcodeHTML("4445645656", "POSTNET");
//        echo DNS1D::getBarcodeHTML("4445645656", "PLANET");
//        echo DNS1D::getBarcodeHTML("4445645656", "RMS4CC");
//        echo DNS1D::getBarcodeHTML("4445645656", "KIX");
//        echo DNS1D::getBarcodeHTML("4445645656", "IMB");
//        echo DNS1D::getBarcodeHTML("4445645656", "CODABAR");
//        echo DNS1D::getBarcodeHTML("4445645656", "CODE11");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA");
//        echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T");

        $asn = Asn::findOrFail($id);
//        $asnitems = Asnitem::where('asn_id', $id)->paginate(10);
        return view('purchase.asns.labelprint', compact('asn'));
    }

    public function export(Request $request, $asn_id)
    {
        //
        $input = $request->all();
//        dd($input);

        Excel::load('exceltemplate/PACKING LIST.xlsx', function ($reader) use ($asn_id) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $asn = Asn::find($asn_id);
            if (isset($asn))
            {
                $asnshipment = $asn->asnshipments->first();
                if ($asnshipment)
                {
//                    $sheet->setCellValue('B4', $asnshipment->shipper_name);
                    $sheet->setCellValue('B8', $asn->asn_number);
                    $ship_date = Carbon::parse($asnshipment->ship_date);
                    $sheet->setCellValue('F8', $ship_date->format('M d, Y'));
                    $asnorder = $asnshipment->asnorders->first();
                    if (isset($asnorder))
                    {
                        $pohead = $asnorder->pohead;
                        if (isset($pohead))
                        {
                            $poheadc = $pohead->poheadc;
                            if (isset($poheadc))
                            {
                                $sheet->setCellValue('B9', $poheadc->buyer_name);

                                $sheet->setCellValue('B13', $poheadc->ship_to);
                                $sheet->setCellValue('B14', $poheadc->ship_to_address1);
                                $sheet->setCellValue('B15', $poheadc->ship_to_address2);
//                                $sheet->setCellValue('C25', $poheadc->purchase_order_number);
                            }
                        }

                        $asnpackagings = $asnorder->asnpackagings;
                        $rollcount_total = 0;
                        $grossweight_total_total = 0.0;
                        $netweight_total_total = 0.0;
                        $quantity_total_total = 0;
                        $detail_startrow = 19;
                        $detail_row = $detail_startrow;
                        $currentitemcount = 1;
                        foreach ($asnpackagings as $asnpackaging)
                        {
                            if ($currentitemcount > 1)
                            {
                                $sheet->insertNewRowBefore($detail_row, 5);

                                $sheet->setCellValue('A' . ($detail_row+2), $sheet->getCell('A'.($detail_row+2-5))->getValue());
                                $sheet->setCellValue('B' . ($detail_row+2), $sheet->getCell('B'.($detail_row+2-5))->getValue());
                                $sheet->setCellValue('D' . ($detail_row+2), $sheet->getCell('D'.($detail_row+2-5))->getValue());
                                $sheet->setCellValue('E' . ($detail_row+2), $sheet->getCell('E'.($detail_row+2-5))->getValue());
                                $sheet->setCellValue('F' . ($detail_row+2), $sheet->getCell('F'.($detail_row+2-5))->getValue());
                                $sheet->setCellValue('G' . ($detail_row+2), $sheet->getCell('G'.($detail_row+2-5))->getValue());
                            }

                            $sheet->setCellValue('B' . $detail_row, $asnpackaging->poitem->poitemc->fabric_sequence_no . ")" . $asnpackaging->poitem->poitemc->fabric_description);
                            $sheet->setCellValue('B' . ($detail_row+1),"AS PER APPLICANT'S PURCHASE ORDER NO. " . $asnpackaging->poitem->poitemc->poheadc->purchase_order_number);

                            $grossweight_total = 0.0;
                            $netweight_total = 0.0;
                            $quantity_total = 0;
                            $rollcount = $asnpackaging->asnitems->count();
                            foreach ($asnpackaging->asnitems as $asnitem)
                            {
                                $grossweight_total += $asnitem->poitemroll->gross_weight;
                                $netweight_total += $asnitem->poitemroll->net_weight;
                                $quantity_total += $asnitem->poitemroll->quantity_shipped;
                            }
                            $sheet->setCellValue('A' . ($detail_row+3), $rollcount . 'ROLLS');
                            $sheet->setCellValue('B' . ($detail_row+3), $asnpackaging->poitem->poitemc->color_desc1);
                            $sheet->setCellValue('D' . ($detail_row+3), $quantity_total);
                            $sheet->setCellValue('E' . ($detail_row+3), "@" . number_format($grossweight_total / $quantity_total, 2));
                            $sheet->setCellValue('F' . ($detail_row+3), "@" . number_format($netweight_total / $quantity_total, 2));
                            $grossweight_total_total += $grossweight_total;
                            $netweight_total_total += $netweight_total;
                            $quantity_total_total += $quantity_total;
                            $rollcount_total += $rollcount;

                            $detail_row += 5;
                            $currentitemcount += 1;
                        }

                        $sheet->setCellValue('B' . $detail_row, $quantity_total_total);
                        $sheet->setCellValue('D' . $detail_row, "=SUM(D22:D" . ($detail_row-1) . ")");
                        $sheet->setCellValue('E' . $detail_row, $grossweight_total_total . "KGS");
                        $sheet->setCellValue('F' . $detail_row, $netweight_total_total . "KGS");
                        $sheet->setCellValue('A' . ($detail_row+2), 'TOTAL PACKED IN ' . $rollcount_total . ' ROLLS');
                        $sheet->setCellValue('A' . ($detail_row+3), 'TOTAL QUANTITY: ' . $quantity_total_total . 'YDS');
                        $sheet->setCellValue('A' . ($detail_row+4), 'TOTAL G.WT: ' . $grossweight_total_total . 'KGS');
                        $sheet->setCellValue('A' . ($detail_row+5), 'TOTAL N.WT: ' . $netweight_total_total . 'KGS');
                    }
//                    $sheet->setCellValue('B18', $asnshipment->country_of_destination);
                }
            }

            $sheet = $objExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $asn = Asn::find($asn_id);
            if (isset($asn))
            {
                $asnshipment = $asn->asnshipments->first();
                if ($asnshipment)
                {
                    $asnorder = $asnshipment->asnorders->first();
                    if (isset($asnorder))
                    {
                        $pohead = $asnorder->pohead;
                        if (isset($pohead))
                        {
                            $poheadc = $pohead->poheadc;
                            if (isset($poheadc))
                            {
                            }
                        }

                        $asnpackagings = $asnorder->asnpackagings;
                        $rollcount = 0;
                        $grossweight_total = 0.0;
                        $netweight_total = 0.0;
                        $quantity_total = 0;
                        $item_row = 4;
                        foreach ($asnpackagings as $asnpackaging)
                        {
                            $rollcount += $asnpackaging->asnitems->count();
                            foreach ($asnpackaging->asnitems as $asnitem)
                            {
                                $sheet->setCellValue('B' . $item_row, '-' . $asnitem->poitemroll->roll_number);
                                $sheet->setCellValue('C' . $item_row, $asnpackaging->poitem->poitemc->material_code);
                                $sheet->setCellValue('D' . $item_row, $asnitem->poitemroll->quantity_shipped);
                                $sheet->setCellValue('E' . $item_row, $asnitem->poitemroll->net_weight);
                                $sheet->setCellValue('G' . $item_row, $asnitem->poitemroll->net_weight);
                                $grossweight_total += $asnitem->poitemroll->gross_weight;
                                $netweight_total += $asnitem->poitemroll->net_weight;
                                $quantity_total += $asnitem->poitemroll->quantity_shipped;
                                $item_row++;
                            }
                        }
                    }
                }
            }
        })->export('xlsx');

//        Excel::load('exceltemplate/DPL.XLS', function ($reader) use ($asn_id) {
//            $objExcel = $reader->getExcel();
//            $sheet = $objExcel->getSheet(0);
//            $highestRow = $sheet->getHighestRow();
//            $highestColumn = $sheet->getHighestColumn();
//
//            $asn = Asn::find($asn_id);
//            if (isset($asn))
//            {
//                $asnshipment = $asn->asnshipments->first();
//                if ($asnshipment)
//                {
//                    $asnorder = $asnshipment->asnorders->first();
//                    if (isset($asnorder))
//                    {
//                        $pohead = $asnorder->pohead;
//                        if (isset($pohead))
//                        {
//                            $poheadc = $pohead->poheadc;
//                            if (isset($poheadc))
//                            {
//                            }
//                        }
//
//                        $asnpackagings = $asnorder->asnpackagings;
//                        $rollcount = 0;
//                        $grossweight_total = 0.0;
//                        $netweight_total = 0.0;
//                        $quantity_total = 0;
//                        $item_row = 4;
//                        foreach ($asnpackagings as $asnpackaging)
//                        {
//                            $rollcount += $asnpackaging->asnitems->count();
//                            foreach ($asnpackaging->asnitems as $asnitem)
//                            {
//                                $sheet->setCellValue('B' . $item_row, '-' . $asnitem->poitemroll->roll_number);
//                                $sheet->setCellValue('C' . $item_row, $asnpackaging->poitem->poitemc->material_code);
//                                $sheet->setCellValue('D' . $item_row, $asnitem->poitemroll->quantity_shipped);
//                                $sheet->setCellValue('E' . $item_row, $asnitem->poitemroll->net_weight);
//                                $sheet->setCellValue('G' . $item_row, $asnitem->poitemroll->net_weight);
//                                $grossweight_total += $asnitem->poitemroll->gross_weight;
//                                $netweight_total += $asnitem->poitemroll->net_weight;
//                                $quantity_total += $asnitem->poitemroll->quantity_shipped;
//                                $item_row++;
//                            }
//                        }
//                    }
//                }
//            }
//
//        })->export('xlsx');



    }

    public function exportpackinglist(Request $request)
    {
        //
//        $input = $request->all();
//        dd($input);
        $ids = [];
        if ($request->has('ids'))
            $ids = explode(",", $request->input('ids'));
        if (count($ids) < 1)
            dd('未选择ASN');

        Excel::load('exceltemplate/PACKING LIST.xlsx', function ($reader) use ($ids) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $detail_startrow = 19;
            $detail_row = $detail_startrow;
            $currentitemcount = 1;
            $rollcount_total = 0;
            $grossweight_total_total = 0.0;
            $netweight_total_total = 0.0;
            $quantity_total_total = 0;
            foreach ($ids as $id)
            {
                $asn = Asn::find($id);
                if (isset($asn))
                {
                    Log::info($asn->id);
                    $asnshipment = $asn->asnshipments->first();
                    if ($asnshipment)
                    {
//                    $sheet->setCellValue('B4', $asnshipment->shipper_name);
                        $sheet->setCellValue('B8', substr($asn->asn_number, 0, 13));
                        $ship_date = Carbon::parse($asnshipment->ship_date);
                        $sheet->setCellValue('F8', $ship_date->format('M d, Y'));
                        $asnorder = $asnshipment->asnorders->first();
                        if (isset($asnorder))
                        {
                            $pohead = $asnorder->pohead;
                            if (isset($pohead))
                            {
                                $poheadc = $pohead->poheadc;
                                if (isset($poheadc))
                                {
                                    $sheet->setCellValue('B9', $poheadc->buyer_name);

                                    $sheet->setCellValue('B13', $poheadc->ship_to);
                                    $sheet->setCellValue('B14', $poheadc->ship_to_address1);
                                    $sheet->setCellValue('B15', $poheadc->ship_to_address2);
//                                $sheet->setCellValue('C25', $poheadc->purchase_order_number);
                                }
                            }

                            $asnpackagings = $asnorder->asnpackagings;
                            Log::info('detail_row: ' . $detail_row);
                            foreach ($asnpackagings as $asnpackaging)
                            {
                                if ($currentitemcount > 1)
                                {
                                    $sheet->insertNewRowBefore($detail_row, 5);

                                    $sheet->setCellValue('A' . ($detail_row+2), $sheet->getCell('A'.($detail_row+2-5))->getValue());
                                    $sheet->setCellValue('B' . ($detail_row+2), $sheet->getCell('B'.($detail_row+2-5))->getValue());
                                    $sheet->setCellValue('D' . ($detail_row+2), $sheet->getCell('D'.($detail_row+2-5))->getValue());
                                    $sheet->setCellValue('E' . ($detail_row+2), $sheet->getCell('E'.($detail_row+2-5))->getValue());
                                    $sheet->setCellValue('F' . ($detail_row+2), $sheet->getCell('F'.($detail_row+2-5))->getValue());
                                    $sheet->setCellValue('G' . ($detail_row+2), $sheet->getCell('G'.($detail_row+2-5))->getValue());
                                }

                                Log::info('B' . $detail_row . ':' . $asnpackaging->poitem->poitemc->fabric_sequence_no . ")" . $asnpackaging->poitem->poitemc->fabric_description);
                                $sheet->setCellValue('B' . $detail_row, $asnpackaging->poitem->poitemc->fabric_sequence_no . ")" . $asnpackaging->poitem->poitemc->fabric_description);
                                $sheet->setCellValue('B' . ($detail_row+1),"AS PER APPLICANT'S PURCHASE ORDER NO. " . $asnpackaging->poitem->poitemc->poheadc->purchase_order_number);

                                $grossweight_total = 0.0;
                                $netweight_total = 0.0;
                                $quantity_total = 0;
                                $rollcount = $asnpackaging->asnitems->count();
                                foreach ($asnpackaging->asnitems as $asnitem)
                                {
                                    $grossweight_total += $asnitem->poitemroll->gross_weight;
                                    $netweight_total += $asnitem->poitemroll->net_weight;
                                    $quantity_total += $asnitem->poitemroll->quantity_shipped;
                                }
                                $sheet->setCellValue('A' . ($detail_row+3), $rollcount . 'ROLLS');
                                $sheet->setCellValue('B' . ($detail_row+3), $asnpackaging->poitem->poitemc->color_desc1);
                                $sheet->setCellValue('D' . ($detail_row+3), $quantity_total);
                                $sheet->setCellValue('E' . ($detail_row+3), "@" . number_format($grossweight_total / $quantity_total, 2));
                                $sheet->setCellValue('F' . ($detail_row+3), "@" . number_format($netweight_total / $quantity_total, 2));
                                $grossweight_total_total += $grossweight_total;
                                $netweight_total_total += $netweight_total;
                                $quantity_total_total += $quantity_total;
                                $rollcount_total += $rollcount;

                                $detail_row += 5;
                                $currentitemcount += 1;
                            }
                        }
//                    $sheet->setCellValue('B18', $asnshipment->country_of_destination);
                    }
                }

//                $sheet = $objExcel->getSheet(1);
//                $highestRow = $sheet->getHighestRow();
//                $highestColumn = $sheet->getHighestColumn();
//
//                $asn = Asn::find($id);
//                if (isset($asn))
//                {
//                    $asnshipment = $asn->asnshipments->first();
//                    if ($asnshipment)
//                    {
//                        $asnorder = $asnshipment->asnorders->first();
//                        if (isset($asnorder))
//                        {
//                            $pohead = $asnorder->pohead;
//                            if (isset($pohead))
//                            {
//                                $poheadc = $pohead->poheadc;
//                                if (isset($poheadc))
//                                {
//                                }
//                            }
//
//                            $asnpackagings = $asnorder->asnpackagings;
//                            $rollcount = 0;
//                            $grossweight_total = 0.0;
//                            $netweight_total = 0.0;
//                            $quantity_total = 0;
//                            $item_row = 4;
//                            foreach ($asnpackagings as $asnpackaging)
//                            {
//                                $rollcount += $asnpackaging->asnitems->count();
//                                foreach ($asnpackaging->asnitems as $asnitem)
//                                {
//                                    $sheet->setCellValue('B' . $item_row, '-' . $asnitem->poitemroll->roll_number);
//                                    $sheet->setCellValue('C' . $item_row, $asnpackaging->poitem->poitemc->material_code);
//                                    $sheet->setCellValue('D' . $item_row, $asnitem->poitemroll->quantity_shipped);
//                                    $sheet->setCellValue('E' . $item_row, $asnitem->poitemroll->net_weight);
//                                    $sheet->setCellValue('G' . $item_row, $asnitem->poitemroll->net_weight);
//                                    $grossweight_total += $asnitem->poitemroll->gross_weight;
//                                    $netweight_total += $asnitem->poitemroll->net_weight;
//                                    $quantity_total += $asnitem->poitemroll->quantity_shipped;
//                                    $item_row++;
//                                }
//                            }
//                        }
//                    }
//                }
            }

            $sheet->setCellValue('B' . $detail_row, $rollcount_total);
            $sheet->setCellValue('D' . $detail_row, "=SUM(D22:D" . ($detail_row-1) . ")");
            $sheet->setCellValue('E' . $detail_row, $grossweight_total_total . "KGS");
            $sheet->setCellValue('F' . $detail_row, $netweight_total_total . "KGS");
            $sheet->setCellValue('A' . ($detail_row+2), 'TOTAL PACKED IN ' . $rollcount_total . ' ROLLS');
            $sheet->setCellValue('A' . ($detail_row+3), 'TOTAL QUANTITY: ' . $quantity_total_total . 'YDS');
            $sheet->setCellValue('A' . ($detail_row+4), 'TOTAL G.WT: ' . $grossweight_total_total . 'KGS');
            $sheet->setCellValue('A' . ($detail_row+5), 'TOTAL N.WT: ' . $netweight_total_total . 'KGS');

            $detail_row += 8;
            $colarr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $col_index = 1;
            foreach ($ids as $id)
            {
                $asn = Asn::find($id);
                if (isset($asn))
                {
                    $asnshipment = $asn->asnshipments->first();
                    if ($asnshipment)
                    {
//                    $sheet->setCellValue('B4', $asnshipment->shipper_name);
                        $sheet->setCellValue('B8', substr($asn->asn_number, 0, 13));
                        $ship_date = Carbon::parse($asnshipment->ship_date);
                        $sheet->setCellValue('F8', $ship_date->format('M d, Y'));
                        $asnorder = $asnshipment->asnorders->first();
                        if (isset($asnorder))
                        {
                            $pohead = $asnorder->pohead;
                            if (isset($pohead))
                            {
                                $poheadc = $pohead->poheadc;
                                if (isset($poheadc))
                                {
                                    $col_index++;
                                    $sheet->setCellValue($colarr[$col_index] . $detail_row, $poheadc->destination_country);
                                    $sheet->setCellValue($colarr[$col_index] . ($detail_row+1), $poheadc->purchase_order_number);
                                }
                            }
                        }
//                    $sheet->setCellValue('B18', $asnshipment->country_of_destination);
                    }
                }
            }
        })->export('xlsx');
    }

    public function exportdpl(Request $request)
    {
        //
//        $input = $request->all();
//        dd($input);
        $ids = [];
        if ($request->has('ids'))
            $ids = explode(",", $request->input('ids'));
        if (count($ids) < 1)
            dd('未选择ASN');

        Excel::create('DPL', function($excel) use ($ids) {
            Excel::load('exceltemplate/DPL.xlsx', function ($reader) use ($ids, $excel) {
                $objExcel = $reader->getExcel();
//                $sheet_src = $objExcel->getSheet(0);
                $sheetNames = $objExcel->getSheetNames();

                $rollcount_total = 0;
                $grossweight_total_total = 0.0;
                $netweight_total_total = 0.0;
                $quantity_total_total = 0;
                foreach ($ids as $id)
                {
                    $asn = Asn::find($id);
                    if (isset($asn))
                    {
                        Log::info($asn->id);
                        $asnshipment = $asn->asnshipments->first();
                        if ($asnshipment)
                        {
//                        $sheet->setCellValue('B8', substr($asn->asn_number, 0, 13));
//                        $ship_date = Carbon::parse($asnshipment->ship_date);
//                        $sheet->setCellValue('F8', $ship_date->format('M d, Y'));
                            $asnorder = $asnshipment->asnorders->first();
                            if (isset($asnorder))
                            {
                                $pohead = $asnorder->pohead;
                                if (isset($pohead))
                                {
                                    $poheadc = $pohead->poheadc;
                                    if (isset($poheadc))
                                    {
//                                    $sheet->setCellValue('C2', $poheadc->purchase_order_number);
                                    }
                                }

                                $asnpackagings = $asnorder->asnpackagings;
                                $i = -1;
                                foreach ($asnpackagings as $asnpackaging)
                                {
                                    $i++;
                                    $sheet_src = $objExcel->getSheetByName($sheetNames[$i]);
                                    if (isset($sheet_src))
                                    {
                                        $sheetname = $asnpackaging->poitem->poitemc->material_code;
                                        $sheet_src->setTitle($sheetname);
//                                Log::info($sheet_src->getTitle());
                                        $excel->addExternalSheet($sheet_src);
                                        $sheet_src->setCellValue('C2', $asnpackaging->poitem->poitemc->poheadc->purchase_order_number);
                                        $grossweight_total = 0.0;
                                        $netweight_total = 0.0;
                                        $quantity_total = 0;
                                        $rollcount = $asnpackaging->asnitems->count();
                                        $detail_row = 4;
                                        foreach ($asnpackaging->asnitems as $asnitem)
                                        {
                                            $sheet_src->insertNewRowBefore($detail_row, 1);
                                            $sheet_src->setCellValue('A' . $detail_row, $asnitem->poitemroll->dyelotseries);
                                            $sheet_src->setCellValue('B' . $detail_row, '-' . $asnitem->poitemroll->roll_number);
                                            $sheet_src->setCellValue('C' . $detail_row, $asnpackaging->poitem->poitemc->color_desc1);
                                            $sheet_src->setCellValue('D' . $detail_row, $asnitem->poitemroll->quantity_shipped);
                                            $sheet_src->setCellValue('E' . $detail_row, $asnitem->poitemroll->net_weight);
                                            $grossweight_total += $asnitem->poitemroll->gross_weight;
                                            $netweight_total += $asnitem->poitemroll->net_weight;
                                            $quantity_total += $asnitem->poitemroll->quantity_shipped;
                                            $detail_row++;
                                        }
                                        $sheet_src->setCellValue('C' . $detail_row, $rollcount . 'ROLLS');
                                        $sheet_src->setCellValue('D' . $detail_row, $quantity_total);
                                        $sheet_src->setCellValue('E' . $detail_row, $netweight_total);
                                        $detail_row++;
                                        $sheet_src->setCellValue('B' . $detail_row, "GRAM WEIGHT:" . $grossweight_total . "G/M2   NET WEIGHT:" . $netweight_total . "KGS");
                                        $detail_row++;
                                        $sheet_src->setCellValue('B' . $detail_row, "ROLL #-" . $rollcount . " CONTAINS ROLL CUTTINGS ");
                                    }
                                }
                            }
                        }
                    }
                }



//            // Set the title
//            $excel->setTitle($filename);

//            // Chain the setters
//            $excel->setCreator('HXERP')
//                ->setCompany('Huaxing East');
            });



        })->export('xlsx');





//        Excel::load('exceltemplate/DPL.xlsx', function ($reader) use ($ids) {
//            $objExcel = $reader->getExcel();
//            $sheet = $objExcel->getSheet(0);
//            $highestRow = $sheet->getHighestRow();
//            $highestColumn = $sheet->getHighestColumn();
//
//            $detail_startrow = 19;
//            $detail_row = $detail_startrow;
//            $rollcount_total = 0;
//            $grossweight_total_total = 0.0;
//            $netweight_total_total = 0.0;
//            $quantity_total_total = 0;
//            foreach ($ids as $id)
//            {
//                $asn = Asn::find($id);
//                if (isset($asn))
//                {
//                    Log::info($asn->id);
//                    $asnshipment = $asn->asnshipments->first();
//                    if ($asnshipment)
//                    {
//                        $asnorder = $asnshipment->asnorders->first();
//                        if (isset($asnorder))
//                        {
//                            $pohead = $asnorder->pohead;
//                            if (isset($pohead))
//                            {
//                                $poheadc = $pohead->poheadc;
//                                if (isset($poheadc))
//                                {
//                                    $sheet->setCellValue('C2', $poheadc->purchase_order_number);
//                                }
//                            }
//
//                            $asnpackagings = $asnorder->asnpackagings;
//                            foreach ($asnpackagings as $asnpackaging)
//                            {
//
//                                $grossweight_total = 0.0;
//                                $netweight_total = 0.0;
//                                $quantity_total = 0;
//                                $rollcount = $asnpackaging->asnitems->count();
//                                $detail_row = 4;
//                                foreach ($asnpackaging->asnitems as $asnitem)
//                                {
//                                    $sheet->insertNewRowBefore($detail_row, 1);
//                                    $sheet->setCellValue('A' . $detail_row, $asnitem->poitemroll->dyelotseries);
//                                    $sheet->setCellValue('B' . $detail_row, '-' . $asnitem->poitemroll->roll_number);
//                                    $sheet->setCellValue('C' . $detail_row, $asnpackaging->poitem->poitemc->color_desc1);
//                                    $sheet->setCellValue('D' . $detail_row, $asnitem->poitemroll->quantity_shipped);
//                                    $sheet->setCellValue('E' . $detail_row, $asnitem->poitemroll->net_weight);
////                                    $sheet->setCellValue('G' . $detail_row, $asnitem->poitemroll->net_weight);
//                                    $grossweight_total += $asnitem->poitemroll->gross_weight;
//                                    $netweight_total += $asnitem->poitemroll->net_weight;
//                                    $quantity_total += $asnitem->poitemroll->quantity_shipped;
//                                    $detail_row++;
//                                }
//                                $sheet->setCellValue('C' . $detail_row, $rollcount . 'ROLLS');
//                                $sheet->setCellValue('D' . $detail_row, $quantity_total);
//                                $sheet->setCellValue('E' . $detail_row, $netweight_total);
////                                $grossweight_total_total += $grossweight_total;
////                                $netweight_total_total += $netweight_total;
////                                $quantity_total_total += $quantity_total;
////                                $rollcount_total += $rollcount;
//                                $detail_row++;
//                                $sheet->setCellValue('B' . $detail_row, "GRAM WEIGHT:" . $grossweight_total . "G/M2   NET WEIGHT:" . $netweight_total . "KGS");
//                                $detail_row++;
//                                $sheet->setCellValue('B' . $detail_row, "ROLL #-" . $rollcount . " CONTAINS ROLL CUTTINGS ");
//
//                                $newsheet = $sheet->copy();
//                                $newsheet->setTitle("222");
////                                dd($newsheet->getTitle());
//                                $newsheet->setCellValue('B' . $detail_row, "ROLL #-" . $rollcount . " CONTAINS ROLL CUTTINGS ");
//                            }
//                        }
//                    }
//                }
//            }
//
//        })->export('xlsx');
    }

    public function exportinvoice(Request $request)
    {
        //
//        $input = $request->all();
//        dd($input);
        $ids = [];
        if ($request->has('ids'))
            $ids = explode(",", $request->input('ids'));
        if (count($ids) < 1)
            dd('未选择ASN');

        Excel::load('exceltemplate/INVOICE.xlsx', function ($reader) use ($ids) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $detail_startrow = 21;
            $rowcount_peritem = 6;
            $detail_row = $detail_startrow;
            $currentitemcount = 1;
            $rollcount_total = 0;
            $grossweight_total_total = 0.0;
            $netweight_total_total = 0.0;
            $quantity_total_total = 0;
            $amount_total = 0.0;
            foreach ($ids as $id)
            {
                $asn = Asn::find($id);
                if (isset($asn))
                {
                    Log::info($asn->id);
                    $asnshipment = $asn->asnshipments->first();
                    if ($asnshipment)
                    {
//                    $sheet->setCellValue('B4', $asnshipment->shipper_name);
                        $sheet->setCellValue('H5', substr($asn->asn_number, 0, 13));
                        $ship_date = Carbon::parse($asnshipment->ship_date);
                        $sheet->setCellValue('H7', $ship_date->format('M d, Y'));
                        $asnorder = $asnshipment->asnorders->first();
                        if (isset($asnorder))
                        {
                            $pohead = $asnorder->pohead;
                            if (isset($pohead))
                            {
                                $poheadc = $pohead->poheadc;
                                if (isset($poheadc))
                                {
//                                    $sheet->setCellValue('B9', $poheadc->buyer_name);

                                    $sheet->setCellValue('B14', $poheadc->ship_to);
                                    $sheet->setCellValue('B15', $poheadc->ship_to_address1);
                                    $sheet->setCellValue('B16', $poheadc->ship_to_address2);
                                    $sheet->setCellValue('B17', $poheadc->destination_country);
                                    $sheet->setCellValue('H16', $poheadc->purchase_order_number);
                                }
                            }

                            $asnpackagings = $asnorder->asnpackagings;
                            Log::info('detail_row: ' . $detail_row);
                            foreach ($asnpackagings as $asnpackaging)
                            {
                                if ($currentitemcount > 1)
                                {
                                    $sheet->insertNewRowBefore($detail_row, $rowcount_peritem);

                                    $sheet->setCellValue('B' . ($detail_row+3), $sheet->getCell('B'.($detail_row+3-$rowcount_peritem))->getValue());
                                    $sheet->setCellValue('D' . ($detail_row+3), $sheet->getCell('D'.($detail_row+3-$rowcount_peritem))->getValue());
                                    $sheet->setCellValue('E' . ($detail_row+3), $sheet->getCell('E'.($detail_row+3-$rowcount_peritem))->getValue());
                                    $sheet->setCellValue('F' . ($detail_row+3), $sheet->getCell('F'.($detail_row+3-$rowcount_peritem))->getValue());
                                    $sheet->setCellValue('G' . ($detail_row+3), $sheet->getCell('G'.($detail_row+3-$rowcount_peritem))->getValue());
                                    $sheet->setCellValue('H' . ($detail_row+3), $sheet->getCell('H'.($detail_row+3-$rowcount_peritem))->getValue());
                                    $sheet->setCellValue('J' . ($detail_row+3), $sheet->getCell('J'.($detail_row+3-$rowcount_peritem))->getValue());
                                }

                                Log::info('B' . $detail_row . ':' . $asnpackaging->poitem->poitemc->fabric_sequence_no . ")" . $asnpackaging->poitem->poitemc->fabric_description);
                                $sheet->setCellValue('B' . $detail_row, $asnpackaging->poitem->poitemc->fabric_sequence_no . ")" . $asnpackaging->poitem->poitemc->fabric_description);
                                $sheet->setCellValue('B' . ($detail_row+1),"AS PER APPLICANT'S PURCHASE ORDER NO. " . $asnpackaging->poitem->poitemc->poheadc->purchase_order_number);
                                $sheet->setCellValue('A' . ($detail_row+1),$asnpackaging->poitem->poitemc->poheadc->purchase_order_number);

                                $grossweight_total = 0.0;
                                $netweight_total = 0.0;
                                $quantity_total = 0;
                                $rollcount = $asnpackaging->asnitems->count();
                                foreach ($asnpackaging->asnitems as $asnitem)
                                {
                                    $grossweight_total += $asnitem->poitemroll->gross_weight;
                                    $netweight_total += $asnitem->poitemroll->net_weight;
                                    $quantity_total += $asnitem->poitemroll->quantity_shipped;
                                }
//                                $sheet->setCellValue('A' . ($detail_row+3), $rollcount . 'ROLLS');
                                $sheet->setCellValue('B' . ($detail_row+4), $asnpackaging->poitem->poitemc->color_desc1);
                                $sheet->setCellValue('D' . ($detail_row+4), $asnpackaging->poitem->poitemc->poheadc->purchase_order_number);
                                $sheet->setCellValue('E' . ($detail_row+4), $grossweight_total . "G/M2");
                                $sheet->setCellValue('F' . ($detail_row+4), $netweight_total);
                                $sheet->setCellValue('G' . ($detail_row+4), $quantity_total);
                                $sheet->setCellValue('H' . ($detail_row+4), $asnpackaging->poitem->poitemc->unit_price);
                                $sheet->setCellValue('J' . ($detail_row+4), "USD " . $asnpackaging->poitem->poitemc->unit_price * $quantity_total);
                                $grossweight_total_total += $grossweight_total;
                                $netweight_total_total += $netweight_total;
                                $quantity_total_total += $quantity_total;
                                $rollcount_total += $rollcount;
                                $amount_total += $asnpackaging->poitem->poitemc->unit_price * $quantity_total;

                                $detail_row += $rowcount_peritem;
                                $currentitemcount += 1;
                            }
                        }
//                    $sheet->setCellValue('B18', $asnshipment->country_of_destination);
                    }
                }

            }

            $sheet->setCellValue('G' . $detail_row, $quantity_total_total);
            $sheet->setCellValue('J' . $detail_row, "USD " . $amount_total);
            $sheet->setCellValue('B' . ($detail_row+2), "QUANTITY:" . $quantity_total_total . "YDS");
            $sheet->setCellValue('B' . ($detail_row+3), "TOTAL AMOUNT: USD " . $amount_total);

        })->export('xlsx');
    }

    public function exportcheckreport(Request $request)
    {
        //
//        $input = $request->all();
//        dd($input);
        $ids = [];
        if ($request->has('ids'))
            $ids = explode(",", $request->input('ids'));
        if (count($ids) < 1)
            dd('未选择ASN');

        Excel::create('CheckReport', function($excel) use ($ids) {
            Excel::load('exceltemplate/checkreport.xlsx', function ($reader) use ($ids, $excel) {
                $objExcel = $reader->getExcel();
//                $sheet_src = $objExcel->getSheet(0);
                $sheetNames = $objExcel->getSheetNames();

                $rollcount_total = 0;
                $grossweight_total_total = 0.0;
                $netweight_total_total = 0.0;
                $quantity_total_total = 0;
                foreach ($ids as $id)
                {
                    $asn = Asn::find($id);
                    if (isset($asn))
                    {
                        Log::info($asn->id);
                        $asnshipment = $asn->asnshipments->first();
                        if ($asnshipment)
                        {
//                        $sheet->setCellValue('B8', substr($asn->asn_number, 0, 13));
//                        $ship_date = Carbon::parse($asnshipment->ship_date);
//                        $sheet->setCellValue('F8', $ship_date->format('M d, Y'));
                            $asnorder = $asnshipment->asnorders->first();
                            if (isset($asnorder))
                            {
                                $pohead = $asnorder->pohead;
                                if (isset($pohead))
                                {
                                    $poheadc = $pohead->poheadc;
                                    if (isset($poheadc))
                                    {
//                                    $sheet->setCellValue('C2', $poheadc->purchase_order_number);
                                    }
                                }

                                $asnpackagings = $asnorder->asnpackagings;
                                $i = -1;
                                foreach ($asnpackagings as $asnpackaging)
                                {
                                    $i++;
                                    $sheet_src = $objExcel->getSheetByName($sheetNames[$i]);
                                    if (isset($sheet_src))
                                    {
                                        $sheetname = $asnpackaging->poitem->poitemc->material_code;
                                        $sheet_src->setTitle($sheetname);
//                                Log::info($sheet_src->getTitle());
                                        $excel->addExternalSheet($sheet_src);
                                        $sheet_src->setCellValue('C5', $asnpackaging->poitem->poitemc->poheadc->purchase_order_number);
                                        $today = Carbon::today();
                                        $sheet_src->setCellValue('I5', $today->format('m/d/Y'));
                                        $sheet_src->setCellValue('C6', $asnpackaging->poitem->poitemc->material_code);
                                        $dyelotseries_types = Poitemroll::whereIn('id', $asnpackaging->asnitems->pluck('poitemroll_id'))->distinct()->pluck('dyelotseries');
                                        $sheet_src->setCellValue('C7', $dyelotseries_types->count());
                                        $sheet_src->setCellValue('I7', $asnpackaging->poitem->fabric_width());
                                        $grossweight_total = 0.0;
                                        $netweight_total = 0.0;
                                        $quantity_total = 0;
                                        $rollcount = $asnpackaging->asnitems->count();
                                        $detail_row = 13;
                                        $rollindex = 0;
                                        foreach ($asnpackaging->asnitems as $asnitem)
                                        {
                                            if ($rollindex > 0)
                                                $sheet_src->insertNewRowBefore($detail_row, 1);
                                            $sheet_src->setCellValue('A' . $detail_row, $asnitem->poitemroll->roll_number);
                                            $sheet_src->setCellValue('C' . $detail_row, $asnpackaging->poitem->fabric_width());
                                            $sheet_src->setCellValue('H' . $detail_row, $asnitem->poitemroll->quantity_shipped);
                                            $sheet_src->setCellValue('I' . $detail_row, $asnitem->poitemroll->quantity_shipped);
                                            $sheet_src->setCellValue('J' . $detail_row, $asnitem->poitemroll->dyelotseries);
                                            $grossweight_total += $asnitem->poitemroll->gross_weight;
                                            $netweight_total += $asnitem->poitemroll->net_weight;
                                            $quantity_total += $asnitem->poitemroll->quantity_shipped;
                                            $detail_row++;
                                            $rollindex++;
                                        }
                                        $detail_row++;
                                        $sheet_src->setCellValue('D' . $detail_row, $quantity_total);
                                        $detail_row++;
                                        $sheet_src->setCellValue('D' . $detail_row, $rollcount);
//                                        $sheet_src->setCellValue('E' . $detail_row, $netweight_total);
//                                        $detail_row++;
//                                        $sheet_src->setCellValue('B' . $detail_row, "GRAM WEIGHT:" . $grossweight_total . "G/M2   NET WEIGHT:" . $netweight_total . "KGS");
//                                        $detail_row++;
//                                        $sheet_src->setCellValue('B' . $detail_row, "ROLL #-" . $rollcount . " CONTAINS ROLL CUTTINGS ");
                                    }
                                }
                            }
                        }
                    }
                }



//            // Set the title
//            $excel->setTitle($filename);

//            // Chain the setters
//            $excel->setCreator('HXERP')
//                ->setCompany('Huaxing East');
            });



        })->export('xlsx');
    }

    public function send(Request $request)
    {
        //
//        Log::info($request->all());
//        $popoverhtml = '';
        if ($request->has('asn_id'))
        {
            $asn = Asn::find($request->input('asn_id'));
            if (isset($asn))
            {
                $type = $request->input('type');
//                $file = $request->file('file');

                $exitCode = Artisan::call('edi:put856', [
                    'asn_id' => $asn->id,
                ]);
                Log::info($exitCode);

//                $popoverhtml = '<button class="btn btn-sm" data-toggle="modal" data-target="#uploadAttachModal" data-shipment_id="' . $shipment->id . '" data-type="' . $type . '" type="button">+</button>';
//
//                Log::info($popoverhtml);
            }
        }

        $data = [
            'errcode' => 0,
            'errmsg' => '发送成功。',
//            'popoverhtml' => $popoverhtml,
        ];
        return response()->json($data);
    }
}
