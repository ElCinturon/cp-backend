<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tabelle "Portfolios" erstellen mit Bezug zu Typ und User
     */
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('bezeichnung');
            $table->dateTime('erstellt_am');
            $table->foreignId('type_id')->constrained('portfolio_types')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unique(['user_id', 'bezeichnung', 'type_id']);
        });

        // Erstellungsdatum setzen
        DB::unprepared('CREATE TRIGGER portfolios_now BEFORE INSERT ON portfolios FOR EACH ROW SET @erstellt_am = NOW()');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
