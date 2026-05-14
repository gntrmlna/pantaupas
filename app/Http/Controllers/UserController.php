<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Upt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        $upts=
        Upt::orderBy(
            'nama'
        )->get();

        return view(
            'users.create',
            compact('upts')
        );
    }


    public function store(Request $request)
    {
        $request->validate([

            'name'=>'required',

            'email'=>'required|email|unique:users',

            'password'=>'required|min:6',

            'role'=>'required'

        ]);


        User::create([

            'name'=>$request->name,

            'email'=>$request->email,

            'password'=>Hash::make(
                $request->password
            ),

            'role'=>$request->role,

            'upt_id'=>

            $request->role=='operator'

            ?

            $request->upt_id

            :

            null

        ]);


        return redirect()
        ->route(
            'dashboard'
        )

        ->with(
            'success',
            'User berhasil dibuat'
        );

    }

}