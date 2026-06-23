<?php

namespace App\Exports;

use App\Services\Reports\ReportsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        private ReportsService $reportsService,
        private ?string $categoryId
    ) {}

    public function collection()
    {
        return $this->reportsService->byCategory($this->categoryId);
    }

    public function headings(): array
    {
        return ['SKU', 'Producto', 'Categoría', 'Proveedor', 'Stock', 'Valor Total'];
    }

    public function map($product): array
    {
        return [
            $product->sku,
            $product->name,
            $product->category?->name,
            $product->supplier?->name,
            $product->stock,
            $product->stock * (float) $product->purchase_price,
        ];
    }
}
