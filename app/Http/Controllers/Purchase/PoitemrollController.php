<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Asnitem;
use App\Models\Purchase\Poitemroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoitemrollController extends Controller
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

    public function getitemsbypoitem($poitem_id)
    {
        //
        $poitemroll_ids = Asnitem::pluck('poitemroll_id');
        $poitemrolls = Poitemroll::where('poitem_id', $poitem_id)
            ->whereNotIn('id', $poitemroll_ids)
            ->paginate(500);
        return $poitemrolls;
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
        $poitemroll = Poitemroll::findOrFail($id);
        $poitem_id = $poitemroll->poitem_id;
//        $poitems = $asnpackaging->asnorder->pohead->poitems->pluck('id');
//        $poitemList = Poitem::whereIn('poitems.id', $poitems)
//            ->leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id')
//            ->pluck('poitemcs.material_code', 'poitems.id');
        return view('purchase.poitemrolls.edit', compact('poitemroll', 'poitem_id'));
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
        $poitemroll = Poitemroll::findOrFail($id);
        $poitemroll->update($request->all());
        return redirect('purchase/poitems/' . $request->get('poitem_id') . '/poitemrolls');
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
        $poitemroll = Poitemroll::findOrFail($id);
        $poitem_id = $poitemroll->poitem_id;
        Poitemroll::destroy($id);
        return redirect('purchase/poitems/' . $poitem_id . '/poitemrolls');
    }
}
