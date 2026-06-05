<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sedi', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Equivale a: nome VARCHAR(150) NOT NULL
            $table->string('nome', 150);

            // Equivale a: indirizzo VARCHAR(255) NOT NULL
            $table->string('indirizzo', 255);

            // Equivale a: citta VARCHAR(100) NOT NULL
            $table->string('citta', 100);

            // Equivale a: cap CHAR(5) NULL
            // char() crea una colonna a lunghezza fissa (utile per il CAP)
            $table->char('cap', 5)->nullable();

            // Equivale a: telefono VARCHAR(20) NULL
            $table->string('telefono', 20)->nullable();

            // Equivale a: email VARCHAR(150) NULL
            $table->string('email', 150)->nullable();
        });
    }

    // Elimina la tabella in caso di rollback
    public function down(): void
    {
        Schema::dropIfExists('sedi');
    }
};