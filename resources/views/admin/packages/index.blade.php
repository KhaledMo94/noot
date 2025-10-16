<x-dashboard.main-layout>
    @php
        $rev_locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">{{ __('Packages Management') }}</h3>
                    <a href="{{ route('admins.packages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Add New Package') }}
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="{{ route('admins.packages.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="filter[search]" class="form-control"
                                   placeholder="{{ __('Search packages...') }}"
                                   value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i> {{ __('Search') }}
                                </button>
                                @if($search)
                                    <a href="{{ route('admins.packages.index') }}" class="btn btn-outline-danger">
                                        <i class="fas fa-times"></i> {{ __('Clear') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>


                    <!-- Packages Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name (EN/AR)') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Trial Days') }}</th>
                                <th>{{ __('Subscribers') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($packages as $package)
                                <tr>
                                    <td>{{ $package->id }}</td>
                                    <td>
                                        <strong>{{ $package->getTranslation('name', 'en') ?? __('N/A') }}</strong><br>
                                        <small class="text-muted">{{ $package->getTranslation('name', 'ar') ?? __('N/A') }}</small>
                                    </td>
                                    <td>
                                        @if($package->price)
                                            ${{ number_format($package->price, 2) }}
                                        @else
                                            <span class="text-muted">{{ __('Free') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $package->duration_days }} {{ __('days') }}</td>
                                    <td>{{ $package->trial_days }} {{ __('days') }}</td>
                                    <td>
                                        {{ $package->service_providers_count }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $package->is_active ? 'success' : 'danger' }}">
                                            {{ $package->is_active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </td>
                                    <td>{{ $package->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admins.packages.show', $package) }}" class="btn btn-info mx-1"
                                               title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admins.packages.edit', $package) }}"
                                               class="btn btn-warning mx-1" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger delete-package"
                                                    data-id="{{ $package->id }}"
                                                    data-name="{{ $package->getTranslation('name', 'en') }}"
                                                    data-url="{{ route('admins.packages.destroy', $package) }}"
                                                    title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        @if($search)
                                            {{ __('No packages found matching your search.') }}
                                        @else
                                            {{ __('No packages found.') }} <a href="{{ route('admins.packages.create') }}">{{ __('Create the first package') }}</a>.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($packages->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $packages->appends(['search' => $search])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        $(document).ready(function () {
            // SweetAlert for delete confirmation
            $('.delete-package').on('click', function () {
                const packageId = $(this).data('id');
                const packageName = $(this).data('name');
                const deleteUrl = $(this).data('url');

                Swal.fire({
                    title: '{{ __("Are you sure?") }}',
                    text: `{{ __("You are about to delete") }} "${packageName}". {{ __("This action cannot be undone!") }}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("Yes, delete it!") }}',
                    cancelButtonText: '{{ __("Cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('#delete-form');
                        form.attr('action', deleteUrl);
                        form.submit();
                    }
                });
            });

            // Show success/error messages with SweetAlert
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
        });
    </script>
</x-dashboard.main-layout>
