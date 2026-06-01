<?php

namespace App\Http\Resources\Reports;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryStockReportResource extends JsonResource
{
    /** @var Product */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'stock' => $this->stock,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ]),
        ];
    }
}

