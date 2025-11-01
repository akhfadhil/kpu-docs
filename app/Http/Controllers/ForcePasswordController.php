<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForcePasswordController extends Controller
{
    public function showForm()
    {
        return view("force-change-password");
    }

    public function update(Request $request)
    {
        $request->validate([
            "new_password" => "required|string|min:6|confirmed",
        ]);

        $user = Auth::user();
        if ($user instanceof User) {
            $user->password = Hash::make($request->new_password);
            $user->temporary_password = null;
            $user->save();
        }

        return redirect()
            ->route("login")
            ->with("success", "Password berhasil diubah!");
    }
}
