<?php

namespace App\Http\Resources\Reports;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InventorySummaryReportResourceCollection extends ResourceCollection
{
    public $collects = InventorySummaryReportResource::class;
}

