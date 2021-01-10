<?php

namespace App\Http\Controllers\Vouch;

use App\Models\Vouch\Bom;
use App\Models\Vouch\Finishproduct;
use App\Models\Vouch\Material;
use Illuminate\Container\BoundMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel,Log;

class BomController extends Controller
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
        $boms = $this->searchrequest($request)->paginate(50);
        return view('vouch.boms.index', compact('boms','inputs'));
    }

    public function search(Request $request)
    {

        $inputs = $request->all();
        $boms = $this->searchrequest($request)->paginate(50);

        return view('vouch.boms.index', compact('boms', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Bom::orderBy('fgid', 'desc');

        if ($request->has('fg_code') )
        {
            $fgcnt=Finishproduct::where('fg_code',$request->input('fg_code'))->count();
//            dd($fg->id);
            if($fgcnt>0)
            {
                $fg=Finishproduct::where('fg_code',$request->input('fg_code'))->first();
                $query->where('fgid',$fg->id);
            }
            else
                dd('查询成品代码不存在');
        }

        if ($request->has('mt_code') )
        {
            $mtcnt=Material::where('code',$request->has('mt_code'))->count();
            if($mtcnt>0)
            {
                $mtid=Material::where('code',$request->has('mt_code'))->first();
                $query->where('mtid' ,$mtid);
            }
            else
                dd('查询物料代码不存在');
        }

        $boms = $query->select('*');

        return $boms;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vouch.boms.create');
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
        Bom::create($input);
        return redirect('vouch/boms');
    }

    public function import()
    {
        //
        return view('vouch.boms.import');
    }

    public function importstore(Request $request)
    {
        //

        $input=$request->all();
//        dd($input);
        $file = $request->file('file');

//        config(['excel.import.heading' => false]);

        Excel::load($file->getRealPath(), function ($reader) use ($request) {

            $sheet = $reader->getSheet(0);
            $rowData=array();
            $results = $sheet->toArray();
            Log::Info($results);
            foreach ($results as $key => $value) {
//                    Log::info($value);
                    if($key == 1)
                        for($i=4,$size=count($value); $i<$size; $i++ )
                        {
                            if($value[$i] != null)
                                array_push($rowData,$value[$i]);
                        }
//                    Log::info(count($rowData));
                    if(count($rowData)>1 && $key>1 && $value[3]<>'')
                    {
                        $material=Material::where('code',$value[3])->first();
//                        Log::Info($material);
                        if($material == null)
                            dd('第'. ($key + 1) .'行的物料编号不存在，请检查！');
                        for($j=0,$size=count($rowData);$j<$size;$j++) {
                            $fgdata = $rowData[$j];
                            $finishproduct = Finishproduct::where('fg_code', $fgdata)->first();
//                            Log::Info($finishproduct);

                            if (!$finishproduct)
                                dd('第' . ($j + 4) . '列的成品编号不存在，请检查！');
                        }

                        for($j=0,$size=count($rowData);$j<$size;$j++) {
                            $fgdata = $rowData[$j];
                            $finishproduct = Finishproduct::where('fg_code', $fgdata)->first();

                            if($finishproduct)
                            {
                                $bom=Bom::where('fgid',$finishproduct->id)->where('mtid',$material->id)->first();
                                if (isset($bom))
                                {

                                    $bom->qty=$value[$j+4];
                                    $bom->save();
                                    if($finishproduct->id==46 && $material->id==89)
                                    {
                                        Log::Info($bom->qty);
                                        Log::Info($bom);
                                    }
                                }
                                else
                                {
                                    $input['fgid']=$finishproduct->id;
                                    $input['mtid']=$material->id;
                                    $input['qty']=$value[$j+4];;
                                    Bom::create($input);
                                }
                            }
                        }
                    }
                }

        });
//        dd($rowData);
        return redirect('vouch/boms');
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
        $bom = Bom::findOrFail($id);
        return view('vouch.boms.edit', compact('bom'));
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
        $bom = Bom::findOrFail($id);
        $bom->update($request->all());
        return redirect('vouch/boms');
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
        Bom::destroy($id);
        return redirect('vouch/boms');
    }
}
