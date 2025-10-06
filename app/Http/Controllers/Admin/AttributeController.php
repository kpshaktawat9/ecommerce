<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $attributes = Attribute::all();
        return view('admin.Attribute.index',compact('attributes'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        $storeData = Attribute::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'slug' => $request->slug,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Attribute data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $size = Attribute::find($request->id);
        if (!$size) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        $size->delete();

        return response()->json(['message' => 'Attribute deleted successfully']);
    }
}
