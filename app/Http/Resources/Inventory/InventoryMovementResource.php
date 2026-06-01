<?php

namespace App\Http\Resources\Inventory;

use App\Models\InventoryMovement;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryMovementResource extends JsonResource
{
    /** @var InventoryMovement $resource */
    public $resource;

    public function toArray($request): array
    {
        $direction = match ($this->type) {
            'purchase', 'restock' => 'in',
            'sale', 'waste' => 'out',
            default => null,
        };

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'type' => $this->type,
            'direction' => $direction,
            'quantity' => $this->quantity,
            'unit_cost' => $this->unit_cost,
            'note' => $this->note,
            'reference_type' => $this->reference_type,
            'reference_id' => $this->reference_id,
            'created_at' => $this->created_at?->toISOString(),

            'product' => $this->whenLoaded('product', fn () => [
                'id' => $this->product?->id,
                'sku' => $this->product?->sku,
                'name' => $this->product?->name,
                'stock' => $this->product?->stock,
            ]),
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ]),
        ];
    }
}

