<?php

namespace App\Interfaces;

use App\Models\Report;

interface ReportRepositoryInterface extends RepositoryInterface
{
    public function create(array $data): Report;
}
