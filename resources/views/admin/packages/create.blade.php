<x-dashboard.main-layout>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus-circle"></i> {{ __('Create New Package') }}
                    </h3>
                    <a href="{{ route('admins.packages.index') }}" class="btn btn-sm btn-outline-secondary float-right">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Packages') }}
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admins.packages.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ __('English Information') }}</h5>
                                <div class="form-group">
                                    <label for="name_en">{{ __('Name (English)') }} *</label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                           id="name_en" name="name_en" value="{{ old('name_en') }}" required>
                                    @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_en">{{ __('Description (English)') }}</label>
                                    <textarea class="form-control @error('description_en') is-invalid @enderror"
                                              id="description_en" name="description_en" rows="3">{{ old('description_en') }}</textarea>
                                    @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>{{ __('Arabic Information') }}</h5>
                                <div class="form-group">
                                    <label for="name_ar">{{ __('Name (Arabic)') }} *</label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                           id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required dir="rtl">
                                    @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_ar">{{ __('Description (Arabic)') }}</label>
                                    <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                              id="description_ar" name="description_ar" rows="3" dir="rtl">{{ old('description_ar') }}</textarea>
                                    @error('description_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">{{ __('Price') }} ($)</label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price') }}">
                                    <small class="form-text text-muted">{{ __('Leave empty or set to 0 for free packages') }}</small>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="duration_days">{{ __('Duration (Days)') }} *</label>
                                    <input type="number" min="1" class="form-control @error('duration_days') is-invalid @enderror"
                                           id="duration_days" name="duration_days" value="{{ old('duration_days', 30) }}" required>
                                    @error('duration_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="trial_days">{{ __('Trial Days') }} *</label>
                                    <input type="number" min="0" class="form-control @error('trial_days') is-invalid @enderror"
                                           id="trial_days" name="trial_days" value="{{ old('trial_days', 0) }}" required>
                                    @error('trial_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label for="subscribers_count_allowed">{{ __('Maximum Subscribers') }} *</label>--}}
{{--                                    <input type="number" min="0" class="form-control @error('subscribers_count_allowed') is-invalid @enderror"--}}
{{--                                           id="subscribers_count_allowed" name="subscribers_count_allowed"--}}
{{--                                           value="{{ old('subscribers_count_allowed', 0) }}" required>--}}
{{--                                    <small class="form-text text-muted">{{ __('Set to 0 for unlimited subscribers') }}</small>--}}
{{--                                    @error('subscribers_count_allowed')--}}
{{--                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">{{ __('Active Package') }}</label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Create Package') }}
                            </button>
                            <a href="{{ route('admins.packages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.main-layout>
