<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medico_servizio', function (Blueprint $table) {

            // Tabella ponte N:M tra medici e servizi.
            // Ogni riga indica che un medico eroga un determinato servizio.

            // FK verso medici — CASCADE: se si elimina il medico,
            // si rimuovono le sue associazioni con i servizi
            $table->foreignId('medico_id')
                  ->constrained('medici')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // FK verso servizi — CASCADE: stesso principio
            $table->foreignId('servizio_id')
                  ->constrained('servizi')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Chiave primaria composta: la coppia (medico_id, servizio_id)
            // deve essere unica
            $table->primary(['medico_id', 'servizio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medico_servizio');
    }
};