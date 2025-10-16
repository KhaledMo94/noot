<x-dashboard.main-layout>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-eye"></i> {{ __('Package Details') }}
                    </h3>
                    <div>
                        <a href="{{ route('admins.packages.edit', $package) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                        </a>
                        <a href="{{ route('admins.packages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ __('Basic Information') }}</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">{{ __('ID') }}</th>
                                    <td>{{ $package->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name (English)') }}</th>
                                    <td>{{ $package->getTranslation('name', 'en') ?? __('N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Name (Arabic)') }}</th>
                                    <td dir="rtl">{{ $package->getTranslation('name', 'ar') ?? __('N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Price') }}</th>
                                    <td>
                                        @if($package->price)
                                            ${{ number_format($package->price, 2) }}
                                        @else
                                            <span class="text-success">{{ __('Free') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Duration') }}</th>
                                    <td>{{ $package->duration_days }} {{ __('days') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ __('Additional Information') }}</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">{{ __('Trial Days') }}</th>
                                    <td>{{ $package->trial_days }} {{ __('days') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Current Subscribers') }}</th>
                                    <td>{{ $package->current_subscribers_count }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Expired Subscribers') }}</th>
                                    <td>{{ $package->expired_subscribers_count }}</td>
                                </tr>

{{--                                <tr>--}}
{{--                                    <th>{{ __('Max Subscribers') }}</th>--}}
{{--                                    <td>--}}
{{--                                        @if($package->subscribers_count_allowed == 0)--}}
{{--                                            <span class="text-success">{{ __('Unlimited') }}</span>--}}
{{--                                        @else--}}
{{--                                            {{ $package->subscribers_count_allowed }}--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th>{{ __('Available Capacity') }}</th>--}}
{{--                                    <td>--}}
{{--                                        @if($package->hasAvailableCapacity())--}}
{{--                                            <span class="text-success">{{ __('Available') }}</span>--}}
{{--                                            @if($package->subscribers_count_allowed > 0)--}}
{{--                                                ({{ $package->available_capacity }} {{ __('left') }})--}}
{{--                                            @endif--}}
{{--                                        @else--}}
{{--                                            <span class="text-danger">{{ __('Full') }}</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <th>{{ __('Status') }}</th>
                                    <td>
                                            <span class="badge badge-{{ $package->is_active ? 'success' : 'danger' }}">
                                                {{ $package->is_active ? __('Active') : __('Inactive') }}
                                            </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>{{ __('Descriptions') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">{{ __('English Description') }}</h6>
                                        </div>
                                        <div class="card-body">
                                            {{ $package->getTranslation('description', 'en') ?? __('No description available') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">{{ __('Arabic Description') }}</h6>
                                        </div>
                                        <div class="card-body" dir="rtl">
                                            {{ $package->getTranslation('description', 'ar') ?? __('No description available') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>{{ __('Timestamps') }}</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">{{ __('Created At') }}</th>
                                    <td>{{ $package->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Updated At') }}</th>
                                    <td>{{ $package->updated_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.main-layout>
