<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Tps;

class BreadcrumbHelper
{
    public static function build($entity)
    {
        $user = Auth::user();
        $role = $user->role->role;

        $desa = null;
        $kecamatan = null;
        $tps = null;

        // Deteksi tipe entity
        if ($entity instanceof Tps) {
            $tps = $entity;
            $desa = $tps->desa ?? null;
            $kecamatan = $desa->kecamatan ?? null;
        } elseif ($entity instanceof Desa) {
            $desa = $entity;
            $kecamatan = $desa->kecamatan ?? null;
        } elseif ($entity instanceof Kecamatan) {
            $kecamatan = $entity;
        }

        $breadcrumb = [
            [
                "label" => "Provinsi Jawa Timur",
                "url" => "#",
            ],
            [
                "label" => "Kabupaten Banyuwangi",
                "url" => $role === "admin" ? route("admin") : "#",
            ],
        ];

        if ($kecamatan) {
            $breadcrumb[] = [
                "label" => "Kecamatan " . ($kecamatan->name ?? "-"),
                "url" =>
                    in_array($role, ["admin", "ppk"]) && $kecamatan
                        ? route("kecamatan.index", $kecamatan->id)
                        : "#",
            ];
        }

        if ($desa) {
            $breadcrumb[] = [
                "label" => "Desa " . ($desa->name ?? "-"),
                "url" =>
                    in_array($role, ["admin", "ppk", "pps"]) && $desa
                        ? route("desa.index", $desa->id)
                        : "#",
            ];
        }

        if ($tps) {
            $breadcrumb[] = [
                "label" => $tps->tps_code ?? "-",
                "url" => null,
            ];
        }

        return $breadcrumb;
    }
}
