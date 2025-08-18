<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $minTier = 'FREE'): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $subscription = $user->activeSubscription();
        
        if (!$subscription || !$subscription->meetsTier($minTier)) {
            return response()->json([
                'message' => 'Upgrade required',
                'teaser' => true,
                'required_tier' => $minTier,
                'current_tier' => $user->getCurrentTier(),
                'upgrade_suggestion' => true
            ], 403);
        }

        return $next($request);
    }
}
