<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;

class ProductByCategoryController extends Controller
{
    public function index(Category $category)
    {
        return ProductResource::collection($category->products()->paginate());
    }
}
