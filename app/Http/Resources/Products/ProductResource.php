<?php

namespace App\Http\Resources\Products;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /** @var Product */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ]),
            'supplier' => $this->whenLoaded('supplier', fn () => [
                'id' => $this->supplier?->id,
                'name' => $this->supplier?->name,
            ]),
            'stock' => $this->stock,
            'reorder_level' => $this->reorder_level,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

