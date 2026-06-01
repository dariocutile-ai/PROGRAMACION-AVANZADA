<?php

namespace App\Http\Resources\Reports;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LowStockReportResourceCollection extends ResourceCollection
{
    public $collects = LowStockReportResource::class;
}

