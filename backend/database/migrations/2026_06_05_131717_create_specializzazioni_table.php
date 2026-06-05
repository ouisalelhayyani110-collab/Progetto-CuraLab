<?php

// Importa la classe base da cui ogni migration eredita
use Illuminate\Database\Migrations\Migration;

// Importa Blueprint: l'oggetto che rappresenta la struttura della tabella
// e mette a disposizione i metodi per definire colonne e vincoli
use Illuminate\Database\Schema\Blueprint;

// Importa Schema: la facciata di Laravel per creare, modificare
// ed eliminare tabelle nel database
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // up() viene eseguito quando si lancia "php artisan migrate"
    // — crea la tabella nel database
    public function up(): void
    {
        // Schema::create() crea una nuova tabella.
        // Primo argomento: nome della tabella.
        // Secondo argomento: funzione che riceve $table (un Blueprint)
        // e definisce colonne e vincoli.
        Schema::create('specializzazioni', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Equivale a: nome VARCHAR(100) NOT NULL UNIQUE
            $table->string('nome', 100)->unique();

            // Equivale a: descrizione TEXT NULL
            $table->text('descrizione')->nullable();
        });
    }

    // down() viene eseguito con "php artisan migrate:rollback"
    // — annulla la migration eliminando la tabella
    public function down(): void
    {
        Schema::dropIfExists('specializzazioni');
    }
};