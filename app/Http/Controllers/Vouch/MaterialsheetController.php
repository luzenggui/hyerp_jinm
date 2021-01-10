<?php

namespace App\Http\Controllers\Vouch;

use App\Models\Vouch\Inventory;
use App\Models\Vouch\Inventoryacc;
use App\Models\Vouch\Material;
use App\Models\Vouch\Materialsheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel,Log;

class MaterialsheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $inputs = $request->all();
        $materialsheets = $this->searchrequest($request)->paginate(50);
        return view('vouch.materialsheets.index', compact('materialsheets', 'inputs'));
    }

    public function search(Request $request)
    {

        $inputs = $request->all();
        $materialsheets = $this->searchrequest($request)->paginate(50);

        return view('vouch.materialsheets.index', compact('materialsheets', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Materialsheet::orderBy('created_at', 'desc');

        if ($request->has('sheetno') )
        {
            $query->whereRaw('sheetno like \'%' . $request->input('sheetno') . '%\'');
        }

        if ($request->has('mt_code') )
        {
//            $enddate = Carbon::parse($request->input('etdend'))->addDay();
            $query->leftjoin('materials','materials.id','=','materialsheets.mtid');
            $query->whereRaw('materials.code like \'%' . $request->input('mt_code') . '%\'');

        }

        $materialsheets = $query->select('*');

        return $materialsheets;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vouch.materialsheets.create');
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
        Materialsheet::create($input);
        return redirect('vouch/materialsheets');
    }

    public function import()
    {
        //vouch/maiterialsheets/import
        return view('vouch.materialsheets.import');
    }

    public function importstore(Request $request)
    {
        //
        $rowData=[];
        $input=$request->all();
//        dd($input);
        $file = $request->file('file');
        $startcell= $input['startcell'];
        if($startcell =='' )
            dd('请输入开始行');

//        config(['excel.import.calculate' => false]);
//
        Excel::load($file->getRealPath(), function ($reader) use ($request,$startcell) {
//            Log::info($reader->getTitle());
            $objExcel = $reader->getExcel();
//            Log:info($reader->all());
//            $sheet = $objExcel->getSheet(0);
            $sheet = $objExcel->getSheetByName('PI');
            if (isset($sheet)) {
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $highestColumn++;
                $invoiceno=substr(trim($sheet->getCell('H6')),3);
                $contractno=substr(trim($sheet->getCell('F17')),15);
//                $rowData = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1,NULL, TRUE, FALSE);
//                Log::info($invoiceno);
                $materialsheet=Materialsheet::where('sheetno',$contractno)->where('invoiceno',$invoiceno)->first();
                if($materialsheet)
                {
                    for($i=$startcell;$i<$highestRow;$i++)
                    {
                        $qty=$sheet->getCell('F'.$i);
                        $materialcode=trim($sheet->getCell('D'.$i));
                        $materialrm=substr($materialcode,0,2);
//                        Log::info($materialrm);
                        if($qty== '' ||  $materialcode =='' || $materialrm <> 'RM')
                            continue;
                        else
                        {

                            $material=Material::where('code',$materialcode)->first();
                            if(!$material)
                                dd('第'.$i.'行的物料编码不存在！');
                            else
                            {
                                $materialsheetcode=Materialsheet::where('sheetno',$contractno)->where('mtid',$material->id)->first();
//                                Log::info($materialsheetcode);
                                if($materialsheetcode)
                                {
//                                    Log::info($materialsheetcode->qty);
                                    $materialsheetcode->qty=$sheet->getCell('F'.$i);
                                    $materialsheetcode->unitprice=$sheet->getCell('H'.$i);
//                                    dd($sheet->getCell('I'.$i)->getCalculatedValue());
                                    $materialsheetcode->amount=$sheet->getCell('I'.$i)->getCalculatedValue();
                                    $materialsheetcode->save();

                                    $inventoryacc=Inventoryacc::where('sheetno',$contractno)->where('mtid',$material->id)->first();
                                    $inventory=Inventory::where('mtid',$material->id)->first();
//                                    Log::info($inventoryacc);
                                    $sheetqty=$sheet->getCell('F'.$i)->getValue();
//                                    Log::info(floatval($sheetqty));
                                    $inventory->qty=$inventory->qty - $inventoryacc->qty + floatval($sheetqty);
                                    $inventory->save();
                                    $inventoryacc->qty=$sheet->getCell('F'.$i);
                                    $inventoryacc->save();
                                }
                                else
                                {
                                    $input['sheetno']=$contractno;
                                    $input['invoice']=$invoiceno;
                                    $input['mtid']=$material->id;
                                    $input['type']=1;
                                    $input['qty']=$sheet->getCell('F'.$i);
                                    $input['unitprice']=$sheet->getCell('H'.$i);
                                    $input['amount']=$sheet->getCell('I'.$i)->getCalculatedValue();
//                                    dd($sheet->getCell('I'.$i)->getCalculatedValue());
                                    Materialsheet::create($input);

                                    $inputacc['mtid']=$material->id;
                                    $inputacc['qty']=$sheet->getCell('F'.$i);
                                    $inputacc['sheetno']=$contractno;
                                    $inputacc['type']=1;
                                    Inventoryacc::create($inputacc);

                                    $inputstock['mtid']=$material->id;
                                    $inputstock['qty']=$sheet->getCell('F'.$i);;
                                    Inventory::create($inputstock);
                                }
                            }
                        }

                    }
                }
                else
                {
                    for($i=$startcell;$i<$highestRow;$i++)
                    {
                        $qty=$sheet->getCell('F'.$i);
                        $materialcode=trim($sheet->getCell('D'.$i));
                        $materialrm=substr($materialcode,0,2);
//                        Log::info($materialrm);
//                        Log::info($invoiceno);
//                        Log::Info($qty.'    '.$materialcode);
                        if($qty== '' ||  $materialcode =='' || $materialrm <> 'RM')
                            continue;
                        else
                        {

                            $material=Material::where('code',$materialcode)->first();
//                        Log::info($materialcode);
//                        Log::info($material);
                            if(!$material)
                                dd('第'.$i.'行的物料编码不存在！');
                            else
                            {

                                $input['sheetno']=$contractno;
                                $input['invoiceno']=$invoiceno;
                                $input['mtid']=$material->id;
                                $input['type']=1;
                                $input['qty']=$sheet->getCell('F'.$i);
                                $input['unitprice']=$sheet->getCell('H'.$i);;
                                $input['amount']=$sheet->getCell('I'.$i)->getCalculatedValue();
                                Materialsheet::create($input);

                                $inputacc['mtid']=$material->id;
                                $inputacc['qty']=$sheet->getCell('F'.$i);
                                $inputacc['sheetno']=$contractno;
                                $inputacc['type']=1;
                                Inventoryacc::create($inputacc);

                                $inputstock['mtid']=$material->id;
                                $inputstock['qty']=$sheet->getCell('F'.$i);;
                                Inventory::create($inputstock);
                            }
                        }

                    }
                }
//                Log::info($sheet->getCell('F17'));
//                Log::info($contractno);
//                Log::info($rowData);
            }
            else
                dd('文件中没有PI表单');
        });
        return redirect('vouch/materialsheets');
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
        $materialsheet = Materialsheet::findOrFail($id);
        return view('vouch.materialsheets.edit', compact('materialsheet'));
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
        $materialsheet = Materialsheet::findOrFail($id);
        $materialsheet->update($request->all());
        return redirect('vouch/materialsheets');
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
        Materialsheet::destroy($id);
        return redirect('vouch/materialsheets');
    }
}
