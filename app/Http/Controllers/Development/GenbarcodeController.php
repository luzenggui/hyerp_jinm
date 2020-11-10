<?php

namespace App\Http\Controllers\Development;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel,Carbon\Carbon;
use DB;

class GenbarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('development.genbarcode.index', compact('checkrecords', 'inputs'));
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

    /**
     * Change the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changebarcode(Request $request)
    {
        //
        //dd($request->all());
        $rowData=[];
        $input=$request->all();
//        dd($input);
        $file = $request->file('file');
        $startcell= $input['startcell'];
        $endcell=$input['endcell'];
        if($startcell =='' ||$endcell=='')
            dd('请输入开始单元格和结束单元格');

        config(['excel.import.heading' => false]);

        Excel::load($file->getRealPath(), function ($reader) use ($request,$startcell,$endcell,&$rowData) {

//            config(['excel.import.startRow' => $startcell]);
//            $reader->skipRows($startcell-1);
            $reader->each(function ($sheet) use (&$reader, $request,$startcell,$endcell,&$rowData) {
//                dd($sheet->getHighestRow());

                $objExcel = $reader->getExcel();
                $sheet = $objExcel->getSheet(0);
                $row=$startcell;
                $rowData = $sheet->rangeToArray('B' . $row . ':' . 'B'.$endcell , NULL, TRUE, FALSE);

//            dd($rowData);
            });
        });
//        dd($rowData);
        return view('development.genbarcode.labelprint', compact('rowData'));
    }
}
