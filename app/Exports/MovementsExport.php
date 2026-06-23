<?php

namespace App\Exports;

use App\Services\Reports\ReportsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MovementsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private ReportsService $reportsService) {}

    public function collection()
    {
        return $this->reportsService->recentMovements(100);
    }

    public function headings(): array
    {
        return ['Fecha', 'Producto', 'Tipo', 'Cantidad', 'Costo Unitario', 'Usuario'];
    }

    public function map($movement): array
    {
        return [
            $movement->created_at?->format('Y-m-d H:i:s'),
            $movement->product?->name,
            ['purchase'=>'Compra','restock'=>'Reabastecimiento','sale'=>'Venta','waste'=>'Merma'][$movement->type] ?? $movement->type,
            $movement->quantity,
            $movement->unit_cost,
            $movement->user?->name,
        ];
    }
}
