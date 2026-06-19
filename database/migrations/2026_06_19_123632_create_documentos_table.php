<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\Estados;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->string('slug');
            $table->integer('version');

            $table->enum('estado', Estados::cases())->default(Estados::PUBLICADO);

            $table->string('path');
            $table->string('file_hash', 64);

            $table->timestamp('publicado_at')->nullable();
            $table->timestamp('retirado_at')->nullable();

            $table->foreignId('sustituye_a_documento_id')
                ->nullable()
                ->constrained('documentos')
                ->nullOnDelete();

            $table->foreignId('sustituido_por_documento_id')
                ->nullable()
                ->constrained('documentos')
                ->nullOnDelete();

            $table->foreignId('publicado_por_usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('retirado_por_usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(['slug', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
