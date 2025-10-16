<x-dashboard.main-layout>
    @php
        $rev_locale = app()->getLocale() == 'ar' ? 'en' : 'ar';
    @endphp
    <h1 class="mb-3 text-gray-800 h3">{{ __('Cashiers') }}</h1>
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
            <div class="float-right d-inline">
                <a href="{{ route('admins.cashiers.create') }}" class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i>{{ __('Add New') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable-ar" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Serial') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Service Provider') }}</th>
                            <th>{{ __('Service Provider Image') }}</th>
                            <th>{{ __('Branch Address') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach ($cashiers as $cashier)
                            <tr data-id="{{ $cashier->id }}">
                                <td>{{ ++$i }}</td>
                                <td>{{ $cashier->name ?? '' }}</td>
                                <td>{{ $cashier->email ?? __('No Email') }}</td>
                                <td>
                                    @if ($cashier->image)
                                        <img src="{{ asset('storage/' . $cashier->image) }}"
                                            alt="{{ $cashier->name }}" width="50px">
                                    @endif
                                </td>
                                <td>
                                    {{ $cashier->serviceProviderBranch?->serviceProvider->getTranslation('name', app()->getLocale()) }}
                                    <br>
                                    {{ $cashier->serviceProviderBranch?->serviceProvider->getTranslation('name', $rev_locale) }}
                                </td>

                                <td>
                                    @if ($cashier->serviceProviderBranch?->serviceProvider->image)
                                        <img src="{{ asset('storage/' . $cashier->serviceProviderBranch?->serviceProvider->image) }}"
                                            alt="" width="100px">
                                    @endif
                                </td>
                                <td>{{ $cashier->serviceProviderBranch?->getTranslation('address', app()->getLocale()) }}
                                    <br>
                                    {{ $cashier->serviceProviderBranch?->getTranslation('address', $rev_locale) }}
                                </td>
                                <td>
                                    <input type="checkbox" @if ($cashier->status == 'active') checked @endif
                                        data-toggle="toggle" data-on="{{ __('Active') }}"
                                        data-off="{{ __('Banned') }}" data-onstyle="success"
                                        data-id = "{{ $cashier->id }}" data-offstyle="danger">
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admins.cashiers.edit', $cashier->id) }}"
                                            class="mx-1 btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admins.cashiers.destroy', $cashier->id) }}"
                                            id="delete-form-{{ $cashier->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mx-1 btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $cashier->id }}); event.preventDefault();">
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
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('input[type="checkbox"]').on('change', function() {

                const checkbox = $(this);
                const id = checkbox.data('id');
                const url = @json(route('admins.users.toggle', ['id' => ':id'])).replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {},
                    error: function(xhr) {},
                });
            });
        });
    </script>

</x-dashboard.main-layout>
