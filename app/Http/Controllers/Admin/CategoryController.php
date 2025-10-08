<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $parentCategories = Category::whereNull('parent_category_id')->get();
        $categories = Category::with('parentCategory')->get();
        return view('admin.Category.index',compact('categories','parentCategories'));
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
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        $imageUrl = null;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/categories/', $fileName, 'public');
            $imageUrl = '/storage/'.$filePath;

            // delete old image
            $oldImage = Category::where('id',$request->id)->first();
            if($oldImage && $oldImage->image){
                $oldImagePath = str_replace('/storage/', '', $oldImage->image);
                if (file_exists(storage_path('app/public/' . $oldImagePath))) {
                    unlink(storage_path('app/public/' . $oldImagePath));
                }
            }
        }else{
            if($request->id)
            {
                $categorie = Category::where('id',$request->id)->first();

                $imageUrl = $categorie->image;
            }
        }

        $storeData = Category::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_category_id' => $request->parent_category_id,
                'image' => $imageUrl,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Category data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        if ($category->image) {
            $oldImagePath = str_replace('/storage/', '', $category->image);
            if (file_exists(storage_path('app/public/' . $oldImagePath))) {
                unlink(storage_path('app/public/' . $oldImagePath));
            }
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function getCategoryAttributes(Request $request)
    {
        $category = Category::with('categoryAttributes.attribute.attributeValues')->find($request->id);

        return response()->json($category->categoryAttributes);
    }
}
