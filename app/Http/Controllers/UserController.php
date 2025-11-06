<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return $user;
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        // validasi output
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        //hash password 
        $validatedData['password'] = bcrypt($validatedData['password']);

        // buat user baru
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        // validasi input
       $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:5',
        ]);

        //hash password jika ada pass baru
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        // update user
        $user->update($validatedData);

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        
        $user->delete();
        return response()->json(null, 204);
    }
}
