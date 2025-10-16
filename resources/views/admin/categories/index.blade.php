<x-dashboard.main-layout>
    @php
        $rev_locale = app()->getLocale() == 'en' ? 'ar' : 'en';
    @endphp
    
    <h1 class="mb-3 text-gray-800 h3">{{ __('Categories') }}</h1>
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
            <div class="float-right d-inline">
                <a href="{{ route('admins.categories.create') }}" class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i>{{ __('Add New') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id ="dataTable-ar" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Serial') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach ($categories as $category)
                            <tr data-id="{{ $category->id }}">
                                <td>{{ ++$i }}</td>
                                <td>{{ $category->name ?? '' }} <br>
                                    {{ $category->getTranslation('name', $rev_locale) }}</td>
                                <td>{{ $category->description }} <br>
                                    {{ $category->getTranslation('description', $rev_locale) }}</td>
                                @if (!is_null($category->image))
                                    <td><img src="{{ asset('storage/' . $category->image) }}" alt=""
                                            class="w_200"></td>
                                @else
                                    <td>
                                        <p>{{ __('No image') }}</p>
                                    </td>
                                @endif
                                <td>
                                    <input type="checkbox" @if ($category->status == 'active') checked @endif
                                        data-toggle="toggle" data-on="{{ __('Active') }}"
                                        data-off="{{ __('Pending') }}" data-onstyle="success"
                                        data-id = "{{ $category->id }}" data-offstyle="danger">
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('admins.categories.edit', $category->id) }}"
                                        class="mx-1 btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admins.categories.destroy', $category->id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mx-1 btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $category->id }}); event.preventDefault();"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
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
                var id = $(this).data('id');

                let url = "{{ route('admins.categories.toggle', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                });
            });
        });
        </script>
        <script>
        function confirmDelete(categoryId) {
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
                    document.getElementById('delete-form-' + categoryId).submit();
                }
            });
        }
    </script>

</x-dashboard.main-layout>
