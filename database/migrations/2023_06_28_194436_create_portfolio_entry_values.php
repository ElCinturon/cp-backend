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
            $table->foreignId('portfolio_entry_id')->constrained()->cascadeOnDelete();
            $table->dateTime('time');
            $table->decimal('value', 12, 2);

            $table->unique(['portfolio_entry_id', 'time']);
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
