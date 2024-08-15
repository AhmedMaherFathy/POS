<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\TranslationHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\Http\Requests\AuthRequest;

use function Pest\Laravel\get;

class AuthController extends Controller
{

    public function register(AuthRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'otp_code' => rand(1000,9999),
            'otp_expired_at' => Carbon::now()->addMinutes(5),
        ]);

        $request->session()->put('code', $user->otp_code);
        $request->session()->put('expired_at', $user->otp_expired_at);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|numeric|digits:4',
        ]);

        if($validated['code'] == $request->session()->get('code') && !Carbon::now()->isAfter($request->session()->get('expired_at')))
        {
            $user = User::where('otp_code', $validated['code'] )->first();
            if($user)
            {
                // info($user); die;
                $user->update([  
                    'email_verified_at' => Carbon::now()
                ]);
                $user->save();
            }

            return response()->json(['message' => 'User verified successfully'], 200);
        }
        return response()->json(['message' => 'Invalid code or Expired'], 422);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials', 'status'=> Response::HTTP_UNAUTHORIZED],Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        if($user->email_verified_at == null)
        {
            return response()->json(['messgae'=> 'This account Not Verified',
                                    'status' => 200], 200);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['messgae'=> 'Logged in successfully',
                                    'access_token' => $token,
                                    'status' => Response::HTTP_ACCEPTED], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
