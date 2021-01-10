<?php

namespace App\Http\Controllers\Vouch;

use App\Models\Vouch\Bom;
use App\Models\Vouch\Finishproduct;
use App\Models\Vouch\Finishproductsheet;
use App\Models\Vouch\Inventory;
use App\Models\Vouch\Inventoryacc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel,Log;

class FinishproductsheetController extends Controller
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
        $finishproductsheets = $this->searchrequest($request)->paginate(50);
        return view('vouch.finishproductsheets.index', compact('finishproductsheets', 'inputs'));
    }

    public function search(Request $request)
    {

        $inputs = $request->all();
        $finishproductsheets = $this->searchrequest($request)->paginate(50);

        return view('vouch.finishproductsheets.index', compact('finishproductsheets', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Finishproductsheet::orderBy('created_at', 'desc');

        if ($request->has('sheetno') )
        {
            $query->whereRaw('sheetno like \'%' . $request->input('sheetno') . '%\'');
        }

        if ($request->has('fg_code') )
        {
//            $enddate = Carbon::parse($request->input('etdend'))->addDay();
            $query->leftjoin('finishproducts','finishproducts.id','=','finishproductsheets.fgid');
            $query->whereRaw('finishproducts.fgcode like \'%' . $request->input('fg_code') . '%\'');

        }

        $finishproductsheets = $query->select('*');

        return $finishproductsheets;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vouch.finishproductsheets.create');
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
        Finishproductsheet::create($input);
        return redirect('vouch/finishproductsheets');
    }

    public function import()
    {
        //
        return view('vouch.finishproductsheets.import');
    }

    public function importstore(Request $request)
    {
        //

        $input=$request->all();
//        dd($input);
        $file = $request->file('file');
//        $startcell= $input['startcell'];
//        if($startcell =='' )
//            dd('请输入开始单元格');


        Excel::load($file->getRealPath(), function ($reader) use ($request) {
//            Log::info($reader->getTitle());
            $objExcel = $reader->getExcel();
            $datarow=[];
            $rowdata2=[];
            $rowstart=[];
            $rowend=[];
            $sheetstart=0;
            $sheetend=0;
            $qtytotal=0;
            $finishrow=0;
//            Log:info($reader->all());
//            $sheet = $objExcel->getSheet(0);
            $sheet = $objExcel->getSheetByName('A');
            if (isset($sheet)) {
                $highestRow1 = $sheet->getHighestRow();
//                $highestColumn = $sheet->getHighestColumn();
//                $highestColumn++;
                for ($i = 1; $i < $highestRow1; $i++) {
//                    Log::Info(substr(trim($sheet->getCell('B'.$i)),0,16));
                    if(trim($sheet->getCell('B'.$i))=='成品代码：')
                        $finishrow=$i;
                }
                if($finishrow==0)
                    dd('成品代码不存在！');
                $fgcode=trim($sheet->getCell('C'.$finishrow));
                $finishproduct=Finishproduct::where('fg_code',$fgcode)->first();
                if(!$finishproduct)
                    dd('此成品代码不存在！');
                else
                {
                    $sheet1=$objExcel->getSheet(0);
                    if(isset($sheet1))
                    {
                        $invoiceno=trim($sheet1->getCell('G4'));
                        $contractno=substr(trim($sheet1->getCell('F15')),15);
                        $highestRow = $sheet1->getHighestRow();
                        $finishproductsheet=Finishproductsheet::where('sheetno',$contractno)->where('invoiceno',$invoiceno)->where('fgid',$finishproduct->id)->first();
                        if($finishproductsheet) {
                            for ($i = 1; $i < $highestRow; $i++) {
                                if (trim($sheet1->getCell('D' . $i)) == 'PATT/COL' && trim($sheet1->getCell('D' . ($i+1))) <> 'SUB TOTAL')
                                    array_push($rowstart,$i+1);

                                if (trim($sheet1->getCell('D' . $i)) == 'SUB TOTAL' && trim($sheet1->getCell('D' . ($i-1))) <>'PATT/COL')
                                    array_push($rowend, $i-1);
                                }
                            for($i=0,$j=0;$i<count($rowstart),$j<count($rowend);$i++,$j++)
                                for($rows=$rowstart[$i];$rows<=$rowend[$j];$rows++)
                                    array_push($datarow,$rows);

                            for($i=0,$size=count($datarow);$i<$size;$i++)
                            {
                                $qtytotal = $qtytotal + trim($sheet1->getCell('F' . $datarow[$i]));
                            }

                            $boms = Bom::where('fgid', $finishproduct->id);
                            foreach ($boms as $bom) {
                                $materialinv = Inventory::where('mtid', $bom->id)->first();
                                if(!isset($materialinv))
                                    dd('物料编号' . $bom->materialcode->code . '无库存！');
                                if ($materialinv->qty - $bom->qty * $qtytotal < 0)
                                    dd('物料编号' . $bom->materialcode->code . '库存不足！');
                            }

//                            Log::info($datarow);
                            Finishproductsheet::where('sheetno',$contractno)->where('invoiceno',$invoiceno)->delete();
                            for($i=0,$size=count($datarow);$i<$size;$i++)
                            {
                                    $patt = trim($sheet1->getCell('D' . $datarow[$i]));
                                    $color = trim($sheet1->getCell('E' . $datarow[$i]));
                                    $qty = trim($sheet1->getCell('F' .$datarow[$i]));
                                    $unitprice = trim($sheet1->getCell('G' . $datarow[$i])->getCalculatedValue());
                                    $amount = trim($sheet1->getCell('H' . $datarow[$i])->getCalculatedValue());

                                    $input['invoiceno']=$invoiceno;
                                    $input['sheetno']=$contractno;
                                    $input['qty'] = $qty;
                                    $input['unitprice'] = $unitprice;
                                    $input['amount'] = $amount;
                                    $input['color'] = $color;
                                    $input['patt'] = $patt;
                                    $input['type'] = 1;
                                    $input['fgid'] = $finishproduct->id;
                                    Finishproductsheet::create($input);
                            }

                            foreach ($boms as $bom) {
                                $materialinv = Inventory::where('mtid', $bom->id)->first();
                                if ($materialinv->qty - $bom->qty * $qtytotal >= 0) {
                                    $inventoryacc = Inventoryacc::where('sheetno', $contractno)->where('mtid', $bom->mtid)->first();
                                    $materialinv->qty = $inventoryacc->qty + $materialinv->qty - $bom->qty * $qtytotal;
                                    $materialinv->save();
                                    $inventoryacc->qty = $bom->qty * $qtytotal;;
                                    $inventoryacc->save();
                                }
                            }

                            $sheet2=$objExcel->getSheet(1);
                            if(isset($sheet2))
                            {
                                $highestRow2=$sheet2->getHighestRow();
                                for ($i = 0; $i < $highestRow2; $i++) {

                                    if (trim($sheet2->getCell('C' . $i)) == 'PATT')
                                        $sheetstart=$i+1;
                                    else if (trim($sheet2->getCell('C' . $i)) == 'TOTAL')
                                        $sheetend=$i-1;
                                }
                                for($j=$sheetstart;$j<=$sheetend;$j++)
                                {
                                    array_push($rowdata2,$j);
                                }
//                                Log::Info($rowdata2);
                                for($i=0,$size=count($rowdata2);$i<$size;$i++) {
                                    $patt2 = trim($sheet2->getCell('C' . $rowdata2[$i]));
                                    $color2 = trim($sheet2->getCell('D' . $rowdata2[$i]));
                                    $finishproductsheet1=Finishproductsheet::where('sheetno',$contractno)->where('invoiceno',$invoiceno)->where('fgid',$finishproduct->id)->where('patt',$patt2)->where('color',$color2)->first();
                                    if($finishproductsheet1)
                                    {
                                        $finishproductsheet1->cmunitprice=trim($sheet2->getCell('H' . $rowdata2[$i])->getCalculatedValue());
                                        $finishproductsheet1->cmamount=trim($sheet2->getCell('I' . $rowdata2[$i])->getCalculatedValue());
                                        $finishproductsheet1->save();
                                    }
                                }
                            }
                            else
                                dd('文件CM不存在');
                        }
                        else
                        {
                            for ($i = 1; $i < $highestRow; $i++) {
                                if (trim($sheet1->getCell('D' . $i)) == 'PATT/COL' && trim($sheet1->getCell('D' . ($i+1))) <> 'SUB TOTAL')
                                    array_push($rowstart,$i+1);

                                if (trim($sheet1->getCell('D' . $i)) == 'SUB TOTAL' && trim($sheet1->getCell('D' . ($i-1))) <> 'PATT/COL')
                                    array_push($rowend, $i-1);
                            }
                            for($i=0,$j=0;$i<count($rowstart),$j<count($rowend);$i++,$j++)
                                for($rows=$rowstart[$i];$rows<=$rowend[$j];$rows++)
                                    array_push($datarow,$rows);
//                             Log::Info($datarow);
                            for($i=0,$size=count($datarow);$i<$size;$i++)
                            {
                                $qtytotal = $qtytotal + trim($sheet1->getCell('F' . $datarow[$i]));
                            }

                            $boms = Bom::where('fgid', $finishproduct->id)->get();
//                            Log::Info($boms->first());
                            foreach ($boms as $bom) {
//                                Log::Info($bom);
                                $materialinv = Inventory::where('mtid', $bom->mtid)->first();
//                                Log::info($materialinv);
                                if(!isset($materialinv))
                                   dd('物料编号' . $bom->materialcode->code . '无库存！');
                                if ($materialinv->qty - $bom->qty * $qtytotal < 0)
                                    dd('物料编号' . $bom->materialcode->code . '库存不足！');
                            }

                            for($i=0,$size=count($datarow);$i<$size;$i++)
                            {
                                $patt = trim($sheet1->getCell('D' . $datarow[$i]));
                                $color = trim($sheet1->getCell('E' . $datarow[$i]));
                                $qty = trim($sheet1->getCell('F' . $datarow[$i]));
                                $unitprice = trim($sheet1->getCell('G' . $datarow[$i])->getCalculatedValue());
                                $amount = trim($sheet1->getCell('H' . $datarow[$i])->getCalculatedValue());



                                $input['invoiceno']=$invoiceno;
                                $input['sheetno']=$contractno;
                                $input['qty'] = $qty;
                                $input['unitprice'] = $unitprice;
                                $input['amount'] = $amount;
                                $input['color'] = $color;
                                $input['patt'] = $patt;
                                $input['type'] = 1;
                                $input['fgid'] = $finishproduct->id;
                                Finishproductsheet::create($input);
                            }

                            foreach ($boms as $bom) {
                                $materialinv = Inventory::where('mtid', $bom->mtid)->first();
                                if ($materialinv->qty - $bom->qty * $qtytotal >= 0 && $bom->qty>0) {

                                    $inputacc['mtid']=$bom->mtid;
                                    $inputacc['qty']=$qtytotal * $bom->qty;
                                    $inputacc['sheetno']=$contractno;
                                    $inputacc['type']=-1;
                                    Inventoryacc::create($inputacc);

                                    $materialinv->qty=$materialinv->qty - $bom->qty * $qtytotal;
                                    $materialinv->save();
                                }
                            }

                            $sheet2=$objExcel->getSheet(1);
//                            Log::info($sheet2->toarray());
                            if(isset($sheet2))
                            {
                                $highestRow2=$sheet2->getHighestRow();
                                for ($i = 0; $i < $highestRow2; $i++) {

                                    if (trim($sheet2->getCell('C' . $i)) == 'PATT')
                                        $sheetstart=$i+1;
                                    else if (trim($sheet2->getCell('C' . $i)) == 'TOTAL')
                                        $sheetend=$i-1;
                                }
//                                Log::info($sheetstart.''.$sheetend);
                                for($j=$sheetstart;$j<=$sheetend;$j++)
                                {
                                    array_push($rowdata2,$j);
                                }
//                                Log::Info($rowdata2);
                                for($i=0,$size=count($rowdata2);$i<$size;$i++) {
                                    $patt2 = trim($sheet2->getCell('C' . $rowdata2[$i]));
                                    $color2 = trim($sheet2->getCell('D' . $rowdata2[$i]));
                                    $finishproductsheet1=Finishproductsheet::where('sheetno',$contractno)->where('invoiceno',$invoiceno)->where('fgid',$finishproduct->id)->where('patt',$patt2)->where('color',$color2)->first();
                                    if($finishproductsheet1)
                                    {
                                        $finishproductsheet1->cmunitprice=trim($sheet2->getCell('H' . $rowdata2[$i])->getCalculatedValue());
                                        $finishproductsheet1->cmamount=trim($sheet2->getCell('I' . $rowdata2[$i])->getCalculatedValue());
                                        $finishproductsheet1->save();
                                    }
                                }
                            }
                            else
                                dd('文件CM不存在');
                        }

                    }
                    else
                        dd('文件PI不存在！');
                }

//                Log::info($sheet->getCell('F17'));
//                Log::info($contractno);
//                Log::info($rowData);
            }
            else
                dd('文件中没有成品代码A表单');
        });
        return redirect('vouch/finishproductsheets');
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
        $finishproductsheet = Finishproductsheet::findOrFail($id);
        return view('vouch.finishproductsheets.edit', compact('finishproductsheet'));
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
        $finishproductsheet = Finishproductsheet::findOrFail($id);
        $finishproductsheet->update($request->all());
        return redirect('vouch/finishproductsheets');
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
        Finishproductsheet::destroy($id);
        return redirect('vouch/finishproductsheets');
    }
}
