<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sizes = Size::all();
        return view('admin.Size.index',compact('sizes'));
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
            'value' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        $storeData = Size::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'value' => $request->value,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Size data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $size = Size::find($request->id);
        if (!$size) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $size->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
