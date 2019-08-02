<?php

namespace App\Http\Controllers\System;

use App\Models\System\Role;
use App\Models\System\Userrole;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserroleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userid)
    {
        //
        $userroles = Userrole::where('user_id', $userid)->paginate(10);
        return view('system.userroles.index', compact('userroles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userid)
    {
        //
        $user = User::findOrFail($userid);
        $roleIds = Userrole::where('user_id', $userid)->select('role_id')->get();
        $roleList = Role::whereNotIn('id', $roleIds)->pluck('name', 'id');
//        $roleList = Role::whereNotIn('id', $roleIds)->select('id', DB::raw('name + \' - \' + display_name as name'))->pluck('name', 'id');
        if ($user != null)
            return view('system.userroles.create', compact('user', 'roleList'));
        else
            return '无此用户';
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
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::findOrFail($request->input('role_id'));
        if ($user != null && $role != null)
        {
            // $user->attachRole($role);

            $userrole = new Userrole;
            $userrole->user_id = $user->id;
            $userrole->role_id = $role->id;
            $userrole->save();
        }

        return redirect('system/users/' . $request->input('user_id') . '/roles');
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
    public function destroy($userId, $roleId)
    {
        //
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);
        if ($user != null && $role != null)
        {
            // $user->detachRole($role);
            Userrole::where('user_id', $user->id)->where('role_id', $role->id)->delete();
        }
        else
            back();

        return redirect('system/users/' . $userId . '/roles');
    }
}
