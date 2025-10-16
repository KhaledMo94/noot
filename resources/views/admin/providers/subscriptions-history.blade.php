<x-dashboard.main-layout>
    @php
        $locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">
                    <i class="fas fa-history text-primary me-2"></i>
                    {{ __('Subscription History') }}
                </h1>
                <p class="text-muted mb-0">
                    {{ __('Provider') }}: <strong>{{ $provider->getTranslation('name', app()->getLocale()) }}</strong>
                </p>
            </div>
            <div>
                <a href="{{ route('admins.providers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> {{ __('Back to Providers') }}
                </a>
            </div>
        </div>

        <!-- Subscription History Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list-alt me-2"></i>
                    {{ __('Subscription History Details') }}
                </h6>
{{--                <div class="dropdown">--}}
{{--                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                        <i class="fas fa-filter me-2"></i>{{ __('Filter') }}--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu" aria-labelledby="filterDropdown">--}}
{{--                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => '']) }}">{{ __('All') }}</a>--}}
{{--                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">{{ __('Active') }}</a>--}}
{{--                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'expired']) }}">{{ __('Expired') }}</a>--}}
{{--                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}">{{ __('Cancelled') }}</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="card-body">
                @if($subscriptions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="subscriptionTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">{{ __('Package Name') }}</th>
                                <th width="10%">{{ __('Price') }}</th>
                                <th width="10%">{{ __('Duration') }}</th>
                                <th width="12%">{{ __('Start Date') }}</th>
                                <th width="12%">{{ __('End Date') }}</th>
                                <th width="12%">{{ __('Trial End') }}</th>
                                <th width="10%">{{ __('Status') }}</th>
                                <th width="9%">{{ __('Days Left') }}</th>
                                <th width="10%">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscriptions as $index => $subscription)
                                @php

                                    $pivot = $subscription->pivot;
                                    $startDate = Carbon\Carbon::parse($pivot->start_subscription_date);
                                    $endDate = Carbon\Carbon::parse($pivot->end_subscription_date);
                                    $trialEndDate = Carbon\Carbon::parse($pivot->end_trail_date);
                                    $daysLeft = floor(Carbon\Carbon::parse($pivot->end_subscription_date)->diffInDays(now(), true));

                                    $statusClass = [
                                        'active' => 'success',
                                        'expired' => 'danger',
                                        'cancelled' => 'secondary',
                                        'pending' => 'warning'
                                    ][$pivot->status] ?? 'secondary';
                                @endphp
                                <tr class="subscription-row">
                                    <td class="text-center">
                                        <span class="subscription-number">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <div class="subscription-icon me-2">
                                                <i class="fas fa-{{ $subscription->price ? 'crown' : 'gem' }} text-{{ $subscription->price ? 'warning' : 'info' }} mt-1"></i>
                                            </div>
                                            <div class="package-info">
                                                <div class="package-name font-weight-bold text-dark">
                                                    {{ $subscription->getTranslation('name', app()->getLocale()) }}
                                                </div>
                                                @if($subscription->getTranslation('name', $locale))
                                                    <div class="package-name-arabic small text-muted mt-1">
                                                        {{ $subscription->getTranslation('name', $locale) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($subscription->price)
                                            <span class="price-amount font-weight-bold text-success">${{ number_format($subscription->price, 2) }}</span>
                                        @else
                                            <span class="badge badge-free">{{ __('FREE') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="duration-badge">{{ $subscription->duration_days }} {{ __('days') }}</span>
                                    </td>
                                    <td>
                                        <div class="date-container">
                                            <div class="date-main">{{ $startDate->format('M d, Y') }}</div>
                                            <div class="date-time small text-muted">{{ $startDate->format('h:i A') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-container">
                                            <div class="date-main">{{ $endDate->format('M d, Y') }}</div>
                                            <div class="date-time small text-muted">{{ $endDate->format('h:i A') }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($trialEndDate->isFuture())
                                            <span class="trial-date text-warning font-weight-bold">{{ $trialEndDate->format('M d, Y') }}</span>
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge badge badge-{{ $statusClass }}">
                                            @if($pivot->status === 'active')
                                                <i class="fas fa-check-circle me-1"></i>
                                            @elseif($pivot->status === 'expired')
                                                <i class="fas fa-times-circle me-1"></i>
                                            @elseif($pivot->status === 'cancelled')
                                                <i class="fas fa-ban me-1"></i>
                                            @endif
                                            {{ __(ucfirst($pivot->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($pivot->status === 'subscribed')
                                            @if($daysLeft > 0)
                                                <span class="days-left text-success font-weight-bold">{{ $daysLeft }}</span>
                                                <div class="days-label small text-muted">{{ __('days') }}</div>
                                            @elseif($daysLeft === 0)
                                                <span class="days-left text-warning font-weight-bold">{{ __('Today') }}</span>
                                            @else
                                                <span class="days-left text-danger font-weight-bold">{{ abs($daysLeft) }}</span>
                                                <div class="days-label small text-muted">{{ __('days ago') }}</div>
                                            @endif
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons d-flex justify-content-center">
                                            <a class="btn btn-view btn-sm" href="{{ route('admins.packages.show', $subscription->id) }}" data-toggle="tooltip" title="{{ __('View Package') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($subscriptions->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                {{ __('Showing') }} {{ $subscriptions->firstItem() }} - {{ $subscriptions->lastItem() }} {{ __('of') }} {{ $subscriptions->total() }} {{ __('results') }}
                            </div>
                            <div>
                                {{ $subscriptions->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">{{ __('No Subscription History') }}</h4>
                            <p class="text-muted mb-4">{{ __('This provider has no subscription history yet.') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .subscription-icon {
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .package-info {
            min-width: 0;
            flex: 1;
        }

        .package-name {
            font-size: 0.9rem;
            line-height: 1.2;
            word-wrap: break-word;
        }

        .package-name-arabic {
            font-size: 0.8rem;
            line-height: 1.2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .subscription-number {
            display: inline-block;
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 50%;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .price-amount {
            font-size: 0.9rem;
        }

        .badge-free {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
            font-size: 0.75rem;
            padding: 0.35rem 0.6rem;
        }

        .duration-badge {
            background: #f8f9fa;
            color: #6c757d;
            padding: 0.3rem 0.6rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid #e9ecef;
        }

        .date-container {
            text-align: center;
        }

        .date-main {
            font-size: 0.85rem;
            font-weight: 500;
            color: #495057;
        }

        .date-time {
            font-size: 0.75rem;
        }

        .trial-date {
            font-size: 0.85rem;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            min-width: 80px;
            display: inline-block;
        }

        .days-left {
            font-size: 1rem;
            display: block;
        }

        .days-label {
            font-size: 0.7rem;
            margin-top: -2px;
        }

        .action-buttons .btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-view {
            background: #e7f3ff;
            color: #0066cc;
            border: 1px solid #b3d9ff;
        }

        .btn-view:hover {
            background: #0066cc;
            color: white;
            transform: translateY(-1px);
        }

        .btn-renew {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .btn-renew:hover {
            background: #856404;
            color: white;
            transform: translateY(-1px);
        }

        .subscription-row:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .table-hover tbody tr:hover {
            background-color: transparent;
        }

        #subscriptionTable {
            border-collapse: separate;
            border-spacing: 0;
        }

        #subscriptionTable th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #f8f9fa;
            padding: 12px 8px;
            border-bottom: 2px solid #e9ecef;
        }

        #subscriptionTable td {
            padding: 12px 8px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .empty-state {
            opacity: 0.7;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .table-responsive {
                border: 1px solid #e3e6f0;
                border-radius: 0.35rem;
            }

            .package-name {
                font-size: 0.85rem;
            }

            .package-name-arabic {
                font-size: 0.75rem;
            }

            .date-main {
                font-size: 0.8rem;
            }

            .date-time {
                font-size: 0.7rem;
            }
        }
    </style>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.subscription-row');
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

</x-dashboard.main-layout>
