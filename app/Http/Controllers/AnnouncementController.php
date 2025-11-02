<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string",
            "role" => "required|in:ppk,pps,kpps",
        ]);

        Announcement::create($request->only("title", "content", "role"));

        return back()
            ->with("success", "Pengumuman berhasil dibuat!")
            ->with("toast", true);
    }
}
