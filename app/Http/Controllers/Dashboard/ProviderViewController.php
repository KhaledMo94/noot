<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ModeratorOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderBranch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProviderViewController extends Controller
{
    public function latestOrders()
    {
        $user = Auth::user();

        if (! $user->service_provider_moderator_id) {
            return redirect()->back()
                ->with('error', __('Must Be Assigned To Service Provider As Moderator'));
        }

        if (!$user->hasRole('provider_moderator')) {
            return redirect()->back()
                ->with('error', __('Must Be A Provider Moderator'));
        }

        $orders = Order::with(['cashier', 'serviceProviderBranch'])
            ->where('service_provider_id', $user->service_provider_moderator_id)
            ->get();

        return view('provider.orders', compact('orders'));
    }

    public function exportOrders()
    {
        $user = Auth::user();

        if (! $user->service_provider_moderator_id) {
            return redirect()->back()
                ->with('error', __('Must Be Assigned To Service Provider As Moderator'));
        }

        if (!$user->hasRole('provider-moderator')) {
            return redirect()->back()
                ->with('error', __('Must Be A Provider Moderator'));
        }

        return view('provider.export-orders');
    }

    public function download(Request $request)
    {
        $request->validate([
            'from'                              => 'required|date',
            'to'                                => 'required|date|after_or_equal:from',
            'branch_ids'                        => 'nullable|array',
            'branch_ids.*'                      => 'required|exists:service_provider_branches,id',
        ]);

        $user = Auth::user();

        if (! $user->service_provider_moderator_id) {
            return redirect()->back()
                ->with('error', __('Must Be Assigned To Service Provider As Moderator'));
        }

        if (!$user->hasRole('provider-moderator')) {
            return redirect()->back()
                ->with('error', __('Must Be A Provider Moderator'));
        }

        $permitted_branches = ServiceProviderBranch::where('service_provider_id', $user->service_provider_moderator_id)
            ->pluck('id')->toArray();

        if ($request->filled('branch_ids')) {
            foreach ($request->branch_ids as $branch) {
                if (! in_array($branch, $permitted_branches)) {
                    return redirect()->back()
                        ->with('error', __('Not Permitted Branch'));
                }
            }
        }

        $orders = Order::with([
            'cashier',
            'serviceProviderBranch',
        ])->where('service_provider_id', $user->service_provider_moderator_id)
            ->whereBetween('created_at', [$request->from, $request->to]);

        $orders->when($request->filled('branch_ids'), function ($query) use ($request) {
            $query->whereHas('serviceProviderBranch', function ($query) use ($request) {
                $query->whereIn('id', $request->branch_ids);
            });
        });

        $orders = $orders->get();
        return Excel::download(new ModeratorOrdersExport($orders), 'service_provider_orders.xlsx');
    }

    public function providerDetails()
    {
        $user = Auth::user();

        if (! $user->service_provider_id) {
            return redirect()->back()
                ->with('error', __('Must Be Assigned To Service Provider As Moderator'));
        }

        if (!$user->hasRole('provider_moderator')) {
            return redirect()->back()
                ->with('error', __('Must Be A Provider Moderator'));
        }


        $provider = ServiceProvider::withCount(['users'])
            ->with(['category', 'activeSubscription'])
            ->where('id', $user->service_provider_id)
            ->first();

        return view('provider.profile', compact('provider'));
    }

    public function providerCashiers()
    {
        $user = Auth::user();

        if (! $user->service_provider_moderator_id) {
            return redirect()->back()
                ->with('error', __('Must Be Assigned To Service Provider As Moderator'));
        }

        if (!$user->hasRole('provider-moderator')) {
            return redirect()->back()
                ->with('error', __('Must Be A Provider Moderator'));
        }

        $permitted_branches = ServiceProviderBranch::where('service_provider_id', $user->service_provider_moderator_id)
            ->pluck('id')->toArray();
        $cashiers = User::with('serviceProviderBranch')->role('cashier')->whereIn('service_provider_branch_id', $permitted_branches)->get();

        return view('provider.cashiers', compact('cashiers'));
    }

    public function providerBranches()
    {
        $user = Auth::user();

        if (! $user->service_provider_moderator_id) {
            return redirect()->back()
                ->with('error', __('Must Be Assigned To Service Provider As Moderator'));
        }

        if (!$user->hasRole('provider-moderator')) {
            return redirect()->back()
                ->with('error', __('Must Be A Provider Moderator'));
        }

        $branches = ServiceProviderBranch::with('city')
        ->withCount('users')
        ->where('service_provider_id', $user->service_provider_moderator_id)
        ->get();

        return view('provider.branches',compact('branches'));
    }

    public function subscriptionsDetails()
    {
        $serviceProvider = Auth::user()->serviceProvider;

        $packages = Package::active()->get();

        $currentSubscription = $serviceProvider->CurrentSubscription;

        return view('provider.subscription_details', compact(
            'packages',
            'currentSubscription'
        ));
    }

    public function subscriptionHistory(ServiceProvider $provider)
    {
        $subscriptions = $provider->subscriptions()
            ->withPivot([
                'start_subscription_date',
                'end_subscription_date',
                'end_trail_date',
                'status',
                'created_at',
                'updated_at'
            ])
            ->orderBy('pivot_created_at', 'desc')
            ->paginate(10);

        return view('admin.providers.subscriptions-history', compact('provider', 'subscriptions'));
    }
}
