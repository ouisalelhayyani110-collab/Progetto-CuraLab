<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servizi', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Chiave esterna verso specializzazioni.
            // foreignId() crea una colonna INT NOT NULL chiamata specializzazione_id.
            // constrained() aggiunge automaticamente il vincolo FK verso la tabella
            // "specializzazioni" (la deduce dal nome della colonna).
            // cascadeOnUpdate() → ON UPDATE CASCADE
            // restrictOnDelete() → ON DELETE RESTRICT (non si può eliminare
            // una specializzazione se ha ancora servizi collegati)
            $table->foreignId('specializzazione_id')
                  ->constrained('specializzazioni')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Equivale a: nome VARCHAR(150) NOT NULL
            $table->string('nome', 150);

            // Equivale a: descrizione TEXT NULL
            $table->text('descrizione')->nullable();

            // Equivale a: durata_default_min INT NOT NULL DEFAULT 30
            $table->integer('durata_default_min')->default(30);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servizi');
    }
};