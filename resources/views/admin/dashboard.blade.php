<x-dashboard.main-layout>

    @php
        $local = app()->getLocale();
    @endphp
    <div class="row">
        <div class="mb-2 col-xl-12 col-md-12">
            <h1 class="mb-3 text-gray-800 h3">{{ __('Dashboard') }}</h1>
        </div>
    </div>
</x-dashboard.main-layout>
