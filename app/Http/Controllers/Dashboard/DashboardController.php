<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageSubscription;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Models\MainCategory;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        // $data = null;

        // if ($user->hasAnyRole(['admin', 'super-admin'])) {
        //     $data = $this->getAdminDashboard();
        // } else if($user->hasAnyRole(['provider_moderator'])) {
        //     $data = $this->getServiceProviderDashboard();
        // }
        // $users_count = User::whereDoesntHave('roles')->count();
        // $male_count = User::whereDoesntHave('roles')->where('sex', 'm')->count();
        // $female_count = User::whereDoesntHave('roles')->where('sex', 'f')->count();
        // $banned_count = User::whereDoesntHave('roles')->where('status', 'inactive')->count();
        // $main_categories_count = MainCategory::count();
        // $sub_categories_count = Category::count();
        // $pending_categories = Category::inactive()->count();
        // $providers_count = ServiceProvider::count();
        // $pending_providers_count = ServiceProvider::inactive()->count();
        // $orders_today = Order::whereDay('created_at', '=', today())->count();
        // $orders_this_month = Order::whereMonth('created_at', '=', Carbon::now()->month)->count();
        // $orders_this_year = Order::whereYear('created_at', '=', Carbon::now()->year)->count();
        // $orders_total_sales = Order::where('status','success')->sum('sum');
        // $orders_total_sales_today = Order::where('status','success')->whereDay('created_at',today())->sum('sum');
        // $orders_total_sales_this_month = Order::where('status','success')->whereMonth('created_at',Carbon::now()->month)->sum('sum');
        // $failed_orders = Order::selectRaw('COUNT(*) , STATUS ')->groupBy('STATUS')->get();
        // $today_profit = Order::where('status','success')->whereDay('created_at',today())->sum('profit');
        // $this_month_profit = Order::where('status','success')->whereMonth('created_at',Carbon::now()->month)->sum('profit');
        // $overall_profit = Order::where('status','success')->sum('profit');
        // $year = now()->year;

        // $successOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //     ->whereYear('created_at', $year)
        //     ->where('status', 'success')
        //     ->groupBy(DB::raw('MONTH(created_at)'))
        //     ->pluck('count', 'month')
        //     ->toArray();

        // $otherOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //     ->whereYear('created_at', $year)
        //     ->where('status', '!=', 'success')
        //     ->groupBy(DB::raw('MONTH(created_at)'))
        //     ->pluck('count', 'month')
        //     ->toArray();

        // // Fill missing months with 0
        // $successOrderCount = [];
        // $othersOrdersCount = [];
        // for ($i = 1; $i <= 12; $i++) {
        //     $successOrderCount[] = $successOrders[$i] ?? 0;
        //     $othersOrdersCount[] = $otherOrders[$i] ?? 0;
        // }

        return view('admin.dashboard');
//        return view('admin.dashboard',
        //  compact(
        //     'users_count',
        //     'male_count',
        //     'female_count',
        //     'banned_count',
        //     'main_categories_count',
        //     'sub_categories_count',
        //     'pending_categories',
        //     'providers_count',
        //     'pending_providers_count',
        //     'orders_today',
        //     'orders_this_month',
        //     'orders_this_year',
        //     'successOrderCount',
        //     'othersOrdersCount',
        //     'overall_profit',
        //     'this_month_profit',
        //     'today_profit',
        //     'orders_total_sales_this_month',
        //     'orders_total_sales_today',
        //     'orders_total_sales',
        //     'failed_orders',
        // )
