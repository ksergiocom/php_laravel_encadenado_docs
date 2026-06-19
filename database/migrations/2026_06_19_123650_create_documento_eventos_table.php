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
        Schema::create('documento_eventos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('documento_id')
                ->constrained('documentos')
                ->cascadeOnDelete();

            $table->enum('tipo', Estados::values());

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('documento_file_hash', 64)->nullable();
            $table->string('documento_previo_file_hash', 64)->nullable();

            $table->foreignId('documento_previo_id')
                ->nullable()
                ->constrained('documentos')
                ->nullOnDelete();

            $table->string('previous_event_hash', 64)->nullable();
            $table->string('event_hash', 64);

            $table->json('payload');

            $table->ipAddress('ip')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->unique('event_hash');
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
