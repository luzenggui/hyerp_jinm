<?php

namespace App\Http\Controllers\Finance;

use App\Models\Finance\Packinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;

class PackinfoController extends Controller
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
        $packinfos = $this->searchrequest($request)->paginate(15);

        return view('finance.packinfo.index', compact('packinfos', 'inputs'));
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
        $packinfos = $this->searchrequest($request)->paginate(15);
        return view('finance.packinfo.index', compact('packinfos', 'key', 'inputs'));
    }

    public static function searchrequest($request)
    {

        $query = Packinfo::latest('created_at');
//        dd($request->all());

        if ($request->has('t_pono') )
        {
            $query->whereRaw('pono =\'' . $request->input('t_pono') . '\'');
        }

        $items = $query->select('packinfos.*');
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
        return view('finance.packinfo.create');
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
            'pono' => 'required',
            'qty' => 'required',
            'amount' => 'required',
        ]);

        $input = $request->all();
//        dd(Auth()->user()->email);
//        dd($request);
        $input['creator']=Auth()->user()->email;
        Packinfo::create($input);
//        $fabricdischarge->update(['createname'=>Auth()->user()->email]);
        return redirect('finance/packinfo');
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
        $packinfo = Packinfo::findOrFail($id);
        return view('finance.packinfo.mshow', compact('packinfo', 'config'));
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
        $packinfo = Packinfo::findOrFail($id);
        return view('finance.packinfo.edit', compact('packinfo'));
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
        $packinfo = Packinfo::findOrFail($id);
        $packinfo->update($request->all());
        return redirect('finance/packinfo');
    }

    public function import()
    {
        //
        return view('finance.packinfo.import');
    }

    public function importstore(Request $request)
    {
        $file = $request->file('file');

        Excel::load($file->getRealPath(), function ($reader) use ($request) {
            $reader->each(function ($sheet) use (&$reader, $request) {
                Log::info('sheet: ' . $sheet->getTitle());
                $rowindex = 1;
                $v_pono='';
                $sheet->each(function ($row) use (&$rowindex,&$reader,&$v_pono, $request) {

                    $input = $row->all();
//                    Log::info($rowindex);
//                    Log::info($input);
                    if ($rowindex >= 14)
                    {
                        if(!empty($input[3]))
                        {
                            Log::info($rowindex);
                            if(!empty($input[2]))
                            {
                                $v_pono=substr($input[2],0,9);
                                $packinfo = Packinfo::where('pono', $v_pono)->first();
                                Log::info($v_pono);
                                if(isset($packinfo))
                                {
                                    $packinfo->qty = $packinfo->qty +$input[6];
                                    $packinfo->amount = $packinfo->amount +$input[10];
                                    $packinfo->save();
                                }
                                else
                                {
                                    $data = [];
                                    $data['pono']              = $v_pono;
                                    $data['qty']               = $input[6];
                                    $data['amount']            = $input[10];
                                    Packinfo::create($data);
                                }

                            }
                            else
                            {
                                $packinfo = Packinfo::where('pono', $v_pono)->first();
                                Log::info($v_pono);
                                $packinfo->qty = $packinfo->qty +$input[6];
                                $packinfo->amount = $packinfo->amount +$input[10];
                                $packinfo->save();
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

        return redirect('finance/packinfo');
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
        Packinfo::destroy($id);
        return redirect('finance/packinfo');
    }
}
