<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:160',
            'email' => 'required|string|email|max:190|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'country' => 'nullable|string|max:120',
            'org' => 'nullable|string|max:190',
            'profession' => 'nullable|string|max:120',
            'plan_code' => 'nullable|string|exists:plans,code'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'org' => $request->org,
            'profession' => $request->profession,
            'role' => 'member'
        ]);

        // Create free subscription by default
        $freePlan = Plan::where('code', 'FREE_MONTHLY')->first();
        if ($freePlan) {
            $user->subscription()->create([
                'plan_id' => $freePlan->id,
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addYear(10), // Free plan never expires
            ]);
        }

        // Log registration
        AuditLog::create([
            'actor_id' => $user->id,
            'action' => 'user_registered',
            'entity_type' => 'User',
            'entity_id' => $user->id,
            'meta' => ['email' => $user->email],
            'created_at' => now()
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'Registration successful. Please check your email to verify your account.',
            'user' => $user->only(['id', 'name', 'email'])
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'message' => 'Please verify your email address before logging in.'
            ], 403);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        // Log login
        AuditLog::create([
            'actor_id' => $user->id,
            'action' => 'user_login',
            'entity_type' => 'User',
            'entity_id' => $user->id,
            'meta' => ['ip' => $request->ip()],
            'created_at' => now()
        ]);

        return response()->json([
            'token' => $token,
            'user' => $user->load('subscription.plan')
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load(['subscription.plan', 'eventRsvps.event']);
        
        return response()->json([
            'user' => $user,
            'current_tier' => $user->getCurrentTier()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:160',
            'org' => 'sometimes|nullable|string|max:190',
            'country' => 'sometimes|nullable|string|max:120',
            'profession' => 'sometimes|nullable|string|max:120',
            'bio' => 'sometimes|nullable|string',
            'avatar_url' => 'sometimes|nullable|url',
            'privacy_opt_out' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only([
            'name', 'org', 'country', 'profession', 'bio', 'avatar_url', 'privacy_opt_out'
        ]));

        // Log profile update
        AuditLog::create([
            'actor_id' => $user->id,
            'action' => 'profile_updated',
            'entity_type' => 'User',
            'entity_id' => $user->id,
            'meta' => $request->only(['name', 'org', 'country', 'profession']),
            'created_at' => now()
        ]);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->fresh()
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::sendResetLink($request->only('email'));

        return response()->json([
            'message' => $status === Password::RESET_LINK_SENT 
                ? 'Password reset link sent to your email'
                : 'Unable to send reset link'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Log password reset
                AuditLog::create([
                    'actor_id' => $user->id,
                    'action' => 'password_reset',
                    'entity_type' => 'User',
                    'entity_id' => $user->id,
                    'created_at' => now()
                ]);
            }
        );

        return response()->json([
            'message' => $status === Password::PASSWORD_RESET 
                ? 'Password reset successfully'
                : 'Unable to reset password'
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // This is a simplified email verification
        // In production, you'd want to use Laravel's built-in email verification
        $user = User::where('remember_token', $request->token)
                   ->whereNull('email_verified_at')
                   ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid or expired verification token'
            ], 400);
        }

        $user->update([
            'email_verified_at' => now(),
            'remember_token' => null
        ]);

        // Log email verification
        AuditLog::create([
            'actor_id' => $user->id,
            'action' => 'email_verified',
            'entity_type' => 'User',
            'entity_id' => $user->id,
            'created_at' => now()
        ]);

        return response()->json([
            'message' => 'Email verified successfully'
        ]);
    }
}
