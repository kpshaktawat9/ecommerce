<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $homeBanners = HomeBanner::all();
        return view('admin.HomeBanner.index',compact('homeBanners'));
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
            'link' => 'required',
            'text' => 'required',
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
            $filePath = $file->storeAs('uploads/home_banners/', $fileName, 'public');
            $imageUrl = '/storage/'.$filePath;

            // delete old image
            $oldImage = HomeBanner::where('id',$request->id)->first();
            if($oldImage && $oldImage->image){
                $oldImagePath = str_replace('/storage/', '', $oldImage->image);
                if (file_exists(storage_path('app/public/' . $oldImagePath))) {
                    unlink(storage_path('app/public/' . $oldImagePath));
                }
            }
        }else{
            if($request->id)
            {
                $homebanner = HomeBanner::where('id',$request->id)->first();

                $imageUrl = $homebanner->image;
            }
        }

        $storeData = HomeBanner::updateOrCreate(
            ['id' => $request->id],
            [
                'link' => $request->link,
                'text' => $request->text,
                'image' => $imageUrl,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => "Home Banner data Updated Successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeBanner $homeBanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeBanner $homeBanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeBanner $homeBanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $homeBanner = HomeBanner::find($request->id);
        if (!$homeBanner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        if ($homeBanner->image) {
            $oldImagePath = str_replace('/storage/', '', $homeBanner->image);
            if (file_exists(storage_path('app/public/' . $oldImagePath))) {
                unlink(storage_path('app/public/' . $oldImagePath));
            }
        }

        $homeBanner->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
