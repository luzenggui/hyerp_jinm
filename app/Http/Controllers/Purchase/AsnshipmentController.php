<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Asnorder;
use App\Models\Purchase\Asnshipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsnshipmentController extends Controller
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
    public function create($asn_id)
    {
        //
        return view('purchase.asnshipments.create', compact('asn_id'));
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

        Asnshipment::create($input);

        return redirect('purchase/asns/' . $input['asn_id'] . '/asnshipments');
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
        $asnshipment = Asnshipment::findOrFail($id);
        $asn_id = $asnshipment->asn_id;
        return view('purchase.asnshipments.edit', compact('asnshipment', 'asn_id'));
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
        $asnshipment = Asnshipment::findOrFail($id);
        $asnshipment->update($request->all());
        return redirect('purchase/asns/' . $request->get('asn_id') . '/asnshipments');
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
        $asnshipment = Asnshipment::findOrFail($id);
        $asn_id = $asnshipment->asn_id;
        Asnshipment::destroy($id);
        return redirect('purchase/asns/' . $asn_id . '/asnshipments');
    }

    public function asnorders($id)
    {
        $asnorders = Asnorder::where('asnshipment_id', $id)->paginate(10);
        return view('purchase.asnorders.index', compact('asnorders', 'id'));
    }
}
