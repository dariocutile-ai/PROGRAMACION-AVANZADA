<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Reports\ReportsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportExportController extends Controller
{
    public function __construct(private readonly ReportsService $reportsService) {}

    public function pdfInventory()
    {
        $products = $this->reportsService->inventorySummary();
        $pdf = Pdf::loadView('reports.pdf.inventory', compact('products'));
        return $pdf->download('inventario_general.pdf');
    }

    public function pdfLowStock()
    {
        $products = $this->reportsService->lowStock();
        $pdf = Pdf::loadView('reports.pdf.low_stock', compact('products'));
        return $pdf->download('stock_bajo.pdf');
    }

    public function pdfMovements()
    {
        $movements = $this->reportsService->recentMovements(100);
        $pdf = Pdf::loadView('reports.pdf.movements', compact('movements'));
        return $pdf->download('movimientos_recientes.pdf');
    }

    public function pdfByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $products = $this->reportsService->byCategory($categoryId);
        $pdf = Pdf::loadView('reports.pdf.by_category', compact('products'));
        return $pdf->download('inventario_por_categoria.pdf');
    }

    public function excelInventory()
    {
        return Excel::download(new \App\Exports\InventoryExport($this->reportsService), 'inventario_general.xlsx');
    }

    public function excelLowStock()
    {
        return Excel::download(new \App\Exports\LowStockExport($this->reportsService), 'stock_bajo.xlsx');
    }

    public function excelMovements()
    {
        return Excel::download(new \App\Exports\MovementsExport($this->reportsService), 'movimientos_recientes.xlsx');
    }

    public function excelByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        return Excel::download(new \App\Exports\CategoryExport($this->reportsService, $categoryId), 'inventario_por_categoria.xlsx');
    }
}
