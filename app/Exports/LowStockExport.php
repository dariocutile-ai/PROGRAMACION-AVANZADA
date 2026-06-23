<?php

namespace App\Exports;

use App\Services\Reports\ReportsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LowStockExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private ReportsService $reportsService) {}

    public function collection()
    {
        return $this->reportsService->lowStock();
    }

    public function headings(): array
    {
        return ['SKU', 'Producto', 'Categoría', 'Stock Actual', 'Nivel Mínimo'];
    }

    public function map($product): array
    {
        return [
            $product->sku,
            $product->name,
            $product->category?->name,
            $product->stock,
            $product->reorder_level,
        ];
    }
}
