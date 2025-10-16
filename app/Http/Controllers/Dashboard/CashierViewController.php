<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\OrderCreated;
use App\Helpers\CalculationsHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderBranch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class CashierViewController extends Controller
{
    public function latestOrders()
    {
        $user = Auth::user();

        if (! $user->hasRole('cashier')) {
            return redirect()->back()
                ->with('error', __('Must Be A Cashier'));
        }

        $orders = Order::where('cashier_id', $user->id)
            ->latest()->get();

        return view('cashiers.orders', compact('orders'));
    }

    public function create()
    {
        return view('cashiers.create');
    }

    public function getClientPayableAmount(Request $request)
    {
        $request->validate([
            'card_no'           => 'required|exists:users,card_code',
            'sum'               => 'required|integer|min:0',
        ]);

        $user = Auth::user();

        if (! $user->hasRole('cashier')) {
            return redirect()->back()
                ->with('error', __('Must Be A Cashier'));
        }

        $branch = ServiceProviderBranch::findOrFail($user->service_provider_branch_id);
        $service_provider = ServiceProvider::findOrFail($branch->service_provider_id);
        $client = User::where('card_code', $request->card_no)->first();

        $payable_amount = CalculationsHelper::calculatePayableAmount($client->payments_total, $client->orders_count, $request->sum, $service_provider);

        return response()->json([
            'name'              => $client->name,
            'phone'             => $client->phone,
            'payable_amount'    => $payable_amount['totalAfterDiscount'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_no'           => 'required|exists:users,card_code',
            'sum'               => 'required|integer|min:0',
        ]);

        $user = Auth::user();

        if (! $user->hasRole('cashier')) {
            return redirect()->back()
                ->with('error', __('Must Be A Cashier'));
        }

        $branch = ServiceProviderBranch::findOrFail($user->service_provider_branch_id);
        $service_provider = ServiceProvider::findOrFail($branch->service_provider_id);
        $client = User::where('card_code', $request->card_no)->first();

        $calculations = CalculationsHelper::calculatePayableAmount($client->payments_total, $client->orders_count, $request->sum, $service_provider);

        Order::create([
            'user_id'                               => $client->id,
            'service_provider_id'                   => $service_provider->id,
            'service_provider_name'                 => [
                'en'                                    => $service_provider->getTranslation('name', 'en'),
                'ar'                                    => $service_provider->getTranslation('name', 'ar'),
            ],
            'status'                                => 'success',
            'sum'                                   => $request->sum,
            'applicable_discount'                   => $calculations['discountedAmount'],
            'applicable_discount_percentage'        => $calculations['total'] > 0
                ? round($calculations['discountedAmount'] / $calculations['total'] * 100, 2)
                : 0,
            'profit'                                => $calculations['a2zProfit'],
            'profit_percentage'                     => $calculations['a2zPercentage'],
            'cashier_id'                            => $user->id,
            'cashier_name'                          => $user->name,
            'service_provider_branch_id'            => $branch->id,
            'service_provider_branch_address'       => [
                'en'                                    => $branch->getTranslation('address', 'en'),
                'ar'                                    => $branch->getTranslation('address', 'ar'),
            ]
        ]);

        Event::dispatch(new OrderCreated($client, $calculations['totalAfterDiscount'], $service_provider));

        return redirect()->back()->with('success', 'Order Added');
    }
}
