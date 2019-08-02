<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Asnitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsnitemController extends Controller
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
    public function create($asnpackaging_id)
    {
        //
//        $asnpackaging = Asnorder::findOrFail($asnpackaging_id);
//        $poitems = $asnorder->pohead->poitems->pluck('id');
//        $poitemList = Poitem::whereIn('poitems.id', $poitems)
//            ->leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id')
//            ->pluck('poitemcs.material_code', 'poitems.id');
        return view('purchase.asnitems.create', compact('asnpackaging_id'));
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
        Asnitem::create($input);
        return redirect('purchase/asnpackagings/' . $input['asnpackaging_id'] . '/asnitems');
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
        $asnitem = Asnitem::findOrFail($id);
        $asnpackaging_id = $asnitem->asnpackaging_id;
//        $poitems = $asnpackaging->asnorder->pohead->poitems->pluck('id');
//        $poitemList = Poitem::whereIn('poitems.id', $poitems)
//            ->leftJoin('poitemcs', 'poitemcs.id', '=', 'poitems.poitemc_id')
//            ->pluck('poitemcs.material_code', 'poitems.id');
        return view('purchase.asnitems.edit', compact('asnitem', 'asnpackaging_id'));
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
        $asnitem = Asnitem::findOrFail($id);
        $asnitem->update($request->all());
        return redirect('purchase/asnpackagings/' . $request->get('asnpackaging_id') . '/asnitems');
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
        $asnitem = Asnitem::findOrFail($id);
        $asnpackaging_id = $asnitem->asnpackaging_id;
        Asnitem::destroy($id);
        return redirect('purchase/asnpackagings/' . $asnpackaging_id . '/asnitems');
    }
}
