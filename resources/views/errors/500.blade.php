<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>500 | Terjadi Kesalahan Server</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col justify-center items-center h-screen">
    <div class="text-center">
        <h1 class="text-9xl font-extrabold text-red-600">500</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mt-4">Terjadi Kesalahan di Server</h2>
        <p class="text-gray-600 mt-2">Kami sedang memperbaikinya. Silakan coba beberapa saat lagi.</p>
        <a href="{{ url('/') }}"
           class="inline-block mt-6 px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
