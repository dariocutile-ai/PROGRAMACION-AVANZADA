<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryResourceCollection extends ResourceCollection
{
    public $collects = CategoryResource::class;
}

