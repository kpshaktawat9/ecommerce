<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryAttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return view('admin.auth.signin');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// grouped routes for admin with middleware
Route::middleware(['IsAdmin'])->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
    Route::post('/update-profile',[ProfileController::class,'store'])->name('profile.store');
    
    // Home Banner
    Route::get('/home-banner',[HomeBannerController::class,'index'])->name('home.banner');
    Route::post('/home-banner-store',[HomeBannerController::class,'store'])->name('home.banner.store');
    Route::post('/home-banner-delete',[HomeBannerController::class,'destroy'])->name('home.banner.delete');
    
    // Size
    Route::get('/size',[SizeController::class,'index'])->name('size');
    Route::post('/size-store',[SizeController::class,'store'])->name('size.store');
    Route::post('/size-delete',[SizeController::class,'destroy'])->name('size.delete');
    
    // Color
    Route::get('/color',[ColorController::class,'index'])->name('color');
    Route::post('/color-store',[ColorController::class,'store'])->name('color.store');
    Route::post('/color-delete',[ColorController::class,'destroy'])->name('color.delete');
    
    // Attribute
    Route::get('/attribute',[AttributeController::class,'index'])->name('attribute');
    Route::post('/attribute-store',[AttributeController::class,'store'])->name('attribute.store');
    Route::post('/attribute-delete',[AttributeController::class,'destroy'])->name('attribute.delete');
    
    // Attribute Values
    Route::get('/attribute-value',[AttributeValueController::class,'index'])->name('attribute-value');
    Route::post('/attribute-value-store',[AttributeValueController::class,'store'])->name('attribute-value.store');
    Route::post('/attribute-value-delete',[AttributeValueController::class,'destroy'])->name('attribute-value.delete');
    
    // Category
    Route::get('/category',[CategoryController::class,'index'])->name('category');
    Route::post('/category-store',[CategoryController::class,'store'])->name('category.store');
    Route::post('/category-delete',[CategoryController::class,'destroy'])->name('category.delete');
    
    // Category Attribute
    Route::get('/category-attribute',[CategoryAttributeController::class,'index'])->name('category-attribute');
    Route::post('/category-attribute-store',[CategoryAttributeController::class,'store'])->name('category-attribute.store');
    Route::post('/category-attribute-delete',[CategoryAttributeController::class,'destroy'])->name('category-attribute.delete');


    // logout
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/admin/login');
    })->name('logout');
});