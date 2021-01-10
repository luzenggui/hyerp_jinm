<?php

namespace App\Http\Controllers\Vouch;

use App\Models\Vouch\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel,Log;

class MaterialController extends Controller
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
        $materials = $this->searchrequest($request)->paginate(50);
        return view('vouch.materials.index', compact('materials', 'inputs'));
    }

    public function search(Request $request)
    {

        $inputs = $request->all();
        $materials = $this->searchrequest($request)->paginate(50);

        return view('vouch.materials.index', compact('materials', 'inputs'));
    }
    private function searchrequest($request)
    {

        $query = Material::orderBy('code', 'desc');

        if ($request->has('mt_code') )
        {
           $query->whereRaw('code like \'%' . $request->input('mt_code') . '%\'');
        }

        if ($request->has('mt_name') )
        {
//            $enddate = Carbon::parse($request->input('etdend'))->addDay();
            $query->whereRaw('en_name like \'%' . $request->input('mt_name') . '%\' or ch_name like \'%' . $request->input('mt_name') . '%\'');

        }

        $materials = $query->select('*');

        return $materials;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vouch.materials.create');
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
        $material = Material::create($input);
        return redirect('vouch/materials');
    }

    public function import()
    {
        //
        return view('vouch.materials.import');
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
            dd('请输入开始单元格');

        config(['excel.import.heading' => false]);

        Excel::load($file->getRealPath(), function ($reader) use ($request,$startcell) {
            $reader->each(function ($sheet) use (&$reader, $startcell) {
                $rowindex = 1;
                $sheet->each(function ($row) use (&$rowindex, $startcell, &$reader) {

                    if ($rowindex >= $startcell) {
//                    Log::info($rowindex);
//                    Log::info($row);
                        $input = array_values($row->toArray());
//                    Log::info($input);
//                        Log::info(count($input));
                        if (count($input) >= 3) {

                            if (!empty($input[3])) {
                                $matertial = Material::where('code', $input[3])->first();
                                if (!isset($matertial)) {
                                    $input['ch_name'] = $input[1];
                                    $input['en_name'] = $input[2];
                                    $input['code'] = $input[3];
                                    $matertial = Material::create($input);
                                } else {
                                    $matertial->ch_name = $input[1];
                                    $matertial->en_name = $input[2];
                                    $matertial->save();
                                }
                            }
                        }
                    }
                    $rowindex+=1;
                });
            });
        });
//        dd($rowData);
        return redirect('vouch/materials');
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
        $material = Material::findOrFail($id);
        return view('vouch.materials.edit', compact('material'));
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
        $material = Material::findOrFail($id);
        $material->update($request->all());
        return redirect('vouch/materials');
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
        Material::destroy($id);
        return redirect('vouch/materials');
    }
}
