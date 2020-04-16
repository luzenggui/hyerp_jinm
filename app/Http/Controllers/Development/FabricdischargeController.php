<?php

namespace App\Http\Controllers\Development;

use App\Models\Development\Fabricdischarge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Log;
use Excel;

class FabricdischargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$fabricdischarges = Fabricdischarge::latest('created_at')->paginate(10);
        $inputs = $request->all();
        $query = Fabricdischarge::orderBy('id', 'asc');
        $query->where('flag1','<>',1)
              ->orwhere('flag2',"<>",1);
        $fabricdischarges = $query->select('*')->paginate(10);

        return view('development.fabricdischarges.index', compact('fabricdischarges','inputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('development.fabricdischarges.create');
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
            'department.required' => '部门字段是必须的',
            'contactor.required' => '联系人字段是必须的',
            'style.required' => '款号字段是必须的',
            'version.required' => '版号字段是必须的',
            'applydate.required'=>'申请日期是必须的',
            'weight.integer'=>'克重必须是数字型',
            'width.integer'=>'有效门幅必须是数字型',
        ];

        $this->validate($request, [
            'department' => 'required',
            'contactor' => 'required',
            'style' => 'required',
            'version' => 'required',
            'applydate'=>'required',
            'weight'=>'integer',
            'width'=>'integer',
        ],$messages);

        $input = $request->all();
//        dd(Auth()->user()->email);
//        dd($request);
        $input['createname']=Auth()->user()->email;
        Fabricdischarge::create($input);
//        $fabricdischarge->update(['createname'=>Auth()->user()->email]);
        return redirect('development/fabricdischarges');
    }

    public function export($id)
    {
        Excel::load('exceltemplate/fabricapply.xlsx', function ($reader) use ($id) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
//            $highestRow = $sheet->getHighestRow();
//            $highestColumn = $sheet->getHighestColumn();

            $fabricdischarge = Fabricdischarge::find($id);

            if (isset($fabricdischarge))
            {
                $sheet->setCellValue('B3',  $fabricdischarge->department);
                $sheet->setCellValue('C3',  "联系人：".$fabricdischarge->contactor);
                $sheet->setCellValue('C4',  $fabricdischarge->contactor_tel);
                $sheet->setCellValue('G3',  $fabricdischarge->style);
                $sheet->setCellValue('K3',  $fabricdischarge->version);

                $orderdate = Carbon::parse($fabricdischarge->applydate);
                $sheet->setCellValue('N3',  $orderdate->format('Y-m-d'));

                if($fabricdischarge->status=='正常')
                    $sheet->setCellValue('B5',  "正常（√）");
                elseif($fabricdischarge->status=='紧急')
                    $sheet->setCellValue('C5',  "紧急（√）");

                $sheet->setCellValue('A8',  $fabricdischarge->style_des);
                $sheet->setCellValue('C7',  $fabricdischarge->fabric_specification);
                $sheet->setCellValue('C8',  $fabricdischarge->weight);
                $sheet->setCellValue('C9',  $fabricdischarge->width);
                $sheet->setCellValue('C10',  $fabricdischarge->lattice_cycle);
                $sheet->setCellValue('C11',  $fabricdischarge->requirement);

                if($fabricdischarge->fabric_shrikage_grain==2 && $fabricdischarge->fabric_shrikage_zonal==2)
                {
                    $sheet->setCellValue('F8',  $fabricdischarge->fabric_shrikage_grain/100);
                    $sheet->setCellValue('F9',  $fabricdischarge->fabric_shrikage_zonal/100);
                }
                else
                {
                    $sheet->setCellValue('F10',  $fabricdischarge->fabric_shrikage_grain/100);
                    $sheet->setCellValue('F11',  $fabricdischarge->fabric_shrikage_zonal/100);
                }

                $sheet->setCellValue('G8',  $fabricdischarge->quantity);
                $sheet->setCellValue('H8',  $fabricdischarge->size_allotment);

                $sheet->setCellValue('I9',  $fabricdischarge->XXS);
                $sheet->setCellValue('J9',  $fabricdischarge->XS);
                $sheet->setCellValue('K9',  $fabricdischarge->S);
                $sheet->setCellValue('L9',  $fabricdischarge->M);
                $sheet->setCellValue('M9',  $fabricdischarge->L);
                $sheet->setCellValue('N9',  $fabricdischarge->XL);
                $sheet->setCellValue('O9',  $fabricdischarge->XXL);
                $sheet->setCellValue('P9',  $fabricdischarge->XXXL);

                $sheet->setCellValue('A13',  $fabricdischarge->note);
            }

        })->export('xlsx');
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

    public function updatefinishedpl(Request $request)
    {
//        log::info(111);
//        log::info($request->input('ids'));
        $ids = [];
        $nums=[];
        if ($request->has('ids'))
            $ids = explode(",", $request->input('ids'));
        if (count($ids) < 1)
            dd('未选择排料单');
        if ($request->has('num2'))
            $nums = explode(",", $request->input('num2'));
//        log::info($ids);
        for ($x=0; $x< count($ids,0); $x++)
        {
            if(is_numeric($ids[$x]))
            {
                $id=$ids[$x];
                $num=$nums[$x];
                $fabricdischarge = Fabricdischarge::find($id);
                $fabricdischarge->flag2 = 1;
                $fabricdischarge->num2 = $num;
                $fabricdischarge->save();
            }
        }
        return redirect('development/fabricdischarges');
    }

    public function updatefinishedzb(Request $request)
    {
//        log::info(111);
//        log::info($request->input('ids'));
//        dd($request->all());
        $ids = [];
        $nums=[];
        if ($request->has('ids'))
            $ids = explode(",", $request->input('ids'));
        if (count($ids) < 1)
            dd('未选择排料单');
        if ($request->has('num1'))
            $nums = explode(",", $request->input('num1'));
//        log::info($ids);

        for ($x=0; $x< count($ids,0); $x++)
        {
            if(is_numeric($ids[$x]))
            {
                $id=$ids[$x];
                $num=$nums[$x];
                $fabricdischarge = Fabricdischarge::find($id);
                $fabricdischarge->flag1 = 1;
                $fabricdischarge->num1 = $num;
                $fabricdischarge->save();
            }
        }
        return redirect('development/fabricdischarges');
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
        $fabricdischarge = Fabricdischarge::findOrFail($id);
        return view('development.fabricdischarges.edit', compact('fabricdischarge'));
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
        $fabricdischarge = Fabricdischarge::findOrFail($id);
        $fabricdischarge->update($request->all());
        return redirect('development/fabricdischarges');
    }

