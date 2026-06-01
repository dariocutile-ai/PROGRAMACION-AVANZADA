<?php

namespace App\Http\Resources\Reports;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class MostSoldReportResource extends JsonResource
{
    /** @var Product */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'total_sold' => (int) $this->getAttribute('total_sold', 0),
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ]),
        ];
    }
}

