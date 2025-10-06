<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $colors = Color::all();
        return view('admin.Color.index',compact('colors'));
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
            'code' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        $storeData = Color::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'code' => $request->code,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Color data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $color = Color::find($request->id);
        if (!$color) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $color->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
