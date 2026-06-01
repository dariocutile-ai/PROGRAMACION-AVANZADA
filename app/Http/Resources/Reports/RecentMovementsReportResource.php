<?php

namespace App\Http\Resources\Reports;

use App\Models\InventoryMovement;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentMovementsReportResource extends JsonResource
{
    /** @var InventoryMovement */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'unit_cost' => $this->unit_cost,
            'note' => $this->note,
            'product' => $this->whenLoaded('product', fn () => [
                'id' => $this->product?->id,
                'sku' => $this->product?->sku,
                'name' => $this->product?->name,
                'category' => $this->product?->category?->name,
            ]),
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ]),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

