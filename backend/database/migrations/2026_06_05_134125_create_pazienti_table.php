<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pazienti', function (Blueprint $table) {

            // Equivale a: id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Equivale a: nome VARCHAR(100) NOT NULL
            $table->string('nome', 100);

            // Equivale a: cognome VARCHAR(100) NOT NULL
            $table->string('cognome', 100);

            // Equivale a: email VARCHAR(150) NOT NULL UNIQUE
            $table->string('email', 150)->unique();

            // La password viene sempre salvata come hash — mai in chiaro.
            // Il nome password_hash è descrittivo; è gestito nel Model.
            // Equivale a: password_hash VARCHAR(255) NOT NULL
            $table->string('password_hash', 255);

            // Equivale a: telefono VARCHAR(20) NULL
            $table->string('telefono', 20)->nullable();

            // Equivale a: data_nascita DATE NULL
            $table->date('data_nascita')->nullable();

            // CHAR(16) a lunghezza fissa per il codice fiscale italiano.
            // nullable() perché potrebbe non essere inserito subito.
            // unique() perché ogni CF deve essere univoco nel sistema.
            $table->char('codice_fiscale', 16)->nullable()->unique();

            // Flags booleani — di default FALSE finché il paziente
            // non completa le azioni richieste
            $table->boolean('email_confermata')->default(false);
            $table->boolean('consenso_termini')->default(false);
            $table->boolean('consenso_privacy')->default(false);

            // Aggiunge created_at e updated_at automaticamente.
            // Laravel li aggiorna da solo ad ogni insert/update.
            // Equivale a: created_at TIMESTAMP e updated_at TIMESTAMP
            $table->timestamps();

            // Soft delete GDPR: aggiunge la colonna deleted_at TIMESTAMP NULL.
            // Quando un paziente "elimina" il suo account, Laravel imposta
            // deleted_at con la data corrente invece di cancellare la riga.
            // I dati restano nel DB per gli obblighi di conservazione sanitaria.
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pazienti');
    }
};