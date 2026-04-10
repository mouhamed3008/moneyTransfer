<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => UserResource::collection($users)
        ]);
    }


    public function createUser(UserRequest $request)
    {

        // $breukh = $request->validate([
        //     'name' => 'required|string|max:255|min:3',
        //     'email' => "required|email|unique:users,email",
        //     'password' => 'required|string|min:6',
        // ]);

        // $breukh = $request->validated();

        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'data' => UserResource::make($user)
        ]);
    }
}
