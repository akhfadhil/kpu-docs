<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tps;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->role ?? 'guest';

        // Ambil TPS yang dimiliki user
        $tps = Tps::with('document')
            ->where('id', $user->userable->tps_id)
            ->firstOrFail();

        return match ($role) {
            'admin' => view('upload.admin'),
            'ppk' => view('upload.ppk'),
            'pps' => view('upload.pps'),
            'kpps' => view('upload.tps', compact('tps')),
            default => abort(403),
        };
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'doc_type' => 'required|string|in:PPWP,DPR_RI,DPD,DPRD_PROV,DPRD_KAB,D_HASIL_KEC,D_HASIL_KAB',
    //         'file' => 'required|mimes:pdf|max:2048',
    //     ]);

    //     $user = Auth::user();
    //     $role = $user->role->role;
    //     $tps = $user->userable->tps ?? null; // asumsi relasi user -> tps
    //     $kecamatan = $tps?->desa?->kecamatan?->name ?? '';
    //     $desa = $tps?->desa?->name ?? '';
    //     $tpsCode = $tps?->tps_code ?? '';

    //     $filename = strtolower(str_replace(' ', '_', $request->doc_type)) . '.pdf';
    //     $path = match ($role) {
    //         'kpps' => "documents/{$kecamatan}/{$desa}/tps {$tpsCode}/{$filename}",
    //         'ppk' => "documents/{$kecamatan}/D Hasil {$kecamatan}.pdf",
    //         'admin' => "documents/{$filename}",
    //         default => null,
    //     };

    //     $request->file('file')->move(public_path(dirname($path)), basename($path));

    //     Document::updateOrCreate(
    //         [
    //             'doc_type' => $request->doc_type,
    //             'documentable_id' => $tps?->id,
    //             'documentable_type' => get_class($tps),
    //         ],
    //         ['path' => $path]
    //     );

    //     return back()->with('success', 'Dokumen berhasil diupload.');
    // }
    public function store(Request $request)
    {
        $user = Auth::user();

        // Ambil TPS milik user
        $tps = Tps::where('id', $user->userable->tps_id)->firstOrFail();

        // Validasi input
        $request->validate([
            'doc_type' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:20480', // max 20MB
        ]);

        $file = $request->file('file');
        $docType = strtolower($request->doc_type);

        // Tentukan path penyimpanan
        $path = 'documents/' .
            $tps->desa->kecamatan->name . '/' .
            $tps->desa->name . '/tps ' . $tps->tps_code;

        $filename = $docType . '.pdf';
        $file->move(public_path($path), $filename);

        // === Cek apakah dokumen dengan tipe sama sudah ada ===
        $existingDocument = $tps->document()->where('doc_type', strtoupper($docType))->first();

        if ($existingDocument) {
            // Jika ada → update record lama
            $existingDocument->update([
                'path' => "$path/$filename",
                'uploaded_by' => $user->id,
                'updated_at' => now(),
            ]);
        } else {
            // Jika belum ada → buat record baru
            $tps->document()->create([
                'doc_type' => strtoupper($docType),
                'path' => "$path/$filename",
                'uploaded_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }

}
