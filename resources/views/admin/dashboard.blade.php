<x-dashboard.main-layout>

    @php
        $local = app()->getLocale();
    @endphp
    <div class="row">
        <div class="mb-2 col-xl-12 col-md-12">
            <h1 class="mb-3 text-gray-800 h3">{{ __('Dashboard') }}</h1>
        </div>
    </div>

    <!-- Box Start -->
    @hasrole('super-admin|admin')
        <div class="row dashboard-page" data-aos="fade-up">
            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 h4 font-weight-bold text-success">{{ __('Users') }}</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['users'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 h4 font-weight-bold text-success">{{ __('Cashiers') }}</div>
                                {{--                            <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['cashiers'] }}</div>--}}
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-tags fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 h4 font-weight-bold text-success">{{ __('Service Providers') }}</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['service_providers'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 h4 font-weight-bold text-success">{{ __('Packages') }}</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['packages'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 h4 font-weight-bold text-success">{{ __('Categories') }}</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['categories'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 col-xl-3 col-md-6">
                <div class="py-2 shadow card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="mr-2 col">
                                <div class="mb-1 h4 font-weight-bold text-success">{{ __('Active Subscriptions') }}</div>
                                <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['active_subscriptions'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="text-gray-300 fas fa-tags fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card w-100 mx-4 shadow">
                <div class="card-header bg-success text-white">
                    <h5>{{ __('Latest Subscriptions') }}</h5>
                </div>
                <div class="card-body">
                    @if(!$data['latest_subscriptions'])
                        <p class="text-muted text-center">{{ __('No subscriptions found.') }}</p>
                    @else
                        <table class="table table-sm table-striped">
                            <thead>
                            <tr>
                                <th>{{ __('Service Provider') }}</th>
                                <th>{{ __('Package') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['latest_subscriptions'] as $subscription)
                                <tr>
                                    <td>{{ $subscription['provider_name'] }}</td>
                                    <td>{{ $subscription['package_name'] }}</td>
                                    <td>{{ $subscription['start_subscription_date'] }}</td>
                                    <td>{{ $subscription['end_subscription_date'] }}</td>
                                    <td>{{ $subscription['status'] }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>


        <hr>
        <div class="row">
            <div class="mb-2 col-xl-12 col-md-12">
                <h1 class="mb-3 text-gray-800 h3">{{ __('Statistiecs') }}</h1>
            </div>
        </div>
        <div class="row my-4">

            <!-- Monthly Subscriptions Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">{{ __('Monthly Subscriptions (Last 6 Months)') }}</div>
                    <div class="card-body">
                        <canvas id="monthlySubscriptionsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Packages Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">{{ __('Top Packages by Active Subscriptions') }}</div>
                    <div class="card-body">
                        <canvas id="topPackagesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Status Chart -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">{{ __('Subscription Status Overview') }}</div>
                <div class="card-body">
                    <canvas id="subscriptionStatusChart"></canvas>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('provider_moderator')
        <div class="row dashboard-page" data-aos="fade-up">
            <div class="mb-4 col-xl-3 col-md-6">
                    <div class="py-2 shadow card border-left-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="mr-2 col">
                                    <div class="mb-1 h4 font-weight-bold text-success">{{ __('Service Provider') }}</div>
                                    <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['provider']['name'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="mb-4 col-xl-3 col-md-6">
                    <div class="py-2 shadow card border-left-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="mr-2 col">
                                    <div class="mb-1 h4 font-weight-bold text-success">{{ __('Category') }}</div>
                                    <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['provider']['category']['name'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="mb-4 col-xl-3 col-md-6">
                    <div class="py-2 shadow card border-left-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="mr-2 col">
                                    <div class="mb-1 h4 font-weight-bold text-success">{{ __('Casheiers') }}</div>
        {{--                            <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['provider']['name'] }}</div>--}}
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="mb-4 col-xl-3 col-md-6">
                    <div class="py-2 shadow card border-left-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="mr-2 col">
                                    <div class="mb-1 h4 font-weight-bold text-success">{{ __('Users') }}</div>
                                    {{--                            <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $data['provider']['name'] }}</div>--}}
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300 fas fa-user-friends fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
        <div class="mt-4 col-12">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">{{ __('My Subscriptions') }}</h5>
            </div>
            <div class="card-body w-100 p-0">
                <table class="table table-striped mb-0 text-center shadow">
                    <thead>
                    <tr>
                        <th>{{ __('Package') }}</th>
                        <th>{{ __('Start Date') }}</th>
                        <th>{{ __('End Date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Days Left') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data['subscriptions'] as $sub)
                        <tr>
                            <td>{{ $sub['package_name'] }}</td>
                            <td>{{ $sub['start_subscription_date'] }}</td>
                            <td>{{ $sub['end_subscription_date'] }}</td>
                            <td class="text-white">
                                    <span class="badge
                                        {{ $sub['is_active'] ? 'bg-success' : 'bg-danger' }}">
                                        {{ $sub['status'] }}
                                    </span>
                            </td>
                            <td>
                                @if($sub['days_left'] > 0)
                                    <span class="text-success">{{ floor($sub['days_left']) }}</span>
                                @elseif($sub['days_left'] == 0)
                                    <span class="text-warning">{{ __('Today') }}</span>
                                @else
                                    <span class="text-danger">{{ floor(abs($sub['days_left'])) }} {{ __('days ago') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">{{ __('No subscriptions found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <hr>
        <div class="row">
            <div class="mt-4 col-12">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ __('Latest Orders') }}</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0 text-center shadow">
                        <thead>
                        <tr>
                            <th>{{ __('Order Number') }}</th>
                            <th>{{ __('Package') }}</th>
                            <th>{{ __('Total Amount') }}</th>
                            <th>{{ __('Payment Status') }}</th>
                            <th>{{ __('Order Date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data['latest_orders'] as $order)
                            <tr>
                                <td>{{ $order['order_number'] }}</td>
                                <td>{{ $order['package_name'] }}</td>
                                <td>${{ number_format($order['total_amount'], 2) }}</td>
                                <td class="text-white">
                                    @if($order['payment_status'] === 'Paid')
                                        <span class="badge bg-success">{{ __('Paid') }}</span>
                                    @elseif($order['payment_status'] === 'Pending')
                                        <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('Free') }}</span>
                                    @endif
                                </td>
                                <td>{{ $order['order_date'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('No orders found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('admin|super-admin')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>

            document.addEventListener('DOMContentLoaded', function () {
                // === Subscription Status Chart ===
                new Chart(document.getElementById('subscriptionStatusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($data['subscription_status_chart']['labels']),
                        datasets: [{
                            data: @json($data['subscription_status_chart']['values']),
                            backgroundColor: ['#28a745', '#dc3545', '#6c757d'],
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });

                // -------------- Monthly Subscriptions Chart ---------
                new Chart(document.getElementById('monthlySubscriptionsChart'), {
                    type: 'line',
                    data: {
                        labels: @json($data['monthly_subscriptions_chart']['labels']),
                        datasets: [{
                            label: '{{ __("New Subscriptions") }}',
                            data: @json($data['monthly_subscriptions_chart']['values']),
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.3)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        scales: { y: { beginAtZero: true } },
                        plugins: { legend: { display: false } }
                    }
                });

                // ---------- Top Packages Chart ---------
                new Chart(document.getElementById('topPackagesChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($data['top_packages_chart']->pluck('name')),
                        datasets: [{
                            label: '{{ __("Active Subscriptions") }}',
                            data: @json($data['top_packages_chart']->pluck('count')),
                            backgroundColor: '#28a644'
                        }]
                    },
                    options: {
                        scales: { y: { beginAtZero: true } },
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        }
                    }
                });
            });
        </script>
    @endhasrole
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-dashboard.main-layout>
