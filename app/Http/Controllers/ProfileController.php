<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'=>'required',
            'password'=>'required|min:8|confirmed'
        ]);

        if(!Hash::check(
            $request->current_password,
            auth()->user()->password
        )){
            return back()->with(
                'error',
                'Password lama salah'
            );
        }

        auth()->user()->update([
            'password'=>Hash::make(
                $request->password
            )
        ]);

        return back()->with(
            'success',
            'Password berhasil diubah'
        );
    }
}