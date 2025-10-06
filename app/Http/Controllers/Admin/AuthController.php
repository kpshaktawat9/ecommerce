<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  // login
  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:4'
    ]);
    
    // Auth check
    if(Auth::check()){
        return response()->json(['message' => 'Already logged in','url' => route('admin.dashboard')], 200);
    }
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user = Auth::user();
        return response()->json(['message' => 'Login successful','url' => route('admin.dashboard')], 200);
    }else{
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
  }
  //
  public function createUser($roleName)
  {
    $user         =  new User();
    $user->name   =  'Admin User';
    $user->email   =  'Admin@gmail.com';
    $user->password = Hash::make('1234');
    $user->save();

    $customer = Role::where('slug', strtolower(str_replace(' ', '_', $roleName)))->first();

    $user->roles()->attach($customer);
  }
}
