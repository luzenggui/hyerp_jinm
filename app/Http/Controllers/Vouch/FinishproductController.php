<?php

namespace App\Http\Controllers\Vouch;

use App\Models\Vouch\Finishproduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel,Log;
class FinishproductController extends Controller
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
        $finishproducts = $this->searchrequest($request)->paginate(50);
        return view('vouch.finishproducts.index', compact('finishproducts', 'inputs'));
    }

    public function search(Request $request)
    {

        $inputs = $request->all();
        $finishproducts = $this->searchrequest($request)->paginate(50);

        return view('vouch.finishproducts.index', compact('finishproducts', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Finishproduct::orderBy('fg_code', 'desc');

        if ($request->has('fg_code') )
        {
            $query->whereRaw('fg_code like \'%' . $request->input('fg_code') . '%\'');
        }

        if ($request->has('hs_code') )
        {
//            $enddate = Carbon::parse($request->input('etdend'))->addDay();
            $query->whereRaw('hs_code like \'%' . $request->input('hs_code') . '%\'');

        }

        $finishproducts = $query->select('*');

        return $finishproducts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vouch.finishproducts.create');
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
        Finishproduct::create($input);
        return redirect('vouch/finishproducts');
    }

    public function import()
    {
        //
        return view('vouch.finishproducts.import');
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
                    Log::info($rowindex);
                    Log::info($row);
                        $input = array_values($row->toArray());
//                    Log::info($input);
//                        Log::info(count($input));
                        if (count($input) >= 5) {

                            if (!empty($input[1])) {
                                $finishproduct = Finishproduct::where('fg_code', $input[1])->first();
                                if (!isset($finishproduct)) {
                                    $input['fg_code'] = $input[1];
                                    $input['type_name'] = $input[2];
                                    $input['fabrics'] = $input[3];
                                    $input['hs_code'] = $input[4];
                                    $input['memo'] = $input[5];
                                    $finishproduct = Finishproduct::create($input);
                                } else {
                                    $finishproduct->type_name = $input[2];
                                    $finishproduct->fabrics = $input[3];
                                    $finishproduct->hs_code = $input[4];
                                    $finishproduct->memo = $input[5];
                                    $finishproduct->save();
                                }
                            }
                        }
                    }
                    $rowindex+=1;
                });
            });
        });
//        dd($rowData);
        return redirect('vouch/finishproducts');
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
        $finishproduct = Finishproduct::findOrFail($id);
        return view('vouch.finishproducts.edit', compact('finishproduct'));
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

        $finishproduct = Finishproduct::findOrFail($id);
        $finishproduct->update($request->all());
        return redirect('vouch/finishproducts');
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
        Finishproduct::destroy($id);
        return redirect('vouch/finishproducts');
    }
}
