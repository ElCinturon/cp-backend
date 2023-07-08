<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'description' => $this->description,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'portfolioType' => [
                'description' => $this->portfolioType->description,
                'code' => $this->portfolioType->code,
            ]
        ];
    }
}
