<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

    protected $fillable = [
        'description',
        'type_id',
        'user_id'
    ];

    protected $hidden = [
        'id',
    ];
}
