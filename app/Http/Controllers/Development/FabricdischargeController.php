<?php

namespace App\Http\Controllers\Development;

use App\Models\Development\Fabricdischarge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FabricdischargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$fabricdischarges = Fabricdischarge::latest('created_at')->paginate(10);
        $query = Fabricdischarge::orderBy('id', 'asc');
        $query->where('flag','=',0);
        $fabricdischarges = $query->select('*')->paginate(100);

        $currentuser=Auth()->user()->email;
        $minid=DB::table('fabricdischarges')->where('createname',$currentuser)
                              ->where('flag',0)
                              ->min('id');
        //dd($minid);
        if($minid==null)
            $minid=0;
        $query1=Fabricdischarge::orderBy('id', 'asc');
        $query1->where('flag','=','0')
               ->where('id','<',$minid);
        $cntuser=$query1->count('id');
        //dd($cntuser);
        return view('development.fabricdischarges.index', compact('fabricdischarges','cntuser'));
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
            'contactor_tel.required' => '联系人电话字段是必须的',
            'contactor.required' => '联系人字段是必须的',
            'style.required' => '款号字段是必须的',
            'version.required' => '版号字段是必须的',
        ];

        $this->validate($request, [
            'department' => 'required',
            'contactor_tel' => 'required',
            'contactor' => 'required',
            'style' => 'required',
            'version' => 'required',
        ],$messages);

        $input = $request->all();
//        dd(Auth()->user()->email);
//        dd($request);
        $input['createname']=Auth()->user()->email;
        Fabricdischarge::create($input);
//        $fabricdischarge->update(['createname'=>Auth()->user()->email]);
        return redirect('development/fabricdischarges');
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

    public function finish($id)
    {
        //
        $fabricdischarge = Fabricdischarge::findOrFail($id);
        $fabricdischarge->update(['flag'=>1,]);
        return redirect('development/fabricdischarges');
    }

    public function search(Request $request)
    {
        //
        $inputs = $request->all();

        //dd($inputs);
        $fabricdischarges = $this->searchrequest($request)->paginate(10);

        $currentuser=Auth()->user()->email;
        $minid=DB::table('fabricdischarges')->where('createname',$currentuser)
            ->where('flag',0)
            ->min('id');

        if($minid==null)
            $minid=0;
        $query1=Fabricdischarge::orderBy('id', 'asc');
        $query1->where('flag','=','0')
            ->where('id','<',$minid);
        $cntuser=$query1->count('id');

        return view('development.fabricdischarges.index', compact('fabricdischarges', 'cntuser'));
    }

    private function searchrequest($request)
    {

        $query = Fabricdischarge::orderBy('id', 'asc');

        if ($request->has('status') && strlen($request->get('status')) > 0)
        {
            $key = $request->get('status');

            $db_driver = config('database.connections.' . env('DB_CONNECTION', 'mysql') . '.driver');
            if ($db_driver == "sqlsrv")
                $query->where(function ($query) use ($key) {
                    $query->where('flag', '=', $key);
//                        ->orWhere('invoice_number', 'like', '%' . $key . '%')
//                        ->orWhere('contract_number', 'like', '%' . $key . '%')
//                        ->orWhere('bill_no', 'like', '%' . $key . '%')
//                        ->orWhere('ship_company', 'like', '%' . $key . '%')
//                        ->orWhere('customs_no', 'like', '%' . $key . '%');
                });
            elseif ($db_driver == "pgsql")
                $query->where(function ($query) use ($key) {
                    $query->where('flag', '=',  $key);
//                        ->orWhere('invoice_number', 'ilike', '%' . $key . '%')
//                        ->orWhere('contract_number', 'ilike', '%' . $key . '%')
//                        ->orWhere('bill_no', 'ilike', '%' . $key . '%')
//                        ->orWhere('ship_company', 'ilike', '%' . $key . '%')
//                        ->orWhere('customs_no', 'ilike', '%' . $key . '%');
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