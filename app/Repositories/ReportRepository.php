<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Models\Report;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }
}
