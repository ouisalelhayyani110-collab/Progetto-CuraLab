<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('richieste_contatto', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Dati del mittente — obbligatori anche per i non registrati
            $table->string('nome', 150);
            $table->string('email', 150);

            // Oggetto opzionale del messaggio
            $table->string('oggetto', 255)->nullable();

            // Testo del messaggio — obbligatorio
            $table->text('messaggio');

            // FK nullable verso pazienti.
            // nullable(): la colonna accetta NULL (mittente non registrato)
            // nullOnDelete(): ON DELETE SET NULL: se il paziente elimina
            // il suo account, il messaggio resta ma paziente_id diventa NULL
            $table->foreignId('paziente_id')
                  ->nullable()
                  ->constrained('pazienti')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // Flag che indica se la richiesta è stata presa in carico dallo staff
            $table->boolean('presa_in_carico')->default(false);

            // Solo data di invio — le richieste non vengono mai modificate
            $table->timestamp('data_invio')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('richieste_contatto');
    }
};
