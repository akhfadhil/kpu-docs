<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Daftar TPS Desa {{ $desa->name }}</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 15px;
        }

        header img {
            max-width: 60px;
            /* lebar maksimal logo */
            height: auto;
            /* tinggi otomatis agar proporsional */
            margin-bottom: 5px;
        }

        header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        header h2 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
            color: #555;
        }

        h3 {
            text-align: center;
            font-size: 16px;
            margin: 15px 0;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 6px 8px;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        td.center {
            text-align: center;
        }

        .footer {
            margin-top: 25px;
            font-size: 11px;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .signature div {
            text-align: center;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('img/logo.png') }}" alt="Logo KPU">
        <h1>Komisi Pemilihan Umum</h1>
        <h2>Kabupaten Banyuwangi</h2>
    </header>

    <h3>Daftar TPS Desa {{ $desa->name }}</h3>

    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:15%">Kode TPS</th>
                <th style="width:35%">Alamat</th>
                <th style="width:20%">Username</th>
                <th style="width:20%">Temporary Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($desa->tps as $index => $tps)
                @php
                    $kpps = $tps->kpps_member->first();
                    $user = $kpps?->user;
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $tps->tps_code }}</td>
                    <td>{{ $tps->address }}</td>
                    <td>{{ $user->username ?? '-' }}</td>
                    <td>{{ $user->temporary_password ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB<br>
            {{-- <strong>Petugas: {{ auth()->user()->name ?? 'Sistem' }}</strong> --}}
        </p>
    </div>

    {{-- <div class="signature">
        <div>
            <p>Petugas Desa</p>
            <br><br><br>
            <p>(__________________)</p>
        </div>
    </div> --}}

</body>

</html>
