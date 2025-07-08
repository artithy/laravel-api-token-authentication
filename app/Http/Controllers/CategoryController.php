<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Token;

class CategoryController extends Controller
{

    public function store(Request $request)
    {

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
