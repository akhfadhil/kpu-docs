<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|max:255",
        ]);

        $user = User::findOrFail($id);

        // Update nama di tabel users
        $user->name = $request->name;
        $user->save();

        // Jika punya relasi polymorphic (ppk_members / pps_members)
        if ($user->userable) {
            $user->userable->update(["name" => $request->name]);
        }

        return back()->with("success", "Nama berhasil diperbarui.");
    }
}
