<?php

namespace App\Services\Inventory;

use App\Interfaces\InventoryMovementRepositoryInterface;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function __construct(private readonly InventoryMovementRepositoryInterface $repository) {}

    public function createMovement(array $data)
    {
        /** @var User|null $user */
        $user = auth()->user();


        return DB::transaction(function () use ($data, $user) {
            $product = Product::query()->lockForUpdate()->findOrFail((int) $data['product_id']);

            $type = (string) $data['type'];
            $quantity = (int) $data['quantity'];

            $delta = match ($type) {
                'purchase', 'restock' => $quantity,
                'sale', 'waste' => -$quantity,
                default => 0,
            };

            $newStock = (int) $product->stock + $delta;

            if ($delta < 0 && $newStock < 0) {
                abort(422, 'Stock insuficiente para la salida solicitada.');
            }

            $product->stock = $newStock;
            $product->save();

            $movement = $this->repository->create([
                'product_id' => $product->id,
                'user_id' => $user?->id,
                'type' => $type,
                'quantity' => $quantity,
                'unit_cost' => Arr::get($data, 'unit_cost', 0),
                'reference_type' => Arr::get($data, 'reference_type'),
                'reference_id' => Arr::get($data, 'reference_id'),
                'note' => Arr::get($data, 'note'),
            ]);

            return $movement;
        });
    }
}

