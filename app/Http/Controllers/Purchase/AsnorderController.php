<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Asnitem;
use App\Models\Purchase\Asnorder;
use App\Models\Purchase\Asnpackaging;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables, DB;

class AsnorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($asnshipment_id)
    {
        //
        return view('purchase.asnorders.create', compact('asnshipment_id'));
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
//        dd($input);
        $asnorder = Asnorder::create($input);
        if (isset($asnorder))
        {
            $asnpackaging_items = json_decode($input['items_string']);
            foreach ($asnpackaging_items as $asnpackaging_item) {
                if ($asnpackaging_item->poitem_id > 0)
                {
                    $item_array = json_decode(json_encode($asnpackaging_item), true);
                    $item_array['asnorder_id'] = $asnorder->id;
                    $asnpackaging = Asnpackaging::create($item_array);
                    if (isset($asnpackaging))
                    {
                        $asnitem_items = $asnpackaging_item->poitemroll_values;
                        foreach (explode(",", $asnitem_items) as $value) {
                            if ($value > 0)
                            {
                                Asnitem::create(array('asnpackaging_id' => $asnpackaging->id, 'poitemroll_id' => $value));
                            }
                        }
                    }
                }
            }
        }
        return redirect('purchase/asnshipments/' . $input['asnshipment_id'] . '/asnorders');
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
        $asnorder = Asnorder::findOrFail($id);
        $asnshipment_id = $asnorder->asnshipment_id;
        return view('purchase.asnorders.edit', compact('asnorder', 'asnshipment_id'));
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
        $asnorder = Asnorder::findOrFail($id);
        $asnorder->update($request->all());
        return redirect('purchase/asnshipments/' . $request->get('asnshipment_id') . '/asnorders');
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
        $asnorder = Asnorder::findOrFail($id);
        $asnshipment_id = $asnorder->asnshipment_id;
        Asnorder::destroy($id);
        return redirect('purchase/asnshipments/' . $asnshipment_id . '/asnorders');
    }

    public function asnpackagings($id)
    {
        $asnpackagings = Asnpackaging::where('asnorder_id', $id)->paginate(10);
        return view('purchase.asnpackagings.index', compact('asnpackagings', 'id'));
    }

    public function asnorderjson(Request $request)
    {
//        dd($request->all());
        $query = Asnorder::whereRaw('1=1');
//        $query->where('status', 0);
//        if ($request->has('sohead_id'))
//            $query->where('sohead_id', $request->get('sohead_id'));
//        elseif ($sohead_id > 0)
//            $query->where('sohead_id', $sohead_id);
//        elseif (strlen($factory) > 0)
//            $query->where('productioncompany', 'like', '%' . $factory . '%');
//        elseif ($project_id > 0)
//        {
//            $sohead_ids = Salesorder_hxold::where('project_id', $project_id)->pluck('id');
//            $query->whereIn('sohead_id', $sohead_ids);
//        }

        if ($request->has('asnshipment_id'))
            $query->where('asnshipment_id', $request->get('asnshipment_id'));

//        if ($request->has('issuedrawingdatestart') && $request->has('issuedrawingdateend')) {
//            $query->whereRaw('issuedrawings.created_at between \'' . $request->get('issuedrawingdatestart') . '\' and \'' . $request->get('issuedrawingdateend') . '\'');
//        }

        $query->leftJoin('poheads', 'poheads.id', '=', 'asnorders.pohead_id');

        return Datatables::of($query->select(['asnorders.*', 'poheads.number']))
            ->make(true);


//        return Datatables::of($query->select(['issuedrawings.*', Db::raw('convert(varchar(100), issuedrawings.created_at, 23) as created_date'), 'users.name as applicant']))
//            ->filterColumn('created_at', function ($query) use ($request) {
//                $keyword = $request->get('search')['value'];
//                $query->whereRaw('CONVERT(varchar(100), issuedrawings.created_at, 23) like \'%' . $keyword . '%\'');
//            })
//            ->filterColumn('applicant', function ($query) use ($request) {
//                $keyword = $request->get('search')['value'];
//                $query->whereRaw('users.name like \'%' . $keyword . '%\'');
//            })
//            ->make(true);
    }
}
