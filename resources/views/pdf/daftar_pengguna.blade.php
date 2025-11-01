<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #aaa; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .footer { text-align: right; font-size: 10px; margin-top: 10px; color: #666; }
    </style>
</head>
<body>
    <h2>{{ $judul }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Temporary Password</th>
                <th>Role</th>
                <th>Wilayah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $i => $u)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->temporary_password ?? '-' }}</td>
                    <td>{{ strtoupper($u->role->role) }}</td>
                    <td>
                        @if ($u->role->role === 'ppk' && $u->userable)
                            {{ $u->userable->kecamatan->name }}
                        @elseif ($u->role->role === 'pps' && $u->userable)
                            {{ $u->userable->desa->name }} ({{ $u->userable->desa->kecamatan->name }})
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer">Dicetak pada {{ now()->format('d M Y, H:i') }}</p>
</body>
</html>
