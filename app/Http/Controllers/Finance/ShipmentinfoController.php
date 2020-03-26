<?php

namespace App\Http\Controllers\Finance;

use App\Models\Finance\Shipmentinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;

class ShipmentinfoController extends Controller
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
        $shipmentinfos = $this->searchrequest($request)->paginate(15);

        return view('finance.shipmentinfo.index', compact('shipmentinfos', 'inputs'));
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
        $shipmentinfos = $this->searchrequest($request)->paginate(15);
        return view('finance.shipmentinfo.index', compact('shipmentinfos', 'key', 'inputs'));
    }

    public static function searchrequest($request)
    {

        $query = Shipmentinfo::latest('created_at');
//        dd($request->input('t_invoiceno'));
        if ($request->has('t_pono') )
        {
            $query->whereRaw('pono =\'' . $request->input('t_pono') . '\'');
        }
        if ($request->has('t_department') )
        {
            $query->whereRaw('department =\'' . $request->input('t_department') . '\'');
        }
        if ($request->has('t_invoiceno') )
        {
            $query->whereRaw('invoiceno =\'' . $request->input('t_invoiceno') . '\'');
        }

        $items = $query->select('shipmentinfos.*');
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
        return view('finance.shipmentinfo.create');
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
            'department' => 'required',
        ]);

        $input = $request->all();
//        dd(Auth()->user()->email);
//        dd($request);
        $input['creator']=Auth()->user()->email;
        Shipmentinfo::create($input);
//        $fabricdischarge->update(['createname'=>Auth()->user()->email]);
        return redirect('finance/shipmentinfo');
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
        $shipmentinfo = Shipmentinfo::findOrFail($id);
        return view('finance.shipmentinfo.mshow', compact('shipmentinfo', 'config'));
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
        $shipmentinfo = Shipmentinfo::findOrFail($id);
        return view('finance.shipmentinfo.edit', compact('shipmentinfo'));
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
        $shipmentinfo = Shipmentinfo::findOrFail($id);
        $shipmentinfo->update($request->all());
        return redirect('finance/shipmentinfo');
    }

    public function import()
    {
        //
        return view('finance.shipmentinfo.import');
    }

    public function importstore(Request $request)
    {
        $file = $request->file('file');

        Excel::load($file->getRealPath(), function ($reader) use ($request) {
            $reader->each(function ($sheet) use (&$reader, $request) {
                Log::info('sheet: ' . $sheet->getTitle());
                $rowindex = 1;
                $v_fph='';
                $v_pono='';
                $v_custname='';
                $v_depart='';
                $sheet->each(function ($row) use (&$rowindex,&$reader,&$v_fph,&$v_pono,&$v_custname,&$v_depart,$request) {

                    $input = $row->all();
//                    Log::info($rowindex);
//                    Log::info($input);
                    if ($rowindex >= 3 && !empty($input[0]))
                    {
                        if(!empty($input[3]))
                        {
                            $v_fph=$input[3];
                            $v_depart=$input[0];
                            $v_custname=$input[1];
//                            Log::info($rowindex);
//                            Log::info($v_custname);
//                            Log::info($input[5]);
                            $v_pono=substr($input[5],0,9);
                            $shipmentinfo = Shipmentinfo::where('invoiceno', $v_fph)
                                                           ->where('pono',$v_pono)
                                                          ->where('department',$v_depart)
                                                          ->where('custname',$v_custname)->first();
//                            Log::info($v_fph,$shipmentinfo);
                            if(isset($shipmentinfo))
                            {
                                $shipmentinfo->qty_bg = $input[37];
                                $shipmentinfo->amount_bg = $input[38];
                                $shipmentinfo->qty_yf = $input[39];
                                $shipmentinfo->amount_yf = $input[40];
                                $shipmentinfo->save();
                            }
                            else
                            {
                                $data = [];
                                $data['department']              = $v_depart;
                                $data['custname']               = $v_custname;
                                $data['invoiceno']              = $v_fph;
                                $data['pono']               = $v_pono;
                                $data['qty_bg']              = $input[37];
                                $data['amount_bg']               = $input[38];
                                $data['qty_yf']            = $input[39];
                                $data['amount_yf']            = $input[40];
                                Shipmentinfo::create($data);
                            }

                        }
                        elseif(!empty($input[5]))
                        {
                            $v_pono=substr($input[5],0,9);
                            $shipmentinfo = Shipmentinfo::where('invoiceno', $v_fph)
                                ->where('pono',$v_pono)
                                ->where('department',$v_depart)
                                ->where('custname',$v_custname)->first();
//                            Log::info($v_fph,$shipmentinfo);
                            if(isset($shipmentinfo))
                            {
                                $shipmentinfo->qty_bg = $input[37];
                                $shipmentinfo->amount_bg = $input[38];
                                $shipmentinfo->qty_yf = $input[39];
                                $shipmentinfo->amount_yf = $input[40];
                                $shipmentinfo->save();
                            }
                            else
                            {
                                $data = [];
                                $data['department']              = $v_depart;
                                $data['custname']               = $v_custname;
                                $data['invoiceno']              = $v_fph;
                                $data['pono']               = $v_pono;
                                $data['qty_bg']              = $input[37];
                                $data['amount_bg']               = $input[38];
                                $data['qty_yf']            = $input[39];
                                $data['amount_yf']            = $input[40];
                                Shipmentinfo::create($data);
                            }
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

        return redirect('finance/shipmentinfo');
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
        Shipmentinfo::destroy($id);
        return redirect('finance/shipmentinfo');
    }
}
