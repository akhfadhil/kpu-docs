<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 | Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col justify-center items-center h-screen">
    <div class="text-center">
        <h1 class="text-9xl font-extrabold text-yellow-500">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mt-4">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-600 mt-2">Sepertinya halaman yang Anda cari tidak tersedia.</p>
        <a href="{{ url('/') }}"
           class="inline-block mt-6 px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
