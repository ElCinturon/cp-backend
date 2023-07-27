<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\PortfolioType
 *
 * @property int $id
 * @property string $description
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Portfolio> $portfolios
 * @property-read int|null $portfolios_count
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PortfolioType whereId($value)
 * @mixin \Eloquent
 */
class PortfolioType extends BaseModel
{
    use HasFactory;

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'type_id');
    }

    protected $hidden = [
        'id',
    ];
}
