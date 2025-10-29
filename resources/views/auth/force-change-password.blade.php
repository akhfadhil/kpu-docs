
<div class="max-w-md mx-auto mt-20 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4 text-center">Ubah Password</h2>
    <p class="text-sm text-gray-500 mb-4 text-center">
        Anda menggunakan password sementara. Harap ubah untuk alasan keamanan.
    </p>

    <form method="POST" action="{{ route('password.force_change.update') }}">
        @csrf

        <div class="mb-4">
            <label for="new_password" class="block text-sm font-medium mb-1">Password Baru</label>
            <input type="password" id="new_password" name="new_password"
                class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2">
            @error('new_password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password_confirmation" class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2">
        </div>

        <button type="submit"
            class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 transition">
            Simpan Password Baru
        </button>
    </form>
</div>

