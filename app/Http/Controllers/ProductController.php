<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Token;
use Exception;

class ProductController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'name'           => 'required|string|max:255',
            'sku'            => 'required|string|unique:products,sku',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'vat_percentage' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',

        ]);


        $product = Product::create([
            'name' => $request['name'],
            'sku' => $request['sku'],
            'category_id' => $request['category_id'],
            'price' => $request['price'],
            'discount_price' => $request['discount_price'],
            'vat_percentage' => $request['vat_percentage'],
            'stock_quantity' => $request['stock_quantity'],
            'status' => $request['status'] ?? 'active',
        ]);

        if (!$product) {
            return response()->json([
                'message' => 'Product creation failed',
            ], 500);
        }

        return response()->json([
            'message' => 'product created successfully',
            'product' => $product,
        ], 201);
    }

    public function productsWithCategories(Request $request)
    {

        // $products = Product::all();
        $products = Product::leftJoin("categories", "products.category_id", "=", "categories.id")
            ->select("products.id", "products.name", "products.price", "products.discount_price", "products.vat_percentage", "products.stock_quantity", "products.status", "products.created_at", "categories.name as category_name")
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }
}
