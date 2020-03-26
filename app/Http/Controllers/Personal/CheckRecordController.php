<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\HelperController;
use App\Models\Personal\CheckRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;
use DB;

class CheckRecordController extends Controller
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
        $checkrecords = $this->searchrequest($request)->paginate(15);

        return view('personal.checkrecords.index', compact('checkrecords', 'inputs'));

    }

    public function search(Request $request)
    {
        $key = $request->input('key');
        $inputs = $request->all();
        $checkrecords = $this->searchrequest($request)->paginate(15);
//        dd($checkrecords->count());
        return view('personal.checkrecords.index', compact('checkrecords', 'key', 'inputs', 'checkrecords'));
    }

    public static function searchrequest($request)
    {

        $query = CheckRecord::latest('created_at');
//        dd($request->all());

        if ($request->has('checkrecord_datestart') && $request->has('checkrecord_dateend'))
        {
            $query->whereRaw('inputdate between \'' . $request->input('checkrecord_datestart') . '\' and \'' . $request->input('checkrecord_dateend') . '\'');
        }

        $items = $query->select('checkrecords.*');
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
        return view('personal.checkrecords.create');
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
        $messages=[
            'inputdate.required' => '填入字段是必须的',
            'name.required' => '姓名字段是必须的',
            'department.required' => '部门字段是必须的',
            'telno.required' => '手机号字段是必须的',
        ];

        $this->validate($request, [
            'inputdate' => 'required',
            'name' => 'required',
            'department' => 'required',
            'telno' => 'required',
        ],$messages);

        $input = $request->all();
//        dd(Auth()->user()->email);
//        dd($request);
        $input['creator']=Auth()->user()->email;
        CheckRecord::create($input);
//        $fabricdischarge->update(['createname'=>Auth()->user()->email]);
        return redirect('personal/checkrecords');
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
        $checkrecord = CheckRecord::findOrFail($id);
        return view('personal.checkrecords.mshow', compact('checkrecord', 'config'));
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
        $checkrecord = CheckRecord::findOrFail($id);
        return view('personal.checkrecords.edit', compact('checkrecord'));
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
        $checkrecord = CheckRecord::findOrFail($id);
        $checkrecord->update($request->all());
        return redirect('personal/checkrecords');
    }
    public function datasync()
    {
        //

        return view('personal.checkrecords.datasync');
    }

    public function synchronization(Request $request)
    {
        //
//        dd(11111122);
        $retval = [];
//        Log::info($request->all());
        if ($request->has('sdate') && $request->has('edate'))
        {
            $input=$request->all();
            $input = HelperController::skipEmptyValue($input);
            $input = array_except($input, '_token');
            $input = array_except($input, 'page');
//            $db_driver = config('database.connections.' . env('DB_CONNECTION_OA', 'sqlsrv1') . '.driver');
            $command='exec pgetmemberkq';
//            Log::info($input);
//            Log::info(env('DB_CONNECTION_OA', 'sqlsrv1'));
//            Log::info($db_driver);
//            if ($db_driver == "sqlsrv1")
//            {
//            protected $connection = 'sqlsrv';
                $param = "";
                foreach ($input as $key=>$value)
                {
                    if (!empty($value))
                        $param .= "@" . $key . "='" . $value . "',";
                }
                $param = count($input) > 0 ? substr($param, 0, strlen($param) - 1) : $param;
//                Log::info($param);
                $retval = DB::connection('sqlsrv1')->select($command . ' ' . $param);
//            Log::info($command . ' ' . $param);
//                Log::info($retval);
//            }
        }
//        log::info($retval[0]->retint);
        if($retval[0]->retval ==0)
            $data = [
                'errorcode' => 0,
                'errormsg' => 'Success to data synchronization',
            ];
        elseif($retval[0]->retval ==1)
            $data = [
                'errorcode' =>1,
                'errormsg' => 'Data failed',
            ];
        else
            $data = [
                'errorcode' =>1,
                'errormsg' => 'Data failed',
            ];
        return response()->json($data);
    }


    public function import()
    {
        //

        return view('personal.checkrecords.import');
    }

    public function importstore(Request $request)
    {


        $file = $request->file('file');

        Excel::load($file->getRealPath(), function ($reader) use ($request) {
            $reader->each(function ($sheet) use (&$reader, $request) {
                Log::info('sheet: ' . $sheet->getTitle());
                $rowindex = 3;
//                $reader->skip(3);
//                $sheet->skip(2);
                $shipment = null;
                $sheet->each(function ($row) use (&$rowindex, &$shipment, &$reader, $request) {
//                    Log::info('importstore 1: ');
                    if ($rowindex > 3)
                    {
//                        dd($row->all());
//                        $input = array_values($row->toArray());
//                        $reader->skip(3);
                        $input = $row->all();
//                        dd($input);
                                    $data = [];
                                    $data['inputdate'] = isset($input[0]) ? $input[0] : date('Y-m-d',time());
                                    $data['name']               = $input[1];
                                    $data['telno']            = $input[2];
                                    $data['department']            = $input[3];
                                    $data['address']            = $input[4];
                                    $data['temperature']            = $input[5];
                                    $data['stuation_self']            = $input[6];
                                    $data['stuation_family']            = $input[7];
                                    $data['contactname_merg']            = $input[8];
                                    $data['contacttelno_merg']            = $input[9];
                                    $data['other_note']            = $input[10];
                                    $data['creator']            = $input[11];
                                    CheckRecord::create($data);
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

//            //  Loop through each row of the worksheet in turn
//            for ($row = 1; $row <= $highestRow; $row++)
//            {
//                //  Read a row of data into an array
//                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
//                    NULL, TRUE, FALSE);
//            }
        });

        return redirect('personal/checkrecords');
    }


    public function export(Request $request)
    {
        Log::info('export');
        Log::info($request->all());
//        dd('1111');
        Excel::create('考勤记录表', function($excel) use ($request) {
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
        CheckRecord::destroy($id);
        return redirect('personal/checkrecords');
    }
}
