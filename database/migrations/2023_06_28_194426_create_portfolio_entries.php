<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tabelle "portfolio_entries" erstellen
     */
    public function up(): void
    {
        Schema::create('portfolio_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained();
            $table->string('bezeichnung');
            $table->dateTime('erstellt_am');

            $table->unique(['portfolio_id', 'bezeichnung']);
        });

        // Erstellungsdatum setzen
        DB::unprepared('CREATE TRIGGER portfolio_entries_now BEFORE INSERT ON portfolio_entries FOR EACH ROW SET @erstellt_am = NOW()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_entries');
    }
};
