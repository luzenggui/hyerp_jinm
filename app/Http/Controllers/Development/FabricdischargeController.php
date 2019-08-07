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
        $query->where('flag1','<>',1)
              ->orwhere('flag2',"<>",1);
        $fabricdischarges = $query->select('*')->paginate(100);

//        $currentuser=Auth()->user()->email;
//        $minid=DB::table('fabricdischarges')->where('createname',$currentuser)
//                              ->where('flag',0)
//                              ->min('id');
//        //dd($minid);
//        if($minid==null)
//            $minid=0;
//        $query1=Fabricdischarge::orderBy('id', 'asc');
//        $query1->where('flag','=','0')
//               ->where('id','<',$minid);
//        $cntuser=$query1->count('id');
        //dd($cntuser);
        return view('development.fabricdischarges.index', compact('fabricdischarges'));
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
        $fabricdischarge->update(['flag1'=>1,]);
        return redirect('development/fabricdischarges');
    }

    public function finish2($id)
    {
        //
        $fabricdischarge = Fabricdischarge::findOrFail($id);
        if($fabricdischarge->flag1==0)
            dd('在排料之前，先要完成制版');

        $fabricdischarge->update(['flag2'=>1,]);
        return redirect('development/fabricdischarges');
    }

    public function search(Request $request)
    {
        //
        $inputs = $request->all();

        //dd($inputs);
        $fabricdischarges = $this->searchrequest($request)->paginate(10);

//        $currentuser=Auth()->user()->email;
//        $minid=DB::table('fabricdischarges')->where('createname',$currentuser)
//            ->where('flag',0)
//            ->min('id');
//
//        if($minid==null)
//            $minid=0;
//        $query1=Fabricdischarge::orderBy('id', 'asc');
//        $query1->where('flag','=','0')
//            ->where('id','<',$minid);
//        $cntuser=$query1->count('id');

        return view('development.fabricdischarges.index', compact('fabricdischarges'));
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
