<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\BookLike;


use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Else_;

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
        if(!$user|| $user->id != $id){ 
            return response()->json(['message' => 'User not found or unauthorized'], 404);
        }
        else{
            return response()->json([
                'message' => 'User found',
                'user' => $user
            ], 200);
        }
    }

     public function update(UserRequest $request,$id){
        $user = Auth::user();

        $user = User::findOrFail($id);
        // Check if the user is authenticated
        if(!$user|| $user->id != $id){
            return response()->json(['message' => 'User not found or unauthorized'], 404);
        }
        else{
            //si user no modifica el password
            if(empty($request->input('password'))) {
                $validated = $request->except('password');
                $user->update($validated);
                return response()->json(
                    ['message' => 'User updated successfully'], 
                    200);
            }
            //si user modifica el password
            else {
                $validated = $request->validated();
                $validated['password'] = Hash::make($request->input('password'));
                $user->update($validated);
                  return response()->json(
                    ['message' => 'User updated successfully'], 
                    200);
            }
        }

    }   
    
    public function destroy($id, Request $request){
         $user = Auth::user();

        $user = User::findOrFail($id);
        // Check if the user is authenticated

        if(!$user|| $user->id != $id){
            return response()->json(['message' => 'User not found or unauthorized'], 404);
        }else{
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ], 200);

        }
    }
    public function addBookLike(Request $request, $id)
    {
        $user = Auth::user();
        if(!$user || $user->role != 'reader') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        
        // Insertar directamente en la tabla pivot
        BookLike::create([
            'idbook' => $book->idbook,
            'iduser' => $user->id
        ]); 
        return response()->json(['message' => 'Book liked successfully'], 200);
    }

    public function removeBookLike($id, Request $request){
         $user = Auth::user();
        if(!$user || $user->role != 'reader') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        // Eliminar el like del libro
        $bookLike = BookLike::where('idbook', $book->idbook)
                        ->where('iduser', $user->id)
                        ->first();
        if (!$bookLike) {
                return response()->json(['message' => 'Book not found'], 404);
        }

        $bookLike->delete();
            return response()->json(
                ['message' => 'Book unliked successfully'], 
                200);
        
    }

    
    
    
}

