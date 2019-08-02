<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vendors = Vendor::latest('created_at')->paginate(10);
        return view('purchase.vendors.index', compact('vendors'));
    }

    public function getitemsbykey($key)
    {
        // $salesorders = Salesorder::latest('created_at')->where('number', 'like', '%' . $key . '%')
        //     ->orWhere('descrip', 'like', '%'.$key.'%')->paginate(20);
        // $vendinfos = Vendinfo::where('name', 'like', '%' . $key . '%')->paginate(20);
        $vendors = Vendor::where('name', 'like', '%' . $key . '%')->paginate(20);
        return $vendors;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('purchase.vendors.create');
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
        $this->validate($request, [
            'number' => 'required|unique:vendors|max:255',
        ]);

        $input = $request->all();
        Vendor::create($input);
        return redirect('purchase/vendors');
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
        $vendor = Vendor::findOrFail($id);
        return view('purchase.vendors.edit', compact('vendor'));
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
        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());
        return redirect('purchase/vendors');
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
        Vendor::destroy($id);
        return redirect('purchase/vendors');
    }
}
