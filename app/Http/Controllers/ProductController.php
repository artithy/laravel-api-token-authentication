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

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'sku'            => 'required|string|unique:products,sku',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'vat_percentage' => 'nullable|numeric|min:0',
            'status'         => 'nullable|in:active,inactive',
        ]);

        try {
            $validated['status'] = $validated['status'] ?? 'active';

            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product creation failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
