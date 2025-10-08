<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $taxes = Tax::all();
        return view('admin.Tax.index', compact('taxes'));
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
            'rate' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        $storeData = Tax::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'rate' => $request->rate,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Tax data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tax $tax)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $Tax = Tax::find($request->id);
        if (!$Tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }

        $Tax->delete();

        return response()->json(['message' => 'Tax deleted successfully']);
    }
}
