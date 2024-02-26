<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class profilController extends Controller
{
    public function edit(User $user)
    {
        $auth = Auth::user();
        $user = DB::table('users')
            ->where('id', '=', $auth->id)
            ->first();
        return view('dashboard.profile', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $auth = Auth::user();
        $user = DB::table('users')
            ->where('id', '=', $auth->id)
            ->limit(1);
        if ($request->repassword != null) {
            if ($request->repassword != $request->password) {
                return back()->with("error", "Pengulangan password baru tidak sesuai.");
            }

            $user->update([
                'name'   => $request->nama,
                'email'   => $request->email,
                'password'   => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'name'   => $request->nama,
                'email'   => $request->email,
            ]);
        }
        return redirect()->route('profile.edit', 1)->with(['success' => 'Profile berhasil diubah.']);
    }

}
