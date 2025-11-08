// <!-- Script redirect -->
document.getElementById("btnCari").addEventListener("click", function () {
    const kecamatanId = document.getElementById("kecamatan").value;
    const desaId = document.getElementById("desa").value;

    if (desaId) {
        window.location.href = `/desa/${desaId}`;
    } else if (kecamatanId) {
        window.location.href = `/kecamatan/${kecamatanId}`;
    } else {
        alert("Silakan pilih kecamatan terlebih dahulu.");
    }
});

// <!-- Script Modal PDF -->
// Buka modal PDF
document.querySelectorAll(".pdf-view-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        const pdfUrl = btn.getAttribute("data-pdf");
        const modal = document.getElementById("pdfModal");
        const container = document.getElementById("pdfModalContainer");
        const frame = document.getElementById("pdfFrame");

        frame.src = pdfUrl;
        modal.classList.remove("hidden");

        setTimeout(() => {
            container.classList.remove("opacity-0", "scale-95");
            container.classList.add("opacity-100", "scale-100");
        }, 50);
    });
});

// Tutup modal
document.querySelectorAll('[data-modal-hide="pdfModal"]').forEach((btn) => {
    btn.addEventListener("click", closeModal);
});

function closeModal() {
    const modal = document.getElementById("pdfModal");
    const container = document.getElementById("pdfModalContainer");
    const frame = document.getElementById("pdfFrame");

    container.classList.add("opacity-0", "scale-95");
    container.classList.remove("opacity-100", "scale-100");
    setTimeout(() => {
        modal.classList.add("hidden");
        frame.src = "";
    }, 200);
}

// Klik luar modal
document.getElementById("pdfModal").addEventListener("click", (e) => {
    if (e.target.id === "pdfModal") closeModal();
});

// <!-- Script Filter Pengumuman -->
document.addEventListener("DOMContentLoaded", function () {
    const roleFilter = document.getElementById("announcementRoleFilter");
    const tableRows = document.querySelectorAll("#announcementTable tbody tr");

    roleFilter.addEventListener("change", function () {
        const selectedRole = this.value;
        tableRows.forEach((row) => {
            const rowRole = row.getAttribute("data-role");
            if (!selectedRole || rowRole === selectedRole) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});

// <!-- Script Edit User Modal -->
document.querySelectorAll(".editUserBtn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const id = this.dataset.id;
        const name = this.dataset.name;
        document.getElementById("editUserId").value = id;
        document.getElementById("editUserName").value = name;

        // Update form action
        const form = document.getElementById("editUserForm");
        form.action = `/users/${id}`;
    });
});

// <!-- Script filter dan pagination -->
document.addEventListener("DOMContentLoaded", function () {
    const roleFilter = document.getElementById("filterRole");
    const wilayahFilter = document.getElementById("filterWilayah");
    const rows = Array.from(document.querySelectorAll("#userTableBody tr"));
    const pagination = document.getElementById("pagination");
    const rowsPerPage = 25;
    let currentPage = 1;

    // Fungsi utama untuk render tabel berdasarkan filter + pagination
    function renderTable() {
        const selectedRole = roleFilter.value.toLowerCase();
        const selectedWilayah = wilayahFilter
            ? wilayahFilter.value.toLowerCase()
            : "";

        // Filter data dulu
        const filteredRows = rows.filter((row) => {
            const rowRole = row.dataset.role;
            const rowWilayah = row.dataset.wilayah;
            const matchRole = !selectedRole || rowRole === selectedRole;
            const matchWilayah =
                !selectedWilayah || rowWilayah.includes(selectedWilayah);
            return matchRole && matchWilayah;
        });

        // Pagination
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Reset semua row ke hidden
        rows.forEach((row) => (row.style.display = "none"));

        // Tampilkan hanya row yang lolos filter + halaman aktif
        filteredRows.slice(start, end).forEach((row, i) => {
            row.style.display = "";
            // Update nomor urut
            row.querySelector("td").textContent = start + i + 1;
        });

        // Render pagination
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        pagination.innerHTML = "";
        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.className =
                "px-3 py-1 border rounded-md text-sm " +
                (i === currentPage
                    ? "bg-blue-500 text-white border-blue-500"
                    : "bg-white text-gray-700 border-gray-300 hover:bg-gray-100");

            btn.addEventListener("click", function () {
                currentPage = i;
                renderTable();
                document.getElementById("user-section").scrollIntoView({
                    behavior: "smooth",
                });
            });
            pagination.appendChild(btn);
        }
    }

    // Event filter
    roleFilter.addEventListener("change", function () {
        currentPage = 1;
        renderTable();
    });
    if (wilayahFilter) {
        wilayahFilter.addEventListener("change", function () {
            currentPage = 1;
            renderTable();
        });
    }

    renderTable();
});
