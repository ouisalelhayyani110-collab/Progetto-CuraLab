<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medico_sede', function (Blueprint $table) {

            // Tabella ponte N:M — non ha un id proprio.
            // Ogni riga rappresenta l'associazione tra un medico e una sede.

            // FK verso medici — ON UPDATE CASCADE, ON DELETE CASCADE:
            // se si elimina un medico, si rimuovono automaticamente
            // tutte le sue associazioni con le sedi
            $table->foreignId('medico_id')
                  ->constrained('medici')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // FK verso sedi — stessa logica
            $table->foreignId('sede_id')
                  ->constrained('sedi')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Chiave primaria composta: la coppia (medico_id, sede_id)
            // deve essere unica — un medico non può essere associato
            // due volte alla stessa sede
            $table->primary(['medico_id', 'sede_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medico_sede');
    }
};