<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Upt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request,$next){

            if(auth()->user()->role!='admin'){

                abort(403);

            }

            return $next($request);

        });

    }

    public function index()
    {
        $users=

        User::with('upt')
        ->latest()
        ->get();

        return view(
            'users.index',
            compact(
                'users'
            )
        );
    }



    public function destroy(User $user)
    {
        if(
            $user->id==
            auth()->id()
        ){

            return back()
            ->with(
                'error',
                'Tidak bisa menghapus akun sendiri'
            );

        }

        $user->delete();

        return back()
        ->with(
            'success',
            'User berhasil dihapus'
        );
    }
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

            'role'=>'required',

            'upt_id'=>

            $request->role=='operator'

            ?

            'required'

            :

            'nullable'

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

    public function edit(User $user)
    {
        $upts = Upt::orderBy('nama')->get();

        return view('users.edit', compact('user', 'upts'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
            'upt_id' => $request->role == 'operator'
                ? 'required'
                : 'nullable'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'upt_id' => $request->role == 'operator'
                ? $request->upt_id
                : null
        ];

        if($request->filled('password')){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success','User berhasil diupdate');
    }

}