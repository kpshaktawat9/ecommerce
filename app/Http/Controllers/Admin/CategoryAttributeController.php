<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $allCategories = Category::all();
        $allAttributes = Attribute::all();
        $categoryAttributes = CategoryAttribute::with('category', 'attribute')->get();
        return view('admin.CategoryAttribute.index', compact('categoryAttributes', 'allCategories', 'allAttributes'));
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
    public function store(Request $request)
    {
        //
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'attribute_id' => 'required|exists:attributes,id',
        ]);

        CategoryAttribute::updateOrCreate(
            ['id' => $request->id],
            [
                'category_id' => $request->category_id,
                'attribute_id' => $request->attribute_id,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Category Attribute data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryAttribute $CategoryAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryAttribute $CategoryAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryAttribute $CategoryAttribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $categoryAttribute = CategoryAttribute::find($request->id);
        if (!$categoryAttribute) {
            return response()->json(['message' => 'Category Attribute not found'], 404);
        }
        $categoryAttribute->delete();
        return response()->json(['message' => 'Category Attribute deleted successfully'], 200);
    }
}
