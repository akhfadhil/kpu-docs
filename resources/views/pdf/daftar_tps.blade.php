<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Daftar TPS Desa {{ $desa->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Daftar TPS Desa {{ $desa->name }}</h2>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>

                <th>Kode TPS</th>
                <th>Alamat</th>
                <th>Username</th>
                <th>Temporary Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($desa->tps as $tps)
                @php
                    $kpps = $tps->kpps_member->first(); // Ambil satu ketua KPPS
                    $user = $kpps?->user;
                @endphp

                <tr>
                    <td>{{ $tps->tps_code }}</td>
                    <td>{{ $tps->address }}</td>
                    <td>{{ $user->username ?? '-' }}</td>
                    <td>{{ $user->temporary_password ?? '-' }}</td>
                </tr>
            @endforeach


        </tbody>
    </table>

</body>

</html>
