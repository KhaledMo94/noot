<x-dashboard.main-layout>
    @php
        $locale = app()->getLocale();
        $serviceProvider = Auth::user()->serviceProvider ?? null;

//        dd($currentSubscription);
    @endphp

    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-gray-800">
                    <i class="fas fa-box-open"></i> {{ __('Package Subscriptions') }}
                </h1>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i>
                    {{ __('Choose a package that fits your needs and subscribe to get started') }}
                </div>
            </div>

            <!-- Current Subscription Section -->
            @if($currentSubscription)
                <div class="card shadow mb-4 border-success">
                    <div class="card-header bg-success text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-star"></i> {{ __('Current Subscription') }}
                            </h4>
                            <span class="badge badge-light badge-pill">
                                <i class="fas fa-check-circle"></i> {{ __('Active') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
{{--                                <pre>{{ $currentSubscription }}</pre>--}}
                                <h3 class="text-success mb-2">
                                    {{ $currentSubscription->getTranslation('name', $locale) }}
                                </h3>
                                <p class="text-muted mb-3">
                                    {{ $currentSubscription->getTranslation('description', $locale) }}
                                </p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="subscription-details">
                                            <div class="detail-item mb-2">
                                                <strong>{{ __('Started') }}:</strong>
                                                {{ $currentSubscription->pivot->start_subscription_date->format('M d, Y') }}
                                            </div>
                                            <div class="detail-item mb-2">
                                                <strong>{{ __('Expires') }}:</strong>
                                                {{ $currentSubscription->pivot->end_subscription_date->format('M d, Y') }}
                                            </div>
                                            <div class="detail-item mb-2">
                                                <strong>{{ __('Days Remaining') }}:</strong>

                                                @php
                                                    $days = $serviceProvider->days_remaining;
                                                @endphp

                                                @if (is_null($days))
                                                    <span class="badge bg-secondary text-white">{{ __('No active subscription') }}</span>

                                                @elseif ($days < 0)
                                                    <span class="badge bg-danger text-white">
                                                        {{ __('Expired :days days ago', ['days' => abs($days)]) }}
                                                    </span>

                                                @elseif ($days === 0)
                                                    <span class="badge bg-warning text-white">{{ __('Expires today') }}</span>

                                                @else
                                                    <span class="badge bg-success text-white">
                                                        {{ $days }} {{ __('days') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="subscription-details">
                                            <div class="detail-item mb-2">
                                                <strong>{{ __('Price') }}:</strong>
                                                @if($currentSubscription->price)
                                                    <span class="text-primary font-weight-bold">
                                                        ${{ number_format($currentSubscription->price, 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-success font-weight-bold">{{ __('FREE') }}</span>
                                                @endif
                                            </div>
                                            <div class="detail-item mb-2">
                                                <strong>{{ __('Duration') }}:</strong>
                                                {{ $currentSubscription->duration_days }} {{ __('days') }}
                                            </div>
                                            @if($serviceProvider->is_in_trial_period)
                                                <div class="detail-item mb-2">
                                                    <strong>{{ __('Trial Ends') }}:</strong>
                                                    <span class="text-warning font-weight-bold">
                                                        {{ $serviceProvider->pivot->end_trail_date->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="btn-group-vertical w-100">
                                    <button type="button" class="btn btn-outline-danger mb-2"
                                            data-toggle="modal" data-target="#cancelSubscriptionModal">
                                        <i class="fas fa-times-circle"></i> {{ __('Cancel Subscription') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Subscription Message -->
                <div class="card shadow mb-4 border-warning">
                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle"></i> {{ __('No Active Subscription') }}
                        </h4>
                    </div>
                    <div class="card-body text-center py-5">
                        <i class="fas fa-gem fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('You are not subscribed to any package') }}</h4>
                        <p class="text-muted mb-4">{{ __('Choose a package below to get started with our services') }}</p>
                    </div>
                </div>
            @endif

            <!-- Available Packages Section -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-boxes"></i> {{ __('Available Packages') }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($packages as $package)
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                <div class="card package-card h-100
                                {{ $currentSubscription && $currentSubscription->id == $package->id ? 'current-package border-success' : '' }}">

                                    <!-- Package Header -->
                                    <div class="card-header
                                    {{ $currentSubscription && $currentSubscription->id == $package->id ? 'bg-success text-white' : 'bg-light text-dark' }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-{{ $package->price ? 'crown' : 'gem' }}"></i>
                                                {{ $package->getTranslation('name', $locale) }}
                                            </h5>
                                            @if($currentSubscription && $currentSubscription->id == $package->id)
                                                <span class="badge badge-light">
                                                    <i class="fas fa-check-circle"></i> {{ __('Current') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Package Price & Description -->
                                    <div class="card-body text-center py-4">
                                        <div class="package-price mb-3">
                                            @if($package->price)
                                                <h2 class="text-primary">${{ number_format($package->price, 2) }}</h2>
                                            @else
                                                <h2 class="text-success">{{ __('FREE') }}</h2>
                                                <small class="text-muted">{{ __('no charges') }}</small>
                                            @endif
                                        </div>

                                        <!-- Trial Badge -->
                                        @if($package->trial_days > 0)
                                            <div class="trial-badge mb-3">
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-gift"></i>
                                                    {{ __(':days days free trial', ['days' => $package->trial_days]) }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Package Description -->
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($package->getTranslation('description', $locale), 120) }}
                                        </p>
                                    </div>

                                    <!-- Package Features -->
                                    <div class="card-body border-top py-3">
                                        <div class="package-features">
                                            <div class="feature-item d-flex justify-content-between align-items-center py-2">
                                                <span class="feature-icon">
                                                    <i class="fas fa-calendar-alt text-info"></i>
                                                    {{ __('Duration') }}
                                                </span>
                                                <strong class="feature-value">{{ $package->duration_days }} {{ __('days') }}</strong>
                                            </div>

                                            <div class="feature-item d-flex justify-content-between align-items-center py-2">
                                                <span class="feature-icon">
                                                    <i class="fas fa-clock text-warning"></i>
                                                    {{ __('Trial') }}
                                                </span>
                                                <strong class="feature-value">{{ $package->trial_days }} {{ __('days') }}</strong>
                                            </div>

                                            <div class="feature-item d-flex justify-content-between align-items-center py-2">
                                                <span class="feature-icon">
                                                    <i class="fas fa-toggle-on text-{{ $package->is_active ? 'success' : 'danger' }}"></i>
                                                    {{ __('Status') }}
                                                </span>
                                                <span class="badge badge-{{ $package->is_active ? 'success' : 'danger' }}">
                                                    {{ $package->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="card-footer bg-transparent">
                                        <div class="action-buttons">
                                            @if($currentSubscription)
                                                <!-- Current Package -->
                                                <div class="btn-group w-100">
                                                    <button class="btn btn-success w-75" disabled>
                                                        <i class="fas fa-check-circle"></i> {{ __('Subscribed') }}
                                                    </button>
                                                </div>
                                            @else
                                                <!-- Available Package -->
                                                <div class="btn-group w-100">
                                                    <form method="POST" action="{{ route('moderators.provider.subscribe', $package) }}" class="w-100 subscribe-form">
                                                        @csrf
                                                        <button type="button"
                                                                class="btn btn-primary w-100 subscribe-btn"
                                                                data-package-name="{{ $package->getTranslation('name', $locale) }}"
                                                                data-has-current="{{ $currentSubscription ? 'true' : 'false' }}">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            {{ $currentSubscription ? __('Change Package') : __('Subscribe') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">{{ __('No packages available') }}</h4>
                                <p class="text-muted">{{ __('Please check back later for available packages') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Subscription Modal -->
    @if($currentSubscription)
        <div class="modal fade" id="cancelSubscriptionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Cancel Subscription') }}</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to cancel your current subscription?') }}</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>{{ __('Warning:') }}</strong>
                            {{ __('You will lose access to package features immediately after cancellation.') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{ __('Keep Subscription') }}
                        </button>
                        <form  method="POST" class="d-inline" action="{{ route('moderators.provider.unsubscribe') }}">
                            @csrf
                            @method("POST")
                            <button type="submit" class="btn btn-danger">
                                {{ __('Yes, Cancel Subscription') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Rest of your styles and scripts remain the same -->
    <style>
        .package-card {
            transition: all 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .package-card.current-package {
            border-color: #28a745;
        }

        .package-card.package-full {
            opacity: 0.7;
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
            font-size: 0.9rem;
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

        .subscription-details .detail-item {
            font-size: 0.9rem;
        }

        .action-buttons .btn {
            border-radius: 0.375rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .package-card {
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Your existing JavaScript code remains the same
            $('.subscribe-btn').on('click', function(e) {
                e.preventDefault();

                const packageName = $(this).data('package-name');
                const hasCurrentSubscription = $(this).data('has-current') === 'true';
                const form = $(this).closest('form');

                let title = '{{ __("Subscribe to Package") }}';
                let text = '{{ __("Are you sure you want to subscribe to") }} "' + packageName + '"?';

                if (hasCurrentSubscription) {
                    title = '{{ __("Change Package") }}';
                    text = '{{ __("Are you sure you want to change your subscription to") }} "' + packageName + '"? {{ __("This will replace your current subscription.") }}';
                }

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __("Yes, Subscribe") }}',
                    cancelButtonText: '{{ __("Cancel") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            $('form[action*="subscription.cancel"]').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: '{{ __("Cancel Subscription") }}',
                    text: '{{ __("Are you sure you want to cancel your current subscription? You will lose access to package features immediately.") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("Yes, Cancel") }}',
                    cancelButtonText: '{{ __("Keep Subscription") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ __("Success!") }}',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ __("Error!") }}',
                text: '{{ session('error') }}',
                timer: 5000,
                showConfirmButton: true
            });
            @endif

            @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: '{{ __("Information") }}',
                text: '{{ session('info') }}',
                timer: 3000,
                showConfirmButton: false
            });
            @endif
        });
    </script>
</x-dashboard.main-layout>
