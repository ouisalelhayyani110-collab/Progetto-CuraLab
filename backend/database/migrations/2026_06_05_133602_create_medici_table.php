<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medici', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Equivale a: nome VARCHAR(100) NOT NULL
            $table->string('nome', 100);

            // Equivale a: cognome VARCHAR(100) NOT NULL
            $table->string('cognome', 100);

            // FK verso specializzazioni — stesso pattern della migration servizi
            $table->foreignId('specializzazione_id')
                  ->constrained('specializzazioni')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Equivale a: email VARCHAR(150) NULL
            $table->string('email', 150)->nullable();

            // Equivale a: telefono VARCHAR(20) NULL
            $table->string('telefono', 20)->nullable();

            // Percorso del file immagine, NULL finché non viene caricata
            // Equivale a: foto VARCHAR(255) NULL
            $table->string('foto', 255)->nullable();

            // Testo breve per il carosello pubblico
            // Equivale a: biografia TEXT NULL
            $table->text('biografia')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medici');
    }
};