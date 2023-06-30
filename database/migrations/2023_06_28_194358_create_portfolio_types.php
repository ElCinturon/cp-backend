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
            $table->string('description')->unique();
            $table->string('code')->unique();
        });

        DB::table('portfolio_types')->insert([
            ['description' => 'Wertpapiere', 'code' => 'wp'],
            ['description' => 'Immobilien', 'code' => 'im'],
            ['description' => 'Fahrzeuge', 'code' => 'fz'],
            ['description' => 'Barvermögen', 'code' => 'bv'],
            ['description' => 'Schmuck', 'code' => 'sm'],
            ['description' => 'Sonstiges', 'code' => 'so'],
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
