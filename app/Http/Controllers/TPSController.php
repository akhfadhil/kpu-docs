<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa;
use App\Models\TPS;
use App\Models\KPPSMember;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TPSController extends Controller
{
    public function index($tpsId)
    {
        $user = Auth::user();

        // Cegah KPPS mengakses kecamatan lain
        if ($user->role->role === "kpps") {
            $userTPSId = $user->userable->tps_id ?? null;
            if ($userTPSId !== (int) $tpsId) {
                // dd($userTPSId);
                return redirect()
                    ->route("tps.index", ["tpsId" => $userTPSId])
                    ->with("error", "Anda tidak memiliki akses ke tps lain.");
            }
        }

        $tps = TPS::with("desa.kecamatan")->findOrFail($tpsId);
        $anggota = KPPSMember::where("tps_id", $tpsId)->get();

        return view("dashboard.tps", [
            "title" => $tps->tps_code,
            "tps" => $tps,
            "tpsId" => $tps->id,
            "anggota" => $anggota,
        ]);
    }

    public function store(Request $request, Desa $desa)
    {
        $request->validate([
            "tps_code" => [
                "required",
                "string",
                "max:50",
                Rule::unique("tps", "tps_code")->where(
                    fn($q) => $q->where("desa_id", $desa->id),
                ),
            ],
            "address" => "nullable|string|max:255",
            "kpps_name" => "required|string|max:255",
            "kpps_username" => "required|string|max:255|unique:users,username",
        ]);
        DB::beginTransaction();

        try {
            // 1️⃣ Buat TPS
            $tps = $desa->tps()->create([
                "tps_code" => $request->tps_code,
                "address" => $request->address,
            ]);

            // 2️⃣ Buat anggota KPPS (Ketua)
            $kpps = \App\Models\KPPSMember::create([
                "name" => $request->kpps_name,
                "job_title" => "Ketua KPPS",
                "tps_id" => $tps->id,
            ]);

            // 3️⃣ Buat user login otomatis
            $role = \App\Models\Role::firstOrCreate(["role" => "kpps"]);
            // $randomPassword = Str::upper(Str::random(4)) . rand(10, 99);
            // dd($request->kpps_username);

            $user = \App\Models\User::create([
                "name" => $kpps->name,
                "username" => $request->kpps_username,
                "password" => bcrypt("password"),
                "temporary_password" => "password",
                "role_id" => $role->id,
                "userable_type" => \App\Models\KPPSMember::class,
                "userable_id" => $kpps->id,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with(
                    "success",
                    "TPS & Ketua KPPS berhasil dibuat! Password sementara: <strong>password</strong>",
                );
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage(), $e->getTraceAsString());
            return back()->withErrors(["error" => $e->getMessage()]);
        }
    }

    public function updateVoters(Request $request, $id)
    {
        $request->validate([
            "number_of_voters" => "required|integer|min:0",
        ]);

        $tps = \App\Models\TPS::findOrFail($id);
        $tps->update(["number_of_voters" => $request->number_of_voters]);

        return back()->with("success", "Jumlah pemilih berhasil diperbarui.");
    }

    // public function store(Request $request, Desa $desa)
    // {
    //     try {
    //         $validated = $request->validate([
    //             "tps_code" => "required|string|max:50|unique:tps,tps_code",
    //             "address" => "nullable|string|max:255",
    //             "kpps_name" => "required|string|max:255",
    //             "kpps_username" =>
    //                 "required|string|max:255|unique:users,username",
    //         ]);
    //         dd("validate success", $validated);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         dd("validate gagal", $e->errors());
    //     }
    // }
}
