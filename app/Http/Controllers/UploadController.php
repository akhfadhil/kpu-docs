<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TPS;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->role ?? "guest";

        // Ambil TPS yang dimiliki user
        $tps = TPS::with("document")
            ->where("id", $user->userable->tps_id)
            ->firstOrFail();

        return match ($role) {
            "admin" => view("upload.admin"),
            "ppk" => view("upload.ppk"),
            "pps" => view("upload.pps"),
            "kpps" => view("upload.tps", compact("tps")),
            default => abort(403),
        };
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Ambil TPS milik user
        $tps = TPS::where("id", $user->userable->tps_id)->firstOrFail();

        // Validasi input
        $request->validate([
            "doc_type" => "required|string",
            "file" => "required|file|mimes:pdf|max:20480", // max 20MB
        ]);

        $file = $request->file("file");
        $docType = strtolower($request->doc_type);

        // Tentukan path penyimpanan
        $path =
            "documents/" .
            $tps->desa->kecamatan->name .
            "/" .
            $tps->desa->name .
            "/tps " .
            $tps->tps_code;

        $filename = $docType . ".pdf";
        $file->move(public_path($path), $filename);

        // === Cek apakah dokumen dengan tipe sama sudah ada ===
        $existingDocument = $tps
            ->document()
            ->where("doc_type", strtoupper($docType))
            ->first();

        if ($existingDocument) {
            // Jika ada → update record lama
            $existingDocument->update([
                "path" => "$path/$filename",
                "uploaded_by" => $user->id,
                "updated_at" => now(),
            ]);
        } else {
            // Jika belum ada → buat record baru
            $tps->document()->create([
                "doc_type" => strtoupper($docType),
                "path" => "$path/$filename",
                "uploaded_by" => $user->id,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        return redirect()
            ->back()
            ->with("success", "Dokumen berhasil diupload!");
    }
}
