<x-dashboard.main-layout>
    @php
        $rev_locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp
    <h1 class="mb-3 text-gray-800 h3">{{ __('Cities') }}</h1>
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
            <div class="float-right d-inline">
                <a href="{{ route('admins.cities.create') }}" class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i>{{ __('Add New') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable-ar" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Serial') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('City Name') }}</th>
                            <th>{{ __('City Description') }}</th>
                            <th>{{ __('Branches Count') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach ($cities as $city)
                            <tr data-id="{{ $city->id }}">
                                <td>{{ ++$i }}</td>
                                @if (!is_null($city->image))
                                    <td>
                                        <img src="{{ asset('storage/' . $city->image) }}" alt=""
                                            class="w_200">
                                    </td>
                                @else
                                    <td>
                                        <p>{{ __('No Image') }}</p>
                                    </td>
                                @endif
                                <td>{{ $city->name }} <br> {{ $city->getTranslation('name', $rev_locale) }} </td>
                                <td>{{ strip_tags($city->description) }} <br>
                                    {{ strip_tags($city->getTranslation('description', $rev_locale)) }}</td>
                                <td>{{ $city->service_provider_branches_count }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('admins.cities.edit', $city->id) }}"
                                        class="mx-1 btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form id="delete-form-{{ $city->id }}"
                                        action="{{ route('admins.cities.destroy', $city->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="mx-1 btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $city->id }}); event.preventDefault();">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(cityId) {
            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to revert this!') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('Yes, delete it!') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + cityId).submit();
                    document.querySelector('tr[data-id="' + cityId + '"]')?.remove();
                }
            });
        }
    </script>


</x-dashboard.main-layout>
