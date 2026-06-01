<?php

namespace App\Http\Resources\Reports;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MostSoldReportResourceCollection extends ResourceCollection
{
    public $collects = MostSoldReportResource::class;
}

