<x-dashboard.main-layout>
    @php
        $locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp

    <h1 class="mb-3 text-gray-800 h3">{{ __('Provider') }} {{ $provider->name }} {{ __('Details') }}</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                    <div class="float-right d-inline">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>{{ __('Provider Name') }}</td>
                                <td>
                                    {{ $provider->getTranslation('name',app()->getLocale()) }} <br> {{ $provider->getTranslation('name', $locale) }}
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('Image') }}</td>
                                <td>
                                    @if ($provider->image)
                                        <img src="{{ asset('storage/' . $provider->image) }}" class="w_100">
                                    @else
                                        <p>{{ __('No Image') }}</p>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('Status') }}</td>
                                <td>{{ $provider->status == 'active' ? __('Active') : __('Inactive') }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('Category') }}</td>
                                <td>{{ $provider->category->name ?? __('Uncategorized') }} <br>
                                    {{ optional($provider->category)->getTranslation('name', $locale) ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('Description') }}</td>
                                <td>{{ strip_tags($provider->description) }} <br>
                                    {{ strip_tags($provider->getTranslation('description', $locale)) }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('Opens At') }}</td>
                                <td>
                                    {{ isset($provider->options['open_at'])
                                        ? \Carbon\Carbon::createFromFormat('H:i', $provider->options['open_at'])->format('h:i A')
                                        : 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('Closes In') }}</td>
                                <td>
                                    {{ isset($provider->options['close_at'])
                                        ? \Carbon\Carbon::createFromFormat('H:i', $provider->options['close_at'])->format('h:i A')
                                        : 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('Joined At') }}</td>
                                <td>{{ \Carbon\Carbon::parse($provider->created_at)->format('d M, Y h:i A') }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('Package Subscription') }}</td>
                                <td>{{ $provider->CurrentSubscription? $provider->CurrentSubscription->getTranslation('name', $locale) : __('not subscribed yet') }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            @if($provider->CurrentSubscription)
                <div class="card package-subscription-card">
                    <!-- Package Header -->
                    <div class="card-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-{{ $provider?->CurrentSubscription?->price ? 'crown' : 'gem' }}"></i>
                                {{ $provider?->CurrentSubscription?->getTranslation('name', app()->getLocale()) }}
                            </h5>
                        </div>
                    </div>

                    <!-- Package Price -->
                    <div class="card-body text-center py-4">
                        <div class="package-price mb-3">
                            @if($provider?->CurrentSubscription?->price)
                                <h2 class="text-primary">${{ number_format($provider?->CurrentSubscription?->price, 2) }}</h2>
                                <small class="text-muted">{{ __('one time') }}</small>
                            @else
                                <h2 class="text-success">{{ __('FREE') }}</h2>
                                <small class="text-muted">{{ __('forever') }}</small>
                            @endif
                        </div>

                        <!-- Trial Badge -->
                        @if($provider->trial_days > 0)
                            <div class="trial-badge mb-3">
                            <span class="badge badge-warning">
                                <i class="fas fa-gift"></i>
                                {{ __(':days days free trial', ['days' => $provider->CurrentSubscription->trial_days]) }}
                            </span>
                            </div>
                        @endif

                        <!-- Package Description -->
                        <p class="card-text text-muted mb-4">
                            {{ $provider?->CurrentSubscription?->getTranslation('description', app()->getLocale()) }}
                        </p>

                        <!-- Subscription Status -->
                        @if($provider->CurrentSubscription)
                            <div class="subscription-status alert alert-success">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-left">
                                        <small class="d-block">
                                            <strong>{{ __('Started') }}:</strong>
                                            {{ $provider->CurrentSubscription->pivot->start_subscription_date->format('M d, Y') }}
                                        </small>
                                        <small class="d-block">
                                            <strong>{{ __('Expires') }}:</strong>
                                            {{ $provider->CurrentSubscription->pivot->end_subscription_date->format('M d, Y') }}
                                        </small>
                                        @if($provider->CurrentSubscription->pivot->end_trail_date->isFuture())
                                            <small class="d-block text-warning">
                                                <strong>{{ __('Trial ends') }}:</strong>
                                                {{ $provider->CurrentSubscription->pivot->end_trail_date->format('M d, Y') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="status-indicator">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> {{ __('Active') }}
                                    </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Package Features -->
                        <div class="card-body border-top">
                            <div class="package-features">
                                <div class="feature-item d-flex justify-content-between align-items-center py-2">
                            <span class="feature-icon">
                                <i class="fas fa-calendar-alt text-info"></i>
                                {{ __('Duration') }}
                            </span>
                                    <strong class="feature-value">{{ $provider->CurrentSubscription?->duration_days ?? 0 }} {{ __('days') }}</strong>
                                </div>

                                <div class="feature-item d-flex justify-content-between align-items-center py-2">
                            <span class="feature-icon">
                                <i class="fas fa-clock text-warning"></i>
                                {{ __('Trial Period') }}
                            </span>
                                    <strong class="feature-value">{{ $provider->CurrentSubscription?->trial_days }} {{ __('days') }}</strong>
                                </div>

                                <div class="feature-item d-flex justify-content-between align-items-center py-2">
                <span class="feature-icon">
                    <i class="fas fa-users text-primary"></i>
                    {{ __('Subscribers') }}
                </span></div>

                                <div class="feature-item d-flex justify-content-between align-items-center py-2">
                <span class="feature-icon">
                    <i class="fas fa-toggle-on text-{{ $provider->CurrentSubscription?->is_active ? 'success' : 'danger' }}"></i>
                    {{ __('Status') }}
                </span>
                                    <span class="badge badge-{{ $provider->CurrentSubscription?->is_active ? 'success' : 'danger' }}">
                    {{ $provider?->CurrentSubscription?->is_active ? __('Active') : __('Inactive') }}
                </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer with Actions -->
                        <div class="card-footer bg-transparent">
                            <div class="action-buttons">
                                @if($provider->CurrentSubscription)
                                    <!-- Current Package Actions -->
                                    <div class="btn-group w-100">
                                        <button class="btn btn-success w-75" disabled>
                                            <i class="fas fa-check-circle"></i> {{ __('Subscribed') }}
                                        </button>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <small class="text-muted">
                                            @php
                                                $endDate = $provider->current_subscription?->pivot?->end_subscription_date;

                                                if ($endDate) {
                                                    $endDate = \Carbon\Carbon::parse($endDate);
                                                    // Get signed difference in whole days (can be negative if expired)
                                                    $days = now()->diffInDays($endDate, false);
                                                }
                                            @endphp

                                            @if (empty($endDate))
                                                {{ __('No active subscription') }}
                                            @elseif ($days < 0)
                                                {{ __('Subscription expired :days days ago', ['days' => abs((int)$days)]) }}
                                            @elseif ($days === 0)
                                                {{ __('Expires today') }}
                                            @else
                                                {{ __('Expires in :days days', ['days' => (int)$days]) }}
                                            @endif
                                        </small>
                                    </div>





                                @endif
                                <!-- Available Package Actions -->
                                {{--                            <div class="btn-group w-100">--}}
                                {{--                                <form action="{{ route('service-providers.package.subscribe', $package) }}"--}}
                                {{--                                      method="POST" class="w-75">--}}
                                {{--                                    @csrf--}}
                                {{--                                    <button type="submit" class="btn btn-primary w-100"--}}
                                {{--                                            onclick="return confirm('{{ __("Are you sure you want to subscribe to :package_name?", ["package_name" => $package->getTranslation("name", app()->getLocale())]) }}')">--}}
                                {{--                                        <i class="fas fa-shopping-cart"></i> {{ __('Subscribe') }}--}}
                                {{--                                    </button>--}}
                                {{--                                </form>--}}
                                {{--                                <a href="{{ route('service-providers.package.show', $package) }}"--}}
                                {{--                                   class="btn btn-outline-info" title="{{ __('View Details') }}">--}}
                                {{--                                    <i class="fas fa-eye"></i>--}}
                                {{--                                </a>--}}
                                {{--                            </div>--}}
                                {{--                        @endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Warning Style No Subscription Card -->
                <div class="card package-subscription-card no-subscription">
                    <div class="card-header bg-warning text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ __('Subscription Required') }}
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-warning mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="alert-heading">{{ __('Action Required') }}</h6>
                                    {{ __('This provider needs to subscribe to a package to access all platform features and services.') }}
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('moderators.provider.subscription-details') }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-gem me-2"></i> {{ __('View Available Packages') }}
                            </a>
                            <p class="text-muted small mt-2">
                                {{ __('Choose from our range of packages tailored for your business needs') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <style>
        .package-subscription-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .package-subscription-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .package-subscription-card.current-package {
            border-color: #28a745;
        }

        .package-subscription-card.package-full {
            opacity: 0.8;
        }

        .package-price h2 {
            font-weight: 700;
            margin-bottom: 0;
        }

        .trial-badge .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }

        .package-features .feature-item {
            border-bottom: 1px solid #f8f9fa;
        }

        .package-features .feature-item:last-child {
            border-bottom: none;
        }

        .feature-icon {
            font-size: 0.9rem;
        }

        .feature-value {
            font-size: 0.9rem;
        }

        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .subscription-status {
            margin-bottom: 0;
            padding: 0.75rem;
        }

        .status-indicator .badge {
            font-size: 0.7rem;
        }

        .action-buttons .btn {
            border-radius: 0.375rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .package-subscription-card {
                margin-bottom: 1.5rem;
            }

            .action-buttons .btn-group {
                flex-direction: column;
            }

            .action-buttons .btn-group .btn {
                width: 100% !important;
                margin-bottom: 0.5rem;
            }
        }
    </style>

</x-dashboard.main-layout>
