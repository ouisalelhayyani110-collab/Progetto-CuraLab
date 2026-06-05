<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilita', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // FK verso medici — CASCADE: se si elimina il medico,
            // si eliminano anche i suoi turni di disponibilità
            $table->foreignId('medico_id')
                  ->constrained('medici')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // FK verso sedi — CASCADE: stesso principio
            $table->foreignId('sede_id')
                  ->constrained('sedi')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Giorno della settimana: 0=lunedì, 1=martedì, ..., 6=domenica
            // tinyInteger() equivale a TINYINT — occupa meno spazio di INT
            // per valori piccoli (0-127)
            $table->tinyInteger('giorno_settimana');

            // Fascia oraria del turno
            // time() equivale a TIME — memorizza solo l'ora, non la data
            $table->time('ora_inizio');
            $table->time('ora_fine');

            // Durata di ogni slot prenotabile in minuti
            // Equivale a: durata_slot_minuti INT NOT NULL DEFAULT 30
            $table->integer('durata_slot_minuti')->default(30);

            // Indice composto su medico e giorno: velocizza le query
            // che cercano i turni di un medico in un giorno specifico
            $table->index(['medico_id', 'giorno_settimana']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilita');
    }
};