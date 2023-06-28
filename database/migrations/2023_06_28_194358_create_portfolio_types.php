<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tabelle "portfolio_types" erstellen und Typen anlegen
     */
    public function up(): void
    {
        Schema::create('portfolio_types', function (Blueprint $table) {
            $table->id();
            $table->string('bezeichnung')->unique();
            $table->string('kuerzel')->unique();
        });

        DB::table('portfolio_types')->insert([
            ['bezeichnung' => 'Wertpapiere', 'kuerzel' => 'wp'],
            ['bezeichnung' => 'Immobilien', 'kuerzel' => 'im'],
            ['bezeichnung' => 'Fahrzeuge', 'kuerzel' => 'fz'],
            ['bezeichnung' => 'Barvermögen', 'kuerzel' => 'bv'],
            ['bezeichnung' => 'Schmuck', 'kuerzel' => 'sm'],
            ['bezeichnung' => 'Sonstiges', 'kuerzel' => 'so'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_types');
    }
};
