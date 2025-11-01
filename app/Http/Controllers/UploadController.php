<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUpload;

class UploadController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->role ?? "guest";
        $userable = $user->userable;

        // Siapkan variabel data sesuai role
        $data = [];

        switch ($role) {
            case "admin":
                return view("upload.admin");

            case "ppk":
                // Jika user PPK, ambil kecamatan terkait
                $kecamatan = \App\Models\Kecamatan::with(
                    "document",
                )->findOrFail($userable->kecamatan_id ?? null);
                $data["kecamatan"] = $kecamatan;
                return view("upload.kecamatan", $data);

            case "kpps":
                // Jika user KPPS, ambil TPS terkait
                $tps = \App\Models\TPS::with("document")->findOrFail(
                    $userable->tps_id ?? null,
                );
                $data["tps"] = $tps;
                return view("upload.tps", $data);

            default:
                abort(
                    403,
                    "Anda tidak memiliki izin untuk mengakses halaman ini.",
                );
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->role ?? "guest";
        $userable = $user->userable;

        // Validasi file upload
        $request->validate([
            "doc_type" => "required|string",
            "file" => "required|file|mimes:pdf|max:20480", // max 20 MB
        ]);

        $file = $request->file("file");
        $docType = strtolower($request->doc_type);

        $path = "";
        $documentable = null;

        // === Tentukan lokasi dan relasi penyimpanan berdasarkan role ===
        if ($role === "kpps") {
            // Upload untuk TPS
            $tps = \App\Models\TPS::with("desa.kecamatan")->findOrFail(
                $userable->tps_id,
            );
            $path = "documents/{$tps->desa->kecamatan->name}/{$tps->desa->name}/{$tps->tps_code}";
            $documentable = $tps;
        } elseif ($role === "ppk") {
            // Upload untuk Kecamatan
            $kecamatan = \App\Models\Kecamatan::findOrFail(
                $userable->kecamatan_id,
            );
            $path = "documents/{$kecamatan->name}/D Hasil {$kecamatan->name}";
            $documentable = $kecamatan;
        } elseif ($role === "admin") {
            // Upload untuk kabupaten (tanpa relasi morph)
            $path = "documents/D Hasil Kabupaten";
            $documentable = AdminUpload::firstOrCreate([
                "name" => "Banyuwangi",
            ]);
        } else {
            abort(403, "Role Anda tidak memiliki izin untuk upload dokumen.");
        }

        // === Pastikan folder tujuan ada ===
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        $filename = "{$docType}.pdf";
        $fullPath = "{$path}/{$filename}";

        // === Simpan file fisik ===
        $file->move(public_path($path), $filename);

        // === Simpan ke database jika ada relasi morph ===
        if ($documentable) {
            $existing = $documentable
                ->document()
                ->where("doc_type", strtoupper($docType))
                ->first();
            if ($existing) {
                // Update record lama
                $existing->update([
                    "path" => $fullPath,
                    "uploaded_by" => $user->id,
                    "updated_at" => now(),
                ]);
            } else {
                // Buat record baru
                $documentable->document()->create([
                    "doc_type" => strtoupper($docType),
                    "path" => $fullPath,
                    "uploaded_by" => $user->id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }

        return redirect()
            ->back()
            ->with("success", "Dokumen berhasil diupload!");
    }
}
