<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $provider = Auth::user()?->serviceProvider;

        if (!$provider) {
            abort(403, __('No service provider account.'));
        }

        $status = $provider->subscription_status;

        if (in_array($status, ['trial_expired', 'expired'])) {
            abort(403, __('Your subscription expired or trial ended'));
        }

        return $next($request);
    }
}
