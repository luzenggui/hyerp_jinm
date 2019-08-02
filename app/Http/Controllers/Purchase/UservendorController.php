<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\Uservendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UservendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $uservendors = Uservendor::latest('created_at')->paginate(15);
        return view('purchase.uservendors.index', compact('uservendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('purchase.uservendors.create');
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
            'user_id' => 'required',
            'vendor_id' => 'required',
        ]);
        $input = $request->all();
        Uservendor::create($input);

        return redirect('purchase/uservendors');
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
        $uservendor = Uservendor::findOrFail($id);
        return view('purchase.uservendors.edit', compact('uservendor'));
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
        $this->validate($request, [
            'user_id' => 'required',
            'vendor_id' => 'required',
        ]);
        $uservendor = Uservendor::findOrFail($id);
        $uservendor->update($request->all());

        return redirect('purchase/uservendors');
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
        Uservendor::destroy($id);
        return redirect('purchase/uservendors');
    }
}
