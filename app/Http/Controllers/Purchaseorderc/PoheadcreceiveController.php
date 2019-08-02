<?php

namespace App\Http\Controllers\Purchaseorderc;

use App\Models\Purchaseorderc\Poheadcreceive;
use App\Models\Purchaseorderc\Poitemcreceive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoheadcreceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $inputs = $request->all();
        $poheadcreceives = $this->searchrequest($request)->paginate(10);
        return view('purchaseorderc.poheadcreceives.index', compact('poheadcreceives', 'inputs'));
    }

    public function search(Request $request)
    {
//        $key = $request->input('key');
        $inputs = $request->all();
        $poheadcreceives = $this->searchrequest($request)->paginate(10);

        return view('purchaseorderc.poheadcreceives.index', compact('poheadcreceives', 'inputs'));
    }

    private function searchrequest($request)
    {

        $query = Poheadcreceive::latest('created_at');

        if ($request->has('key') && strlen($request->get('key')) > 0)
        {
            $key = $request->get('key');
            $query->where(function ($query) use ($key) {
                $query->where('purchase_order_number', 'like', '%' . $key . '%')
                    ->orWhere('supplier_name', 'like', '%' . $key . '%');
            });

//            $db_driver = config('database.connections.' . env('DB_CONNECTION', 'mysql') . '.driver');
//            if ($db_driver == "sqlsrv")
//                $query->where(function ($query) use ($key) {
//                    $query->where('customer_name', 'like', '%' . $key . '%')
//                        ->orWhere('invoice_number', 'like', '%' . $key . '%')
//                        ->orWhere('contract_number', 'like', '%' . $key . '%')
//                        ->orWhere('bill_no', 'like', '%' . $key . '%')
//                        ->orWhere('ship_company', 'like', '%' . $key . '%')
//                        ->orWhere('customs_no', 'like', '%' . $key . '%');
//                });
//            elseif ($db_driver == "pgsql")
//                $query->where(function ($query) use ($key) {
//                    $query->where('customer_name', 'ilike', '%' . $key . '%')
//                        ->orWhere('invoice_number', 'ilike', '%' . $key . '%')
//                        ->orWhere('contract_number', 'ilike', '%' . $key . '%')
//                        ->orWhere('bill_no', 'ilike', '%' . $key . '%')
//                        ->orWhere('ship_company', 'ilike', '%' . $key . '%')
//                        ->orWhere('customs_no', 'ilike', '%' . $key . '%');
//                });
        }

        if ($request->has('createdatestart') && $request->has('createdateend'))
        {
            $enddate = Carbon::parse($request->input('createdateend'))->addDay();
            $query->whereRaw('created_at between \'' . $request->input('createdatestart') . '\' and \'' . $enddate->toDateString() . '\'');


        }

        if ($request->has('etdstart') && $request->has('etdend'))
        {
//            $enddate = Carbon::parse($request->input('etdend'))->addDay();
            $query->whereRaw('etd between \'' . $request->input('etdstart') . '\' and \'' . $request->input('etdend') . '\'');

        }

        if ($request->has('amount_for_customer') && strlen($request->get('amount_for_customer')) > 0)
        {
            $query->where('amount_for_customer', $request->get('amount_for_customer_opt'), $request->get('amount_for_customer'));
        }

        if ($request->has('invoice_number_type') && strlen($request->get('invoice_number_type')) > 0)
        {
            $query->where('invoice_number', 'like', '%' . $request->get('invoice_number_type') . '%');
        }




        $items = $query->select('*');
//        dd($shipments);

        // $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();
        // dd($purchaseorders->pluck('id'));

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
        $poheadcreceive = Poheadcreceive::findOrFail($id);
        return view('purchaseorderc.poheadcreceives.show', compact('poheadcreceive'));
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
    }

    public function detail($id)
    {
        $poitemcreceives = Poitemcreceive::where('poheadcreceive_id', $id)->orderBy('fabric_sequence_no')->paginate(10);
        return view('purchaseorderc.poitemcreceives.index', compact('poitemcreceives', 'id'));
    }
}
