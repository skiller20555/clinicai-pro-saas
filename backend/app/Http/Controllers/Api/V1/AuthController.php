<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'clinic_name' => 'nullable|string|max:255',
        ]);

        $clinic = null;
        if (! empty($validated['clinic_name'])) {
            $clinic = Clinic::create([
                'name' => $validated['clinic_name'],
                'slug' => strtolower(str_replace(' ', '-', $validated['clinic_name'])),
                'status' => 'active',
                'owner_user_id' => null,
                'timezone' => 'UTC',
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'clinic_id' => $clinic?->id,
            'role' => $clinic ? 'clinic_owner' : 'assistant',
            'status' => 'active',
        ]);

        if ($clinic) {
            $clinic->update(['owner_user_id' => $user->id]);
        }

        $token = $user->createToken('clinicai')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $token,
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('clinicai')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
