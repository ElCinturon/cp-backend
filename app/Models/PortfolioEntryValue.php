<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioEntryValue extends BaseModel
{
    use HasFactory;

    // Beziehung zu Portfolioentry herstellen
    public function portfolioEntry(): BelongsTo
    {
        return $this->belongsTo(PortfolioEntry::class);
    }
}
