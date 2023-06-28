<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabelle "portfolio_entry_values" erstellen
     */
    public function up(): void
    {
        Schema::create('portfolio_entry_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_entries_id')->constrained();
            $table->dateTime('zeitpunkt');
            $table->decimal('wert', 12, 2);

            $table->unique(['portfolio_entries_id', 'zeitpunkt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_entry_values');
    }
};
