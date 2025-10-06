<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.profile');
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
            'email' => 'required',
            'mobile' => 'required',
            'name' => 'required',
            'address' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator  ->messages()
            ], 400);
        }

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $imageUrl = '/storage/'.$filePath;

            // delete old image
            $oldImage = User::where('id',$request->id)->first();
            if($oldImage && $oldImage->image){
                $oldImagePath = str_replace('/storage/', '', $oldImage->image);
                if (file_exists(storage_path('app/public/' . $oldImagePath))) {
                    unlink(storage_path('app/public/' . $oldImagePath));
                }
            }
        }else{
            $imageUrl = Auth::user()->image;
        }

        $storeData = User::updateOrCreate(
            ['id' => $request->id],
            [
                'email' => $request->email,
                'mobile' => $request->mobile,
                'name' => $request->name,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'image' => $imageUrl,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "User data Updated Successfully"
        ], 200);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
