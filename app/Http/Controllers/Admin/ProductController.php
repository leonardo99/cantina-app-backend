<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $productInputs = $request->validated();
        try {
            $saveProduct = Product::firstOrNew(['name' => $productInputs['name']], $productInputs);
            $saveProduct->save();
            if(!$saveProduct) {
                return response()->json(['error' => 'Ocorreu um erro ao tentar cadastrar o produto'], 500);
            }
            
            return new ProductResource($saveProduct);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $productInputs = $request->validated();
        try {
            $product->update($productInputs);
            return new ProductResource($product);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
