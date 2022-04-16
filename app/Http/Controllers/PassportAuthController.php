<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    /**
     * @param Request $request
     * handle user registration request
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $email = $request->request->get('email');
        $name = $request->request->get('name');
        $password = $request->request->get('password');

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'=> 'required|min:8',
        ]);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $token = $user->createToken($email)->accessToken;
        return response()->json(['token' => $token],200);
    }

    /**
     * @param Request $request
     * login user to our application
     */
    public function login(Request $request): JsonResponse
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        // Generar token
        if (true === Auth::attempt($credentials)) {
            $token = $request->user()->createToken($email)->accessToken;
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * this method returns authenticated user details
     */
    public function authenticatedUser(Request $request): JsonResponse
    {
        return response()->json(Auth::user(), 200);
    }
}
