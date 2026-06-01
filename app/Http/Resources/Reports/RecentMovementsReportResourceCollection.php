<?php

namespace App\Http\Resources\Reports;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecentMovementsReportResourceCollection extends ResourceCollection
{
    public $collects = RecentMovementsReportResource::class;
}

