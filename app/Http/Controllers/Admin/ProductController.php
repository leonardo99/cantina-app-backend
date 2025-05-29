<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::paginate();
            if(!$products) {
                return response()->json([], 204);
            }
            return ProductResource::collection($products);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

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
    
    public function show(Product $product)
    {
        try {
            return new ProductResource($product);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json([], 204);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
