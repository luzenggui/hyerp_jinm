<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Asnitem;
use App\Models\Purchase\Asnorder;
use App\Models\Purchase\Asnpackaging;
use App\Models\Purchase\Poitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

class AsnpackagingController extends Controller
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
    public function create($asnorder_id)
    {
        //
        $asnorder = Asnorder::findOrFail($asnorder_id);
        $poitems = $asnorder->pohead->poitems->pluck('id');
        $poitemList = Poitem::whereIn('poitems.id', $poitems)
            ->leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id')
            ->pluck('poitemcs.material_code', 'poitems.id');
//        dd($poitemList);
//        dd($asnorder->pohead->poitems);
        $pohead_id = $asnorder->pohead_id;
        return view('purchase.asnpackagings.create', compact('asnorder_id', 'poitemList', 'pohead_id'));
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
//        Asnpackaging::create($input);
        $asnorder = Asnorder::findOrFail($input['asnorder_id']);

        $asnpackaging_items = json_decode($input['items_string']);
        foreach ($asnpackaging_items as $asnpackaging_item) {
            if ($asnpackaging_item->poitem_id > 0)
            {
                $item_array = json_decode(json_encode($asnpackaging_item), true);
                $item_array['asnorder_id'] = $input['asnorder_id'];
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

//        return redirect('purchase/asnshipments/' . $asnorder->asnshipment->id . '/asnorders');
        return redirect('purchase/asnorders/' . $input['asnorder_id'] . '/asnpackagings');
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
        $asnpackaging = Asnpackaging::findOrFail($id);
        $asnorder_id = $asnpackaging->asnorder_id;
        $poitems = $asnpackaging->asnorder->pohead->poitems->pluck('id');
        $poitemList = Poitem::whereIn('poitems.id', $poitems)
            ->leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id')
            ->pluck('poitemcs.material_code', 'poitems.id');
        return view('purchase.asnpackagings.edit', compact('asnpackaging', 'asnorder_id', 'poitemList'));
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
//        dd($request->all());
        $asnpackaging = Asnpackaging::findOrFail($id);
        $asnpackaging->update($request->all());

        $poitemroll_values = $request->get('poitemroll_values');
        $issuedrawing_weights = [];
        $issuedrawing_overviews = [];
        foreach (explode(",", $poitemroll_values) as $value) {
            if ($value > 0)
            {
                Asnitem::create(array('asnpackaging_id' => $id, 'poitemroll_id' => $value));
            }
        }

        return redirect('purchase/asnorders/' . $request->get('asnorder_id') . '/asnpackagings');
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
        $asnpackaging = Asnpackaging::findOrFail($id);
        $asnorder_id = $asnpackaging->asnorder_id;
        Asnpackaging::destroy($id);
        return redirect('purchase/asnorders/' . $asnorder_id . '/asnpackagings');
    }

    public function asnitems($id)
    {
        $asnitems = Asnitem::where('asnpackaging_id', $id)->paginate(10);
        return view('purchase.asnitems.index', compact('asnitems', 'id'));
    }

    public function asnpackagingjson(Request $request, $asnorder_id = 0)
    {
//        dd($request->all());
        $query = Asnpackaging::whereRaw('1=1');
        if ($asnorder_id > 0)
        {
            $query->where('asnorder_id', $asnorder_id);
        }
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

//        if ($request->has('asnshipment_id'))
//            $query->where('asnshipment_id', $request->get('asnshipment_id'));

//        if ($request->has('issuedrawingdatestart') && $request->has('issuedrawingdateend')) {
//            $query->whereRaw('issuedrawings.created_at between \'' . $request->get('issuedrawingdatestart') . '\' and \'' . $request->get('issuedrawingdateend') . '\'');
//        }

        $query->leftJoin('poitems', 'poitems.id', '=', 'asnpackagings.poitem_id');
        $query->leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id');

        return Datatables::of($query->select(['asnpackagings.*', 'poitemcs.material_code']))
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
