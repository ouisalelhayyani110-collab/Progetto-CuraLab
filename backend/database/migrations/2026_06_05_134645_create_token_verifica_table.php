<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token_verifica', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // FK verso pazienti — CASCADE: se si elimina il paziente,
            // si eliminano anche i suoi token
            $table->foreignId('paziente_id')
                  ->constrained('pazienti')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Token monouso — deve essere univoco nel sistema
            // Equivale a: token VARCHAR(255) NOT NULL UNIQUE
            $table->string('token', 255)->unique();

            // ENUM: accetta solo i valori specificati nell'array.
            // Equivale a: tipo ENUM('conferma_email', 'reset_password') NOT NULL
            $table->enum('tipo', ['conferma_email', 'reset_password']);

            // Data e ora di scadenza del token
            // Equivale a: scadenza TIMESTAMP NOT NULL
            $table->timestamp('scadenza');

            // Diventa TRUE dopo il primo utilizzo — impedisce il riutilizzo
            // Equivale a: usato BOOLEAN NOT NULL DEFAULT FALSE
            $table->boolean('usato')->default(false);

            // Solo created_at — i token non vengono mai modificati,
            // quindi updated_at non serve.
            // useCurrent() equivale a DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('created_at')->useCurrent();

            // Indice composto: velocizza la ricerca dei token
            // di un paziente per tipo (es. "tutti i token reset_password di X")
            $table->index(['paziente_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_verifica');
    }
};