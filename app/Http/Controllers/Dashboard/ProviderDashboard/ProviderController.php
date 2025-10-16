<?php

namespace App\Http\Controllers\Dashboard\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{

    public function subscribe(Request $request, Package $package)
    {
        $provider = Auth::user()->serviceProvider;

        // TODO: create validation if he already has active subscription

        try {
            $now = Carbon::now();
            $trialDays = $package->trial_days ?? 0;
            $durationDays = $package->duration_days ?? 0;

            $provider->subscriptions()->attach($package->id, [
                'start_subscription_date'   => $now,
                'end_subscription_date'     => $now->copy()->addDays($trialDays + $durationDays),
                'end_trail_date'            => $now->copy()->addDays($trialDays),
                'created_at'                => $now,
                'updated_at'                => $now,
            ]);

            return back()->with('success', __('You have successfully subscribed'));
        } catch (\Exception) {
            return redirect()->back();
        }
    }

    public function unsubscribe()
    {
        try {
            $provider = Auth::user()->serviceProvider;

            $currentSubscription = $provider->CurrentSubscription;

            if (!$currentSubscription) {
                return back()->with('error', __('You have no active subscription'));
            }

            $provider->subscriptions()
                ->updateExistingPivot($currentSubscription->id, [
                    'status' => 'cancelled',
                    'end_subscription_date' => now(),
                ]);

            return back()->with('success', __('You have successfully unsubscribed'));

        } catch (\Exception $e) {
            return redirect()->back('error', $e->getMessage());
        }
    }
}