//    );
    }

    // public function getAdminDashboard()
    // {
    //     $data = [];

    //     $data['users'] = User::withoutRole('super-admin')->get()->count();
    //     $data['cashiers'] = User::role('cashier')->get()->count();
    //     $data['service_providers'] = ServiceProvider::all()->count();
    //     $data['packages'] = Package::active()->get()->count();
    //     $data['categories'] = Category::all()->count();

    //     $data['active_subscriptions'] = DB::table('package_service_provider')
    //         ->where('status', 'subscribed')
    //         ->where('end_subscription_date', '>=', now())
    //         ->count();

    //     $data['latest_subscriptions'] = PackageSubscription::with([
    //         'serviceProvider:id,name',
    //         'package:id,name'
    //     ])
    //         ->orderBy('start_subscription_date', 'desc')
    //         ->limit(5)
    //         ->get()
    //         ->map(function ($subscription) {
    //             return [
    //                 'provider_name' => $subscription->serviceProvider?->getTranslation('name', app()->getLocale()),
    //                 'package_name' => $subscription->package?->getTranslation('name', app()->getLocale()),
    //                 'start_subscription_date' => Carbon::parse($subscription->start_subscription_date)->format('Y-m-d'),
    //                 'end_subscription_date' => Carbon::parse($subscription->end_subscription_date)->format('Y-m-d'),
    //                 'status' => $subscription->status,
    //             ];
    //         });


    //     $data['subscription_status_chart'] = [
    //         'labels' => ['Subscribed', 'Expired', 'Cancelled'],
    //         'values' => [
    //             PackageSubscription::where('status', 'subscribed')->count(),
    //             PackageSubscription::where('status', 'expired')->count(),
    //             PackageSubscription::where('status', 'cancelled')->count(),
    //         ],
    //     ];

    //     $data['monthly_subscriptions_chart'] = [
    //         'labels' => collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('M Y'))->toArray(),
    //         'values' => collect(range(5, 0))->map(fn($i) =>
    //         PackageSubscription::whereMonth('start_subscription_date', now()->subMonths($i)->month)
    //             ->whereYear('start_subscription_date', now()->subMonths($i)->year)
    //             ->count()
    //         )->toArray(),
    //     ];

    //     $data['top_packages_chart'] = PackageSubscription::select('package_id', DB::raw('count(*) as total'))
    //         ->where('status', 'subscribed')
    //         ->groupBy('package_id')
    //         ->with('package:id,name')
    //         ->orderByDesc('total')
    //         ->limit(5)
    //         ->get()
    //         ->map(fn($item) => [
    //             'name' => $item->package?->getTranslation('name', app()->getLocale()),
    //             'count' => $item->total,
    //         ]);

    //     return $data;
    // }


    // public function getServiceProviderDashboard()
    // {
    //     $data = [];

    //     $data['provider'] = ServiceProvider::findOrFail(Auth::user()->service_provider_id);

    //     $data['subscriptions'] = PackageSubscription::with('package')
    //         ->where('service_provider_id', Auth::user()->service_provider_id)
    //         ->latest()
    //         ->limit(10)
    //         ->get()
    //         ->map(function ($subscription) {
    //             return [
    //                 'package_name' => $subscription->package?->getTranslation('name', app()->getLocale()),
    //                 'start_subscription_date' => Carbon::parse($subscription->start_subscription_date)->format('Y-m-d'),
    //                 'end_subscription_date' => Carbon::parse($subscription->end_subscription_date)->format('Y-m-d'),
    //                 'status' => ucfirst($subscription->status),
    //                 'is_active' => $subscription->status === 'subscribed'
    //                     && Carbon::parse($subscription->end_subscription_date)->isFuture(),
    //                 'days_left' => Carbon::now()->diffInDays(Carbon::parse($subscription->end_subscription_date), false),
    //             ];
    //         });


    //     $data['latest_orders'] = collect([
    //         [
    //             'order_number' => 'ORD-20251001',
    //             'package_name' => 'Premium Plan',
    //             'total_amount' => 199.99,
    //             'payment_status' => 'Paid',
    //             'order_date' => '2025-10-01',
    //         ],
    //         [
    //             'order_number' => 'ORD-20250921',
    //             'package_name' => 'Basic Plan',
    //             'total_amount' => 99.50,
    //             'payment_status' => 'Pending',
    //             'order_date' => '2025-09-21',
    //         ],
    //         [
    //             'order_number' => 'ORD-20250910',
    //             'package_name' => 'Trial Package',
    //             'total_amount' => 0.00,
    //             'payment_status' => 'Free',
    //             'order_date' => '2025-09-10',
    //         ],
    //     ]);



    //     return $data;
    // }

    // public function getCashierDashboard()
    // {

    // }

    // public function getUserDashboard()
    // {

    // }
}
