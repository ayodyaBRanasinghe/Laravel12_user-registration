<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;


class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = $this->productService->createProduct($validated);
       
        return response()->json($product, 201);
    }
}