<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PortfolioEntryValue
 *
 * @property int $id
 * @property int $portfolio_entry_id
 * @property string $time
 * @property string $value
 * @property-read \App\Models\PortfolioEntry $portfolioEntry
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue wherePortfolioEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntryValue whereValue($value)
 * @mixin \Eloquent
 */
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
