<x-dashboard.main-layout>
    @php
        $rev_locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp
    <div class="card-body">
        <form class="my-3" action="{{ route('admins.providers.update', $provider->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4 shadow card t-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" id="p1_tab" data-toggle="pill" href="#p1"
                                    role="tab" aria-controls="p1" aria-selected="true">{{ __('Main Section') }}
                                </a>
                                <a class="nav-link" id="p2_tab" data-toggle="pill" href="#p2" role="tab"
                                    aria-controls="p2" aria-selected="false">{{ __('Calculations') }}
                                </a>
                                {{-- <a class="nav-link" id="p3_tab" data-toggle="pill" href="#p3" role="tab"
                                    aria-controls="p3" aria-selected="false">{{ __('Moderator') }}
                                </a> --}}
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- Tab 1 -->
                                <div class="tab-pane fade show active" id="p1" role="tabpanel"
                                    aria-labelledby="p1_tab">
                                    <h4 class="heading-in-tab">{{ __('Main Section') }}</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Name In Arabic') }}</label>
                                                <input type="text" name="name_ar" class="form-control"
                                                    value="{{ old('name_ar') ?? $provider->getTranslation('name', 'ar') }}"
                                                    autofocus>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Name In English') }}</label>
                                                <input type="text" name="name_en" class="form-control"
                                                    value="{{ old('name_en') ?? $provider->getTranslation('name', 'en') }}"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="time_from">{{ __('Time From') }}</label>
                                                <input type="time" name="time_from" class="form-control"
                                                    value="{{ old('time_from') ?? optional($provider->options)['open_at'] }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="time_to">{{ __('Time To') }}</label>
                                                <input type="time" name="time_to" class="form-control"
                                                    value="{{ old('time_to') ?? optional($provider->options)['close_at'] }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Description In Arabic') }}</label>
                                        <textarea name="description_ar" class="form-control editor" cols="30" rows="10">
                                            {{ old('description_ar') ?? $provider->getTranslation('description', 'ar') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Description In English') }}</label>
                                        <textarea name="description_en" class="form-control editor" cols="30" rows="10">
                                            {{ old('description_en') ?? $provider->getTranslation('description', 'en') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Category') }}</label>
                                        <select name="category_id" class="form-control">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected($category->id == $provider->category_id)>
                                                    {{ $category->name }} -
                                                    {{ $category->getTranslation('name', $rev_locale) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="services">{{ __('Services') }}</label>
                                        <select name="services[]" class="w-100 select2" id="services" required
                                            multiple>
                                            @foreach ($services as $service)
                                                <option value="{{ $service['id'] }}" @selected(in_array($service['id'], old('services', $provider->services->pluck('id')->toArray())))>
                                                    {{ $service['name'] }} -
                                                    {{ $service->getTranslation('name', $rev_locale) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <div class="form-group">
                                        <label for="">{{ __('Existing Image') }}</label>
                                        <div>
                                            @if ($provider->image)
                                                <img src="{{ asset('storage/' . $provider->image) }}" class="w_200"
                                                    alt="">
                                            @else
                                                <p>{{ __('No Image') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{ __('Featured Photo') }}</label>
                                        <div>
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                </div>
                                <!-- // Tab 1 -->

                                <!-- Tab 2 -->
                                <div class="tab-pane fade" id="p2" role="tabpanel" aria-labelledby="p2_tab">
                                    <h4 class="heading-in-tab">{{ __('Calculations') }}</h4>
                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Provider Discount') }}</label>
                                                <input type="number" step="0.01" name="provider_discount"
                                                    class="form-control"
                                                    value="{{ old('provider_discount') ?? $provider->discount_percent }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Normal Percentage') }}</label>
                                                <input type="number" step="0.01" name="normal_percentage"
                                                    class="form-control"
                                                    value="{{ old('normal_percentage') ?? $provider->normal_percent }}">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <!-- // Tab 2 -->
                                {{-- Tab 3  --}}

                                {{-- //tab 3  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block mb_40">{{ __('Update') }}</button>
        </form>

    </div>
</x-dashboard.main-layout>
