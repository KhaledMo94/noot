<x-dashboard.main-layout>
    <div class=" py-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">
                <div class="card shadow border-0">
                    <div class="card-header text-white py-3" style="background-color: #1e7e34">
                        <h4 class="mb-0">{{ __('General Settings') }}</h4>
                    </div>

                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('admins.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Website Name -->
                            <div class="mb-3">
                                <label for="site_name_en" class="form-label">{{ __('Website Name English') }}</label>
                                <input type="text" name="site_name_en" id="site_name_en"
                                    value="{{ old('site_name_en', $settings['site_name_en'] ?? '') }}"
                                    class="form-control @error('site_name_en') is-invalid @enderror" required>
                                @error('site_name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="site_name_ar" class="form-label">{{ __('Website Name Arabic') }}</label>
                                <input type="text" name="site_name_ar" id="site_name_ar"
                                    value="{{ old('site_name_ar', $settings['site_name_ar'] ?? '') }}"
                                    class="form-control @error('site_name_ar') is-invalid @enderror" required>
                                @error('site_name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website Logo -->
                            <div class="mb-3">
                                <label for="logo" class="form-label">{{ __('Website Logo') }}</label>
                                <div class="d-flex align-items-center gap-3">
                                    @if (!empty($settings['logo']))
                                        <img src="{{ asset('storage/'.$settings['logo']) }}" alt="Logo" class="img-thumbnail"
                                            style="width: 80px; height: 80px; object-fit: contain;">
                                    @endif
                                    <input type="file" class="form-control" name="logo" id="logo"
                                        accept="image/*">
                                </div>
                                @error('logo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website Logo -->
                            <div class="mb-3">
                                <label for="favicon" class="form-label">{{ __('Website favicon') }}</label>
                                <div class="d-flex align-items-center gap-3">
                                    @if (!empty($settings['favicon']))
                                        <img src="{{ asset('storage/'.$settings['favicon']) }}" alt="favicon" class="img-thumbnail"
                                            style="width: 80px; height: 80px; object-fit: contain;">
                                    @endif
                                    <input type="file" class="form-control" name="favicon" id="favicon"
                                        accept="image/*">
                                </div>
                                @error('favicon')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="free_trail_days" class="form-label">{{ __('Free Trail Days') }}</label>
                                <input type="number" step="1" min="0" name="free_trail_days" id="free_trail_days"
                                    value="{{ old('free_trail_days', $settings['free_trail_days'] ?? '') }}"
                                    class="form-control @error('free_trail_days') is-invalid @enderror">
                                @error('free_trail_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-check-circle me-1"></i> {{ __('Save Changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.main-layout>
