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

        $token = Token::where('token', $request->token)->where('is_active', 1)->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token',
            ], 401);
        }

        $fixedCategoryId = 1;

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
            'category_id' => $fixedCategoryId,
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
}
