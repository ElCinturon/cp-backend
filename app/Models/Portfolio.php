<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Portfolio
 *
 * @property int $id
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $type_id
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PortfolioEntry> $portfolioEntries
 * @property-read int|null $portfolio_entries_count
 * @property-read \App\Models\PortfolioType $portfolioType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Portfolio whereUserId($value)
 * @mixin \Eloquent
 */
class Portfolio extends BaseModel
{
    use HasFactory;

    // Beziehung zu Userklasse herstellen
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolioType(): BelongsTo
    {
        return $this->belongsTo(PortfolioType::class, 'type_id');
    }

    // Beziehung zu Entries herstellen
    public function portfolioEntries(): HasMany
    {
        return $this->hasMany(PortfolioEntry::class);
    }

    protected $fillable = [
        'description',
        'type_id',
        'user_id'
    ];

    protected $hidden = [];
}
