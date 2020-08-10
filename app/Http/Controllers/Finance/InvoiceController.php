<?php

namespace App\Http\Controllers\Finance;

use App\Models\Finance\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;
use Symfony\Component\Console\Input\InputOption;

class InvoiceController extends Controller
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
        $invoices = $this->searchrequest($request)->paginate(15);

        return view('finance.invoice.index', compact('invoices', 'inputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $key = $request->input('key');
        $inputs = $request->all();
        $invoices = $this->searchrequest($request)->paginate(15);
        return view('finance.invoice.index', compact('invoices', 'key', 'inputs'));
    }

    public static function searchrequest($request)
    {

        $query = Invoice::latest('created_at');
//        dd($request->input('t_invoiceno'));
        if ($request->has('invno') )
        {
            $query->whereRaw('invno =\'' . $request->input('invno') . '\'');
        }
        if ($request->has('departno') )
        {
            $query->whereRaw('departno =\'' . $request->input('departno') . '\'');
        }
        if ($request->has('customer') )
        {
            $query->whereRaw('customer like \'%' . $request->input('customer') . '%\'');
        }
        if ($request->has('s_invdate') and $request->has('e_invdate'))
        {
            $query->whereRaw('invdate between \''. $request->input('s_invdate') .'\' and \''. $request->input('e_invdate').'\'');
        }

        $items = $query->select('invoices.*');
//        dd($items->count());
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
        return view('finance.invoice.create');
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
            'invno' => 'required',
        ]);

        $input = $request->all();
        Invoice::create($input);
        return redirect('finance/invoice');
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

    public function mshow($id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        return view('finance.invoice.mshow', compact('invoice', 'config'));
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
        $invoice = Invoice::findOrFail($id);
        return view('finance.invoice.edit', compact('invoice'));
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
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());
        return redirect('finance/invoice');
    }

    public function import()
    {
        //
        return view('finance.invoice.import');
    }

    public function importstore(Request $request)
    {
        $file = $request->file('file');

//        config('excel.import.startRow',1);
        Excel::load($file->getRealPath(), function ($reader) use ($request) {
            $reader->each(function ($sheet) use (&$reader, $request) {
                Log::info('sheet: ' . $sheet->getTitle());
//                dd($sheet);
                $rowindex = 1;
//                $data = $reader->all();
//                dd($data);
                $sheetname=$sheet->getTitle();
                $rowheading=$sheet->getHeading();
//                dd($rowheading);
                $rowhead=['发票号','部门','客户','date','制单人','品名原因','合同号','生产工厂','目的港','出运日','核销单号','船公司','运单号','结汇方式','数量','pmjjintex收钱金额','wuxi收钱金额','预计收汇日期','收汇日','运费rmb','备注'];

                $i=0;
                foreach ($rowhead as $item) {
                    if($item <> $rowheading[$i])
                    {
//                        dd($item.$rowheading[$i]);
                        $j=$i+1;
                        dd('Sheet:'.$sheetname.'中第'.$j.'列名不对,应为'.$rowheading[$i]);
                    }
                    $i++;
                }
                $v_invno='';
                $sheet->each(function ($row) use (&$rowindex,&$reader,&$v_invno,&$sheetname,$request) {

                    $input = $row->all();
//                    dd($input);

//                    Log::info($rowindex);
                    Log::info($input);
                    if ($rowindex >= 1 && !empty($input[0]))
                    {
                        $v_invno=$input[0];
                        Log::info($v_invno);
                        $invoce = Invoice::where('invno', $v_invno)->first();
//                            Log::info($v_fph,$invoce);
                        if(isset($invoce))
                        {
                            $invoce->departno = $input[1];
                            $invoce->customer = $input[2];
                            $invoce->invdate = $input[3];
                            $invoce->maker = $input[4];
                            $invoce->productname = $input[5];
                            $invoce->pono = $input[6];
                            $invoce->factory = $input[7];
                            $invoce->destination = $input[8];
                            $invoce->shipdate = $input[9];
                            $invoce->verification_no = $input[10];
                            $invoce->shipcompany = $input[11];
                            $invoce->shipno = $input[12];
                            $invoce->paymethod = $input[13];
                            $invoce->quantity = $input[14];
                            $invoce->payamount_jintex = $input[15];
                            $invoce->payamount_wuxi = $input[16];
                            $invoce->fore_paydate = $input[17];
                            $invoce->paydate = $input[18];
                            $invoce->freight = $input[19];
                            $invoce->remark = $input[19];
                            $invoce->save();
                        }
                        else
                        {
                            $data = [];
                            $data['invno'] = $input[0];
                            $data['departno'] = $input[1];
                            $data['customer'] = $input[2];
                            $data['invdate'] = $input[3];
                            $data['maker'] = $input[4];
                            $data['productname'] = $input[5];
                            $data['pono'] = $input[6];
                            $data['factory'] = $input[7];
                            $data['destination'] = $input[8];
                            $data['shipdate'] = $input[9];
                            $data['verification_no'] = $input[10];
                            $data['shipcompany']= $input[11];
                            $data['shipno'] = $input[12];
                            $data['paymethod'] = $input[13];
                            $data['quantity'] = $input[14];
                            $data['payamount_jintex'] = $input[15];
                            $data['payamount_wuxi'] = $input[16];
                            $data['fore_paydate'] = $input[17];
                            $data['paydate'] = $input[18];
                            $data['freight'] = $input[19];
                            $data['remark'] = $input[20];
                            Invoice::create($data);
                        }
                    }

                    $rowindex++;
                });
            });

            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            Log::info('highestRow: ' . $highestRow);
            Log::info('highestColumn: ' . $highestColumn);

        });

        return redirect('finance/invoice');
    }

    public function export(Request $request)
    {
//        Log::info('export');
//        Log::info($request->all());
//        dd('1111');
        Excel::create('Invoice', function($excel) use ($request) {
            $excel->sheet('Sheet1', function ($sheet) use ($request, $excel) {
                $sheet->freezeFirstRow();
//                dd($request->all());
                $indexrow = 2;
                $this->searchrequest($request)->chunk(10, function ($invoices) use ($sheet, &$indexrow) {
                    $titleshows = ['发票号','部门','客户','date','制单人','品名(原因）','合同号','生产工厂','目的港','出运日','核销单号','船公司','运单号','结汇方式','数量','PMJ/JINTEX收钱金额','WUXI收钱金额','预计收汇日期','收汇日	运费(RMB)','备注'];
                    if (count($titleshows) > 1)
                        $sheet->appendRow($titleshows);
                    foreach ($invoices as $invoice)
                    {
                        $sheet->setCellValue('A' . $indexrow, $invoice->invno);
                        $sheet->setCellValue('B' . $indexrow, $invoice->departno);
                        $sheet->setCellValue('C' . $indexrow, $invoice->customer);
                        $sheet->setCellValue('D' . $indexrow, $invoice->invdate);
                        $sheet->setCellValue('E' . $indexrow, $invoice->maker);
                        $sheet->setCellValue('F' . $indexrow, $invoice->productname);
                        $sheet->setCellValue('G' . $indexrow, $invoice->pono);
                        $sheet->setCellValue('H' . $indexrow, $invoice->factory);
                        $sheet->setCellValue('I' . $indexrow, $invoice->destination);
                        $sheet->setCellValue('J' . $indexrow, $invoice->shipdate);
                        $sheet->setCellValue('K' . $indexrow, $invoice->verification_no);
                        $sheet->setCellValue('L' . $indexrow, $invoice->shipcompany);
                        $sheet->setCellValue('M' . $indexrow, $invoice->shipno);
                        $sheet->setCellValue('N' . $indexrow, $invoice->paymethod);
                        $sheet->setCellValue('O' . $indexrow, $invoice->quantity);
                        $sheet->setCellValue('P' . $indexrow, $invoice->payamount_jintex);
                        $sheet->setCellValue('Q' . $indexrow, $invoice->payamount_wuxi);
                        $sheet->setCellValue('R' . $indexrow, $invoice->fore_paydate);
                        $sheet->setCellValue('S' . $indexrow, $invoice->paydate);
                        $sheet->setCellValue('T' . $indexrow, $invoice->freight);
                        $sheet->setCellValue('U' . $indexrow, $invoice->remark);
                        $indexrow++;
                    }

                });
            });

        })->export('xlsx');
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
        Invoice::destroy($id);
        return redirect('finance/invoice');
    }
}
