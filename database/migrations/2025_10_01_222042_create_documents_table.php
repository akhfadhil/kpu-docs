<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->enum('doc_type', ['d_hasil_kec', 'd_hasil_desa', 'c_hasil_ppwp', 'c_hasil_dpr_ri', 'c_hasil_dpd', 'c_hasil_dprd_prov', 'c_hasil_dprdp_kab'])->nullable(); // atau enum sesuai kebutuhan
            $table->string('path'); // path file di storage
            $table->nullableMorphs('documentable'); // dokumenable_id, dokumenable_type
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
