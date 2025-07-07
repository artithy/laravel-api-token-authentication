<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Token;

class CategoryController extends Controller
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

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        if (!$category) {
            return response()->json([
                'message' => 'Category creation failed',
            ], 500);
        }

        return response()->json([
            'message' => 'Category created sucessfully',
            'category' => $category,
        ], 201);
    }

    public function getAllCatagories(Request $request)
    {

        $categories = Category::all();

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ], 200);
    }
}
