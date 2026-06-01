<?php

namespace App\Http\Resources\Reports;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class InventorySummaryReportResource extends JsonResource
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
            'reorder_level' => $this->reorder_level,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ]),
            'supplier' => $this->whenLoaded('supplier', fn () => [
                'id' => $this->supplier?->id,
                'name' => $this->supplier?->name,
            ]),
        ];
    }
}

