<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\PortfolioEntry
 *
 * @property int $id
 * @property int $portfolio_id
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\PortfolioEntryValue|null $latestValue
 * @property-read \App\Models\Portfolio $portfolio
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PortfolioEntryValue> $portfolioEntryValues
 * @property-read int|null $portfolio_entry_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry wherePortfolioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    // Gibt den aktuellsten Wert des Portfolioeintrags zurück
    public function latestValue(): HasOne
    {
        return $this->portfolioEntryValues()->one()->ofMany('time', 'max');
    }

    protected $fillable = [
        'description',
        'portfolio_id'
    ];
}
