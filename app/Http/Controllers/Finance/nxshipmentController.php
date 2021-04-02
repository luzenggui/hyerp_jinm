<?php

namespace App\Http\Controllers\Finance;

use App\Models\Finance\Nxshipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;

class nxshipmentController extends Controller
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
        $nxshipments = $this->searchrequest($request)->paginate(15);
//        Log::Info($nxshipments);
        return view('finance.nxshipment.index', compact('nxshipments', 'inputs'));
    }

    public function search(Request $request)
    {
        //
        $key = $request->input('key');
        $inputs = $request->all();
        $nxshipments = $this->searchrequest($request)->paginate(15);
        return view('finance.nxshipment.index', compact('nxshipments', 'key', 'inputs'));
    }

    public static function searchrequest($request)
    {

        $query = Nxshipment::orderby('contract_number','desc')->orderby('invoice_number','asc');
        if ($request->has('invoice_number') )
        {
            $query->whereRaw('invoice_number like \'%' . $request->input('invoice_number') . '%\'');
        }
        if ($request->has('contract_number') )
        {
            $query->whereRaw('contract_number like \'%' . $request->input('contract_number') . '%\'');
        }
        if ($request->has('customer_name') )
        {
            $query->whereRaw('customer_name like \'%' . $request->input('customer_name') . '%\'');
        }

        $items = $query->select('nxshipments.*');
//        Log::info($items);
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
        return view('finance.nxshipment.create');
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
//        $this->validate($request, [
//            'department' => 'required',
//        ]);

        $input = $request->all();
//        dd(Auth()->user()->email);
//        dd($request);
//        $input['creator']=Auth()->user()->email;
        Nxshipment::create($input);
//        $fabricdischarge->update(['createname'=>Auth()->user()->email]);
        return redirect('finance/nxshipment');
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
        $nxshipment = Nxshipment::findOrFail($id);
        return view('finance.nxshipment.mshow', compact('nxshipment', 'config'));
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
        $nxshipment = Nxshipment::findOrFail($id);
        return view('finance.nxshipment.edit', compact('nxshipment'));
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
        $nxshipment = Nxshipment::findOrFail($id);
        $nxshipment->update($request->all());
        return redirect('finance/nxshipment');
    }

    public function import()
    {
        //
        return view('finance.nxshipment.import');
    }

    public function importstore(Request $request)
    {
        $file = $request->file('file');

        Excel::load($file->getRealPath(), function ($reader) use ($request) {
            $reader->each(function ($sheet) use (&$reader, $request) {
//                Log::info('sheet: ' . $sheet->getTitle());
                $rowindex = 0;
                $v_hth='';
                $v_invno='';
                $v_custname='';
                $sheet->each(function ($row) use (&$rowindex,&$reader,&$v_hth,&$v_invno,&$v_custname,$request) {

                    $input = $row->all();
//                    Log::info($rowindex);
//
                    if ($rowindex >= 1 && (!empty($input[0]) or !empty($input[1]) or !empty($input[2])))
                    {
//                        Log::info($input);
                            $v_hth=$input[2];
                            $v_invno=$input[1];
                            $v_custname=$input[0];

                             $nxshipment = Nxshipment::where('invoice_number',$v_invno)->first();
//                            Log::info($v_fph,$shipmentinfo);
//                            Log::info($nxshipment);
                            if(isset($nxshipment))
                            {
                                $nxshipment->contract_number=$v_hth;
                                $nxshipment->customer_name=$v_custname;
                                if($input[3] == '')
                                    $nxshipment->cyrq=date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->cyrq = $input[3];
                                if($input[4] == '')
                                    $nxshipment->cybd=0.0;
                                else
                                    $nxshipment->cybd = $input[4];
                                if($input[5] == '')
                                    $nxshipment->amount_shipments=0.0;
                                else
                                    $nxshipment->amount_shipments = $input[5];
                                if($input[6] == '')
                                    $nxshipment->amount_hjkp=0.0;
                                else
                                    $nxshipment->amount_hjkp = $input[6];
                                if($input[7] == '')
                                    $nxshipment->amount_hjsk =0.0;
                                else
                                    $nxshipment->amount_hjsk = $input[7];
                                if($input[8] == '')
                                    $nxshipment->note='';
                                else
                                    $nxshipment->note = $input[8];
                                if($input[9] == '')
                                    $nxshipment->amount_kp1 =0.0;
                                else
                                    $nxshipment->amount_kp1 = $input[9];
                                if($input[10] == '')
                                    $nxshipment->date_kp1 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_kp1 = $input[10];
                                if($input[11] == '')
                                    $nxshipment->amount_kp2 =0.0;
                                else
                                    $nxshipment->amount_kp2 = $input[11];
                                if($input[12] == '')
                                    $nxshipment->date_kp2 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_kp2 = $input[12];
                                if($input[13] == '')
                                    $nxshipment->amount_kp3 =0.0;
                                else
                                    $nxshipment->amount_kp3 = $input[13];
                                if($input[14] == '')
                                    $nxshipment->date_kp3 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_kp3 = $input[14];
                                if($input[15] == '')
                                    $nxshipment->amount_kp4 =0.0;
                                else
                                    $nxshipment->amount_kp4 = $input[15];
                                if($input[16] == '')
                                    $nxshipment->date_kp4 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_kp4 = $input[16];
                                if($input[17] == '')
                                    $nxshipment->amount_kp5 =0.0;
                                else
                                    $nxshipment->amount_kp5 = $input[17];
                                if($input[18] == '')
                                    $nxshipment->date_kp5 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_kp5 = $input[18];
                                if($input[19] == '')
                                    $nxshipment->amount_sk1 =0.0;
                                else
                                    $nxshipment->amount_sk1 = $input[19];
                                if($input[10] == '')
                                    $nxshipment->date_sk1 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_sk1 = $input[20];
                                if($input[21] == '')
                                    $nxshipment->amount_sk2 =0.0;
                                else
                                    $nxshipment->amount_sk2 = $input[21];
                                if($input[22] == '')
                                    $nxshipment->date_sk2 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_sk2 = $input[22];
                                if($input[23] == '')
                                    $nxshipment->amount_sk3 =0.0;
                                else
                                    $nxshipment->amount_sk3 = $input[23];
                                if($input[24] == '')
                                    $nxshipment->date_sk3 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_sk3 = $input[24];
                                if($input[25] == '')
                                    $nxshipment->amount_sk4 =0.0;
                                else
                                    $nxshipment->amount_sk4 = $input[25];
                                if($input[26] == '')
                                    $nxshipment->date_sk4 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_sk4 = $input[26];
                                if($input[27] == '')
                                    $nxshipment->amount_sk5 =0.0;
                                else
                                    $nxshipment->amount_sk5 = $input[27];
                                if($input[28] == '')
                                    $nxshipment->date_sk5 =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $nxshipment->date_sk5 = $input[28];
                                if($input[29] == '')
                                    $nxshipment->note1 ='';
                                else
                                    $nxshipment->note1 = $input[29];
                                $nxshipment->save();
                            }
                            else
                            {
                                $data = [];
                                $data['customer_name'] = $v_custname;
                                $data['invoice_number'] = $v_invno;
                                $data['contract_number'] = $v_hth;

                                if($input[3] == '')
                                    $data['cyrq']=date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['cyrq'] = $input[3];
                                if($input[4] == '')
                                    $data['cybd']=0.0;
                                else
                                    $data['cybd'] = $input[4];
                                if($input[5] == '')
                                    $data['amount_shipments']=0.0;
                                else
                                    $data['amount_shipments'] = $input[5];
                                if($input[6] == '')
                                    $data['amount_hjkp']=0.0;
                                else
                                    $data['amount_hjkp'] = $input[6];
                                if($input[7] == '')
                                    $data['amount_hjsk'] =0.0;
                                else
                                    $data['amount_hjsk'] = $input[7];
                                if($input[8] == '')
                                    $data['note']='';
                                else
                                    $data['note'] = $input[8];
                                if($input[9] == '')
                                    $data['amount_kp1'] =0.0;
                                else
                                    $data['amount_kp1'] = $input[9];
                                if($input[10] == '')
                                    $data['date_kp1'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_kp1'] = $input[10];
                                if($input[11] == '')
                                    $data['amount_kp2'] =0.0;
                                else
                                    $data['amount_kp2'] = $input[11];
                                if($input[12] == '')
                                    $data['date_kp2'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_kp2'] = $input[12];
                                if($input[13] == '')
                                    $data['amount_kp3'] =0.0;
                                else
                                    $data['amount_kp3'] = $input[13];
                                if($input[14] == '')
                                    $data['date_kp3'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_kp3'] = $input[14];
                                if($input[15] == '')
                                    $data['amount_kp4'] =0.0;
                                else
                                    $data['amount_kp4'] = $input[15];
                                if($input[16] == '')
                                    $data['date_kp4'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_kp4'] = $input[16];
                                if($input[17] == '')
                                    $data['amount_kp5'] =0.0;
                                else
                                    $data['amount_kp5'] = $input[17];
                                if($input[18] == '')
                                    $data['date_kp5'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_kp5'] = $input[18];
                                if($input[19] == '')
                                    $data['amount_sk1'] =0.0;
                                else
                                    $data['amount_sk1'] = $input[19];
                                if($input[10] == '')
                                    $data['date_sk1'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_sk1'] = $input[20];
                                if($input[21] == '')
                                    $data['amount_sk2'] =0.0;
                                else
                                    $data['amount_sk2'] = $input[21];
                                if($input[22] == '')
                                    $data['date_sk2'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_sk2'] = $input[22];
                                if($input[23] == '')
                                    $data['amount_sk3'] =0.0;
                                else
                                    $data['amount_sk3'] = $input[23];
                                if($input[24] == '')
                                    $data['date_sk3'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_sk3'] = $input[24];
                                if($input[25] == '')
                                    $data['amount_sk4'] =0.0;
                                else
                                    $data['amount_sk4'] = $input[25];
                                if($input[26] == '')
                                    $data['date_sk4'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_sk4'] = $input[26];
                                if($input[27] == '')
                                    $data['amount_sk5'] =0.0;
                                else
                                    $data['amount_sk5'] = $input[27];
                                if($input[28] == '')
                                    $data['date_sk5'] =date('Y-m-d',strtotime('1900-01-01'));
                                else
                                    $data['date_sk5'] = $input[28];
                                if($input[29] == '')
                                    $data['note1'] ='';
                                else
                                    $data['note1'] = $input[29];
                                Log::Info($data);
                                Nxshipment::create($data);
                            }
                    }
                    $rowindex++;
                });
            });

            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
//            Log::info('highestRow: ' . $highestRow);
//            Log::info('highestColumn: ' . $highestColumn);

        });

        return redirect('finance/nxshipment');
    }

    public function export(Request $request)
    {
        Log::info('export');
        Log::info($request->all());
//        dd('1111');
        Excel::create('Pack List', function($excel) use ($request) {
            $excel->sheet('Sheet1', function ($sheet) use ($request, $excel) {
                $sheet->freezeFirstRow();
//                dd($request->all());
                $indexrow = 2;
                $this->searchrequest($request)->chunk(10, function ($checkrecords) use ($sheet, &$indexrow) {
                    $titleshows = ['填报日期', '姓名', '联系方式（手机）', '所属部门', '当前所在位置', '当日体温', '本人是否有以下症状', '家人是否有以下症状', '其他情况'];
                    if (count($titleshows) > 1)
                        $sheet->appendRow($titleshows);
                    foreach ($checkrecords as $checkrecord)
                    {
                        $sheet->setCellValue('A' . $indexrow, $checkrecord->inputdate);
                        $sheet->setCellValue('B' . $indexrow, $checkrecord->name);
                        $sheet->setCellValue('C' . $indexrow, $checkrecord->telno);
                        $sheet->setCellValue('D' . $indexrow, $checkrecord->department);
                        $sheet->setCellValue('E' . $indexrow, $checkrecord->address);
                        $sheet->setCellValue('F' . $indexrow, $checkrecord->temperature);
                        $sheet->setCellValue('G' . $indexrow, $checkrecord->stuation_self);
                        $sheet->setCellValue('H' . $indexrow, $checkrecord->stuation_family);
                        $sheet->setCellValue('I' . $indexrow, $checkrecord->other_note);
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
        Nxshipment::destroy($id);
        return redirect('finance/nxshipment');
    }
}
