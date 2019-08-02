<?php

namespace App\Http\Controllers\Shipment;

use App\Models\Shipment\Userforwarder;
use App\Models\System\Userrole;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UserforwarderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        $users = User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
//            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
//            ->where('roles.name', 'forwarder')->select('users.*')->paginate(15);
        $userforwarders = Userforwarder::latest('created_at')->paginate(15);
        return view('shipment.userforwarders.index', compact('userforwarders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('shipment.userforwarders.create');
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
            'forwarder' => 'required',
        ]);
        $input = $request->all();
//        dd($input);
        Userforwarder::create($input);

        return redirect('shipment/userforwarders');
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
        $userforwarder = Userforwarder::findOrFail($id);
        return view('shipment.userforwarders.edit', compact('userforwarder'));
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
            'forwarder' => 'required',
        ]);
        $userforwarder = Userforwarder::findOrFail($id);
        $userforwarder->update($request->all());

        return redirect('shipment/userforwarders');
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
        Userforwarder::destroy($id);
        return redirect('shipment/userforwarders');
    }
}
