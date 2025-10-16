<x-dashboard.main-layout>
    @php
        $locale = app()->getLocale();
    @endphp
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Edit Package: {{ $package->getTranslation('name', $locale) }}
                    </h3>
                    <a href="{{ route('admins.packages.index') }}" class="btn btn-sm btn-outline-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Packages
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admins.packages.update', $package) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <h5>English Information</h5>
                                <div class="form-group">
                                    <label for="name_en">Name (English) *</label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                           id="name_en" name="name_en"
                                           value="{{ old('name_en', $package->getTranslation('name', 'en') ?? '') }}" required>
                                    @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_en">Description (English)</label>
                                    <textarea class="form-control @error('description_en') is-invalid @enderror"
                                              id="description_en" name="description_en" rows="3">{{ old('description_en', $package->getTranslation('description', 'en') ?? '') }}</textarea>
                                    @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Arabic Information</h5>
                                <div class="form-group">
                                    <label for="name_ar">Name (Arabic) *</label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                           id="name_ar" name="name_ar"
                                           value="{{ old('name_ar', $package->getTranslation('name', 'ar') ?? '') }}" required dir="rtl">
                                    @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_ar">Description (Arabic)</label>
                                    <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                              id="description_ar" name="description_ar" rows="3" dir="rtl">{{ old('description_ar', $package->getTranslation('description', 'en') ?? '') }}</textarea>
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
                                    <label for="price">Price ($)</label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price', $package->price) }}">
                                    <small class="form-text text-muted">Leave empty or set to 0 for free packages</small>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="duration_days">Duration (Days) *</label>
                                    <input type="number" min="1" class="form-control @error('duration_days') is-invalid @enderror"
                                           id="duration_days" name="duration_days"
                                           value="{{ old('duration_days', $package->duration_days) }}" required>
                                    @error('duration_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="trial_days">Trial Days *</label>
                                    <input type="number" min="0" class="form-control @error('trial_days') is-invalid @enderror"
                                           id="trial_days" name="trial_days"
                                           value="{{ old('trial_days', $package->trial_days) }}" required>
                                    @error('trial_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label for="subscribers_count_allowed">Maximum Subscribers *</label>--}}
{{--                                    <input type="number" min="0" class="form-control @error('subscribers_count_allowed') is-invalid @enderror"--}}
{{--                                           id="subscribers_count_allowed" name="subscribers_count_allowed"--}}
{{--                                           value="{{ old('subscribers_count_allowed', $package->subscribers_count_allowed) }}" required>--}}
{{--                                    <small class="form-text text-muted">Set to 0 for unlimited subscribers</small>--}}
{{--                                    @error('subscribers_count_allowed')--}}
{{--                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active Package</label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Package
                            </button>
                            <a href="{{ route('admins.packages.show', $package) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('admins.packages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.main-layout>
