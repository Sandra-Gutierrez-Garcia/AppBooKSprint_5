<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // List only users with role 'writer'
        if($user->role == 'writer') {
            return response()->json($user,202);
        }
        // Return user data
        return response()->json($user,201);
    }
    public function show($id){
        // Find the user by ID
        $user= User::findOrFail($id);

       // check it user with id is writer
        if($user->role == 'writer') {
            return response()->json(['message' => 'Access denied for writers'], 403);
        } 
        return response()->json($user,201);
    }
}
