<?php

namespace App\Http\Controllers\Shipment;

use App\Models\Shipment\Shipmentitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipmentitemController extends Controller
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
    public function create($shipment_id)
    {
        //
        return view('shipment.shipmentitems.create', compact('shipment_id'));
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
        Shipmentitem::create($input);
        return redirect('shipment/shipments/' . $input['shipment_id'] . '/shipmentitems');
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
        $shipmentitem = Shipmentitem::findOrFail($id);
        $shipment_id = $shipmentitem->shipment_id;
        return view('shipment.shipmentitems.edit', compact('shipmentitem', 'shipment_id'));
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
        $shipmentitem = Shipmentitem::findOrFail($id);
        $shipmentitem->update($request->all());
        return redirect('shipment/shipments/' . $request->get('shipment_id') . '/shipmentitems');
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
        $shipmentitem = Shipmentitem::findOrFail($id);
        $shipment_id = $shipmentitem->shipment_id;
        Shipmentitem::destroy($id);
        return redirect('shipment/shipments/' . $shipment_id . '/shipmentitems');
    }
}
