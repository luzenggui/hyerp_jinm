<?php

namespace App\Http\Controllers\Shipment;

use App\Models\Shipment\Packinglist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log,Excel;

class PackinglistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $request = request();
        $inputs = $request->all();
        $packinglists = $this->searchrequest($request)->paginate(15);
        return view('shipment.packinglists.index', compact('packinglists', 'inputs'));
    }

    public function search(Request $request)
    {
        //

        $key = $request->input('key');
        $inputs = $request->all();

        $packinglists = $this->searchrequest($request)->paginate(15);
        return view('shipment.packinglists.index', compact('packinglists', 'key', 'inputs'));
    }

    public static function searchrequest($request)
    {
        $query = Packinglist::orderby('date_vanning','desc')->orderby('fph','asc');
        if ($request->has('fph') )
        {
            $query->whereRaw('fph like \'%' . $request->input('fph') . '%\'');
        }
        if ($request->has('hth') )
        {
            $query->whereRaw('hth like \'%' . $request->input('hth') . '%\'');
        }
        if ($request->has('startdate_vanning') && $request->has('enddate_vanning'))
        {
            $query->whereRaw('date_vanning between \'' . $request->input('startdate_vanning') . '\' and \''. $request->input('enddate_vanning').'\'');
        }
//        Log::info($query);
        $items = $query->select('packinglists.*');
//        Log::info($items);
        return $items;
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
        $packinglist = Packinglist::findOrFail($id);
        return view('shipment.packinglists.mshow', compact('packinglist', 'config'));
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
        $packinglist = Packinglist::findOrFail($id);
        return view('shipment.packinglists.edit', compact('packinglist'));
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
        $packinglist = Packinglist::findOrFail($id);
        $packinglist->update($request->all());
        return redirect('shipment/packinglists');
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
        Packinglist::destroy($id);
        return redirect('shipment/packinglists');
    }
}
