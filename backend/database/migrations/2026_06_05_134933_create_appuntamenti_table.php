<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appuntamenti', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // FK verso pazienti — RESTRICT: non si può eliminare un paziente
            // se ha ancora appuntamenti collegati
            $table->foreignId('paziente_id')
                  ->constrained('pazienti')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // FK verso medici — stesso principio
            $table->foreignId('medico_id')
                  ->constrained('medici')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // FK verso servizi — stesso principio
            $table->foreignId('servizio_id')
                  ->constrained('servizi')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // FK verso sedi — stesso principio
            $table->foreignId('sede_id')
                  ->constrained('sedi')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Data e ora dell'appuntamento.
            // dateTime() equivale a DATETIME — memorizza data e ora insieme
            $table->dateTime('data_ora');

            // Durata copiata dal servizio al momento della prenotazione:
            // così lo storico è preservato anche se la durata del servizio
            // viene modificata in futuro
            $table->integer('durata_minuti')->default(30);

            // Stato dell'appuntamento con valore di default 'confermato'
            $table->enum('stato', ['confermato', 'annullato', 'completato'])
                  ->default('confermato');

            // Note opzionali sull'appuntamento
            $table->text('note')->nullable();

            // Aggiunge created_at e updated_at
            $table->timestamps();

            // Indici sulle colonne più interrogate nelle query:
            // data_ora per cercare appuntamenti in un periodo,
            // stato per filtrare per stato
            $table->index('data_ora');
            $table->index('stato');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appuntamenti');
    }
};