//    public function finish($id,$num1)
//    {
//        //
//        $fabricdischarge = Fabricdischarge::findOrFail($id);
//        $fabricdischarge->update(['flag1'=>1,'num1'=>$num1,]);
//        return redirect('development/fabricdischarges');
//    }

    public function finish(Request $request)
    {
        //
        $input = $request->all();
//        Log::info($input);
        $id=$input['frabricid'];
        $fabricdischarge = Fabricdischarge::findOrFail($id);
        if ($input['type']=='num1')
        {
            $retcode=$fabricdischarge->update(['flag1'=>1,'num1'=>$input['num'],]);
        }

        elseif ($input['type']=='num2')
            $retcode=$fabricdischarge->update(['flag2'=>1,'num2'=>$input['num'],]);
//        Log::info($retcode);
        if($retcode >=0)
            $data = [
                'errorcode' => 0,
                'errormsg' => 'success',
            ];
        else
            $data = [
                'errorcode' =>$retcode,
                'errormsg' => '更新失败',
            ];
        return response()->json($data);
    }

//    public function finish2($id,$num2)
//    {
//        //
//        $fabricdischarge = Fabricdischarge::findOrFail($id);
//        if($fabricdischarge->flag1==0)
//            dd('在排料之前，先要完成制版');
//
//        $fabricdischarge->update(['flag2'=>1,'num2'=>$num2,]);
//        return redirect('development/fabricdischarges');
//    }

    public function search(Request $request)
    {
        //
        $inputs = $request->all();

        //dd($inputs);
        $fabricdischarges = $this->searchrequest($request)->paginate(10);

        return view('development.fabricdischarges.index', compact('fabricdischarges','inputs'));
    }

    private function searchrequest($request)
    {

        $query = Fabricdischarge::orderBy('id', 'asc');

        if ($request->has('status1') &&  strlen($request->get('status1')) > 0)
        {
            $query->where('flag1', '=', $request->get('status1'));
        }

        if ($request->has('status2') &&  strlen($request->get('status2')) > 0)
        {
            $query->where('flag2', '=', $request->get('status2'));
        }

        if ($request->has('key') && strlen($request->get('key')) > 0)
        {
            $key = $request->get('key');
            $query->where(function ($query) use ($key) {
                $query->where('style', 'like', '%' . $key . '%')
                    ->orWhere('version', 'like', '%' . $key . '%');
            });
        }

        $fabricdischarges = $query->select('*');

        return $fabricdischarges;
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
        Fabricdischarge::destroy($id);
        return redirect('development/fabricdischarges');
    }
}
