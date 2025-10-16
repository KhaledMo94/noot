<x-dashboard.main-layout>
    @php
        $rev_locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp
    <h1 class="mb-3 text-gray-800 h3">{{ __('Services') }}</h1>
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
            <div class="float-right d-inline">
                <a href="{{ route('admins.services.create') }}" class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i>{{ __('Add New') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable-ar" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Serial') }}</th>
                            <th>{{ __('Service Name') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Service Description') }}</th>
                            <th>{{ __('Label') }}</th>
                            <th>{{ __('Providers Count') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach ($services as $service)
                            <tr >
                                <td>{{ ++$i }}</td>
                                <td>
                                    {{ $service->name }}<br>
                                    {{ $service->getTranslation('name', $rev_locale) }}
                                </td>
                                @if (!is_null($service->image))
                                    <td><img src="{{ asset('storage/' . $service->image) }}" alt=""
                                            class="w_200"></td>
                                @else
                                    <td>
                                        <p>{{ __('No image') }}</p>
                                    </td>
                                @endif
                                <td>
                                    {{ strip_tags($service->description) }}<br>
                                    {{ strip_tags($service->getTranslation('description', $rev_locale)) }}
                                </td>

                                <td>{{ $service->discount_label }}</td>
                                <td>{{ $service->service_providers_count }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admins.services.edit', $service->id) }}"
                                            class="mx-1 btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admins.services.destroy', $service->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mx-1 btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="py-2 d-flex justify-content-center">
            {{-- {{ $services->links() }} --}}
        </div>
    </div>

</x-dashboard.main-layout>
