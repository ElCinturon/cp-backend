<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioEntry extends BaseModel
{
    use HasFactory;

    // Beziehung zu Portfolioklasse herstellen
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    // Beziehung zu Values herstellen
    public function portfolioEntryValues(): HasMany
    {
        return $this->hasMany(PortfolioEntryValue::class);
    }
}
