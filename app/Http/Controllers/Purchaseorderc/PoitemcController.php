<?php

namespace App\Http\Controllers\Purchaseorderc;

use App\Models\Purchaseorderc\Poitemc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoitemcController extends Controller
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
        $poitem = Poitemc::findOrFail($id);
        $headId = $poitem->poheadc_id;
        return view('purchaseorderc.poitemcs.show', compact('poitem', 'headId'));
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
        $poitem = Poitemc::findOrFail($id);
        $headId = $poitem->poheadc_id;
        return view('purchaseorderc.poitemcs.edit', compact('poitem', 'headId'));
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
        $poitem = Poitemc::findOrFail($id);
        $headId = $poitem->poheadc_id;
        Poitemc::destroy($id);
        return redirect('purchaseorderc/purchaseordercs/' . $headId . '/detail');
    }
}
