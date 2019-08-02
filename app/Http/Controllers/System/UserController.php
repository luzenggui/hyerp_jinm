<?php

namespace App\Http\Controllers\System;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UserController extends Controller
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
        $key = $request->input('key', '');
        $inputs = $request->all();
        if (null !== request('key'))
            $users = $this->searchrequest($request);
        else
            $users = User::latest('created_at')->paginate(10);
//        $users = User::latest('created_at')->paginate(10);

        if (null !== request('key'))
            return view('system.users.index', compact('users', 'key', 'inputs'));
        else
            return view('system.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::user()->can('system_user_maintain'))
            return view('system.users.create');
        else
            return '无此操作权限';
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
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];
//         return $data;

        User::create($data);
        return redirect('system/users');
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
        $user = User::findOrFail($id);
        return view('system.users.edit', compact('user'));
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
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        // $user->password = bcrypt($request->input('password'));
//        $user->dtuserid = $request->input('dtuserid');
//        $user->dept_id = $request->input('dept_id');
//        $user->position = $request->input('position');
        $user->update();


//        if ($user)
//        {
//            $sFilename = '';
//            if (Request::hasFile('avatar'))
//            {
//                dd($request->all());
//                $file = $request->file('avatar');
//                $sFilename = $this->saveImg($file);
//
//            }
//
//            $user->avatar = $sFilename;
//            $user->update();
//        }


        return redirect('system/users');
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
        if (\Gate::denies('delete-user')) {
            return "You have no permission to do this!";
        }
        //
        User::destroy($id);
        return redirect('system/users');
    }

    public function search(Request $request)
    {
        $key = $request->input('key');
        $inputs = $request->all();
        $users = $this->searchrequest($request);
//        $purchaseorders = Purchaseorder_hxold::whereIn('id', $paymentrequests->pluck('pohead_id'))->get();
//        $totalamount = Paymentrequest::sum('amount');

        return view('system.users.index', compact('users', 'key', 'inputs'));
    }

    public function searchrequest($request)
    {
        $inputs = $request->all();
        $key = $request->input('key');


        $query = User::latest();

        if (strlen($key) > 0)
        {
            $query->where(function($query) use ($key) {
                $query->where('name', 'like',  '%' . $key . '%');
            });
        }




        $users = $query->select('users.*')
            ->paginate(10);
//        dd($paymentrequests);

        return $users;
    }

    public function editpass($id)
    {
        //
        $user = User::findOrFail($id);
        return view('system.users.editpass', compact('user'));
    }

    public function updatepass(Request $request, $id)
    {
        //
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->input('password'));
        $user->update();
        return redirect('system/users');
    }
}
