<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // === USERS TABLE ===
        Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("username")->unique();
            $table->string("password");
            $table->string("temporary_password")->nullable();

            // Relasi ke roles
            // $table
            //     ->foreignId("role_id")
            //     ->nullable()
            //     ->constrained("roles")
            //     ->nullOnDelete();

            // // Polymorphic link (bisa ke anggota_ppk / anggota_pps / anggota_kpps)
            // $table->unsignedBigInteger("userable_id")->nullable();
            // $table->string("userable_type")->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        // === PASSWORD RESET TOKENS ===
        Schema::create("password_reset_tokens", function (Blueprint $table) {
            $table->string("username")->primary();
            $table->string("token");
            $table->timestamp("created_at")->nullable();
        });

        // === SESSIONS ===
        Schema::create("sessions", function (Blueprint $table) {
            $table->string("id")->primary();
            $table->foreignId("user_id")->nullable()->index();
            $table->string("ip_address", 45)->nullable();
            $table->text("user_agent")->nullable();
            $table->longText("payload");
            $table->integer("last_activity")->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("sessions");
        Schema::dropIfExists("password_reset_tokens");
        Schema::dropIfExists("users");
    }
};
