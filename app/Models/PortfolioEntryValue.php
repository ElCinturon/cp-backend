<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioEntryValue extends BaseModel
{
    use HasFactory;

    // Updated_at/created_at Spalten deaktivieren
    public $timestamps = false;

    // Beziehung zu Portfolioentry herstellen
    public function portfolioEntry(): BelongsTo
    {
        return $this->belongsTo(PortfolioEntry::class);
    }

    protected $fillable = [
        'portfolio_entry_id',
        'time',
        'value'
    ];
}
