<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $attributeValues = AttributeValue::with('singleAttribute')->get();
        $allAttributes = Attribute::all();
        return view('admin.AttributeValue.index',compact('attributeValues','allAttributes'));
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
            'attribute_id' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        $storeData = AttributeValue::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'attribute_id' => $request->attribute_id,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Attribute Value data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $size = AttributeValue::find($request->id);
        if (!$size) {
            return response()->json(['message' => 'Attribute Value not found'], 404);
        }

        $size->delete();

        return response()->json(['message' => 'Attribute Value deleted successfully']);
    }
}
