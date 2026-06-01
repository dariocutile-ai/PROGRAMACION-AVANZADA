<?php

namespace App\Http\Resources\Suppliers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SupplierResourceCollection extends ResourceCollection
{
    public $collects = SupplierResource::class;
}

