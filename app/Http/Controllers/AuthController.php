<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();


        //hasher le mot de passe et le comparer avec celui stocké dans la base de données
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }



        // if (auth()->attempt($credentials)) {
        //     $user = auth()->user();
        //     $token = $user->createToken('auth_token')->plainTextToken;

        //     return response()->json([
        //         'message' => 'Login successful',
        //         'access_token' => $token,
        //         'token_type' => 'Bearer',
        //     ]);
        // }

        // return response()->json(['message' => 'Invalid credentials'], 401);


    }

    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => "required|email|unique:users,email",
            'password' => 'required|string|min:6',
            'code' => 'required|string|min:4|max:4',
        ]);
        unset($validatedData['code']); //supprimer le code du tableau de données validées pour éviter de le stocker dans la base de données

        $user = User::create($validatedData);

        //  $account = $user->account()->create([
        //      'numero_compte' => 'ACC' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
        //      'solde' => 0,
        //      'code' => $request->input('code'),

        //  ]);

        $account = Account::create([
            'numero_compte' => 'OM_' . date('Ymd') . '_' . $user->id,
            'solde' => 1000,
            'code' => $request->input('code'),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'account' => $account,
            ]
        ]);
    }
}
