<?php

use App\Http\Controllers\Admin\AuthController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/createUser/{roleName}',[AuthController::class,'createUser']);
Route::get('/createRole/{roleName}', function ($roleName) {
    $role         =  new Role();
    $role->name   =  $roleName;
    $role->slug   =  strtolower(str_replace(' ', '_', $roleName));
    $role->save();
});

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
