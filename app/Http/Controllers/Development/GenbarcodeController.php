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
        return view('development.genbarcode.index');
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
                $rowData = $sheet->rangeToArray('A' . $row . ':' . 'A'.$endcell , NULL, TRUE, FALSE);
                if(null !=$rowData)
                    $rowData=$this->checksum($rowData);
//            dd($rowData);
            });
        });
//        dd($rowData);
        return view('development.genbarcode.labelprint', compact('rowData'));
    }

    static public function checksum($number)
    {
        foreach($number as $uccnumber)
        {
//            dd($uccnumber[0]);
            $number1=substr($uccnumber[0],0,1);
            $number3=substr($uccnumber[0],2,1);
            $number5=substr($uccnumber[0],4,1);
            $number7=substr($uccnumber[0],6,1);
            $number9=substr($uccnumber[0],8,1);
            $number11=substr($uccnumber[0],10,1);

            $numberodd=($number1+$number3+$number5+$number7+$number9+$number11)*3;

            $number2=substr($uccnumber[0],1,1);
            $number4=substr($uccnumber[0],3,1);
            $number6=substr($uccnumber[0],5,1);
            $number8=substr($uccnumber[0],7,1);
            $number10=substr($uccnumber[0],9,1);
            $numberoven=$number2+$number4+$number6+$number8+$number10;

            $numbermod=($numberodd+$numberoven)%10;
            $checknum=10-$numbermod;
//            dd($checknum);
            $uccnumber[0] .=$checknum;
        }

        return $number;
    }
}
