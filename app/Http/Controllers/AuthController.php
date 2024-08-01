<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'status' => 401], 401);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        Log::info('Este es un mensaje informativo.');
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            return response()->json(auth()->user());
        }
    }

    /*    public function profile(Request $request)
        {
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            try {
                $user = JWTAuth::parseToken($token)->authenticate();
            } catch (JWTException $e) {
                return response()->json(['error' => 'invalid_token'], 401);
            }

            return response()->json($user);
        }*/

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out', 'status' => 200]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'status' => 200,
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'documentType_id' => 'required',
            'documentNumber' => 'required',
            'birthDate' => 'required|date',
            'telephoneNumber' => 'required',
            'city_id' => '',
            'address' => 'required',
            'role_id' => 'required',
            'occupation' => ''
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'status' => 201
        ], 201);
    }
}
