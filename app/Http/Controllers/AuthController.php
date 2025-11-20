<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, 
        $user->password)) {
            return [
                'message' => 'Provided credentials are incorrect'
            ];
        }

        if (Config::get('auth_otp.enabled')) {
            $otp = rand(100000, 999999);

            UserOtp::where('user_id', $user->id)->delete();

            UserOtp::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            return response()->json([
                'message' => 'OTP required',
                'otp'     => $otp, // Remove
                'user_id' => $user->id,
            ]);
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You are logged out'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'otp' => 'required',
        ]);

        $otpRecord = UserOtp::where('user_id', $request->user_id)
                            ->where('otp', $request->otp)
                            ->where('expires_at', '>', now())
                            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP'], 401);
        }

        $otpRecord->delete();

        $user = User::find($request->user_id);

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'message' => 'OTP verified successfully',
            'token'   => $token,
            'user'    => $user,
        ]);
    }
}
