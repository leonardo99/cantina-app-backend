<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::paginate();
            if(!$categories) {
                return response()->json(['error' => 'Ocorreu um erro ao tentar retornar as categorias'], 500);
            }
            return CategoryResource::collection($categories);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function store(CategoryRequest $request)
    {
        $categoryInputs = $request->validated();
        try {
            $saveCategory = Category::firstOrNew(['name' => $categoryInputs['name']], $categoryInputs);
            $saveCategory->save();
            if(!$saveCategory) {
                return response()->json(['error' => 'Ocorreu um erro ao tentar cadastrar a categoria'], 500);
            }
            
            return new CategoryResource($saveCategory);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
