<?php

namespace Modules\Auth\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\TranslationHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function Pest\Laravel\get;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Modules\Auth\Http\Requests\AuthRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use HttpResponse;

    public function register(AuthRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Auth::login($user);
        event(new Registered($user));

        return $this->successResponse(
            message : 'Registered successfully , please verify your email address.'
        );
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return $this->errorResponse('Email or Password are incorrect please try again');
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Please verify your email before logging in.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function verify(Request $request, $id, $hash)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if the user is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        // Validate the hash
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link.'], 400);
        }

        // Mark the email as verified
        $user->markEmailAsVerified();

        // Fire the Verified event
        event(new Verified($user));

        return view('auth::verify');
    }
    // public function register(AuthRequest $request)
    // {
    //     $validated = $request->validated();

    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']),
    //         'otp_code' => rand(1000,9999),
    //         'otp_expired_at' => Carbon::now()->addMinutes(5),
    //     ]);

    //     $request->session()->put('code', $user->otp_code);
    //     $request->session()->put('expired_at', $user->otp_expired_at);

    //     return response()->json(['message' => 'User registered successfully'], 201);
    // }

    // public function verify(Request $request)
    // {
    //     $validated = $request->validate([
    //         'code' => 'required|numeric|digits:4',
    //     ]);

    //     if($validated['code'] == $request->session()->get('code') && !Carbon::now()->isAfter($request->session()->get('expired_at')))
    //     {
    //         $user = User::where('otp_code', $validated['code'] )->first();
    //         if($user)
    //         {
    //             // info($user); die;
    //             $user->update([  
    //                 'email_verified_at' => Carbon::now()
    //             ]);
    //             $user->save();
    //         }

    //         return response()->json(['message' => 'User verified successfully'], 200);
    //     }
    //     return response()->json(['message' => 'Invalid code or Expired'], 422);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Invalid credentials', 'status'=> Response::HTTP_UNAUTHORIZED],Response::HTTP_UNAUTHORIZED);
    //     }

    //     $user = Auth::user();
    //     if($user->email_verified_at == null)
    //     {
    //         return response()->json(['messgae'=> 'This account Not Verified',
    //                                 'status' => 200], 200);
    //     }
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json(['messgae'=> 'Logged in successfully',
    //                                 'access_token' => $token,
    //                                 'status' => Response::HTTP_ACCEPTED], 200);
    // }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // public function register(AuthRequest $request)
    // {
    //     $validated = $request->validated();

    //     // $startTime = microtime(true);
    //     User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']),
    //     ]);
    //     // $endTime = microtime(true);
    //     // $executionTimeDBInsert = $endTime - $startTime;
    //     // info($executionTimeDBInsert); die;
    //     return response()->json([
    //         'data' => '',
    //         'message' => 'User registered successfully',
    //         'status' => Response::HTTP_CREATED
    //     ], Response::HTTP_CREATED);
    // }
    public function test()
    {
        // $productIds = Product::get()->pluck('id');
        // $productIds = Product::pluck('id');
        // dd(gettype($productIds->toArray())); die;
        dd(Product::all());
        // return response()->json($productIds);
    }
}
