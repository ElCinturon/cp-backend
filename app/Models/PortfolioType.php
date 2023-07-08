<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
