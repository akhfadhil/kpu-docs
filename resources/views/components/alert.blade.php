@if (session('success') || session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const isToast = @json(session('toast', false));
            const type = "{{ session('success') ? 'success' : 'error' }}";
            const message = "{{ session('success') ?? session('error') }}";

            if (isToast) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type,
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    icon: type,
                    title: type === 'success' ? 'Berhasil!' : 'Gagal!',
                    text: message,
                });
            }
        });
    </script>
@endif
