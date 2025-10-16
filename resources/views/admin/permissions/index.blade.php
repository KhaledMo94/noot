<x-dashboard.main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-dark mb-0">
            <i class="fas fa-key mr-2"></i>{{ __('Permissions Management') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-lock fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 font-weight-bold">{{ __('System Permissions') }}</h4>
                        <p class="text-muted mb-0">{{ __('Manage system permissions and access controls') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admins.permissions.create') }}" class="btn btn-success btn-lg shadow-sm hover-lift">
                    <i class="fas fa-plus-circle mr-2"></i>{{ __('Create New Permission') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-gradient p-3 mr-3">
                                <i class="fas fa-key text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Total Permissions') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $permissions->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-gradient p-3 mr-3">
                                <i class="fas fa-shield-alt text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Assigned to Roles') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $permissions->sum(fn($p) => $p->roles->count()) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-gradient p-3 mr-3">
                                <i class="fas fa-cogs text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Available for Use') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $permissions->where('roles_count', 0)->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-success text-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-list-ul mr-2"></i>{{ __('Permissions List') }}
                    </h5>
                    <span class="badge badge-light badge-pill px-3 py-2">
                        {{ $permissions->count() }} {{ __('Permissions') }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                        <tr>
                            <th scope="col" class="border-0 px-4 py-3" style="width: 5%">
                                <span class="text-muted font-weight-bold">#</span>
                            </th>
                            <th scope="col" class="border-0 px-4 py-3" style="width: 30%">
                                <span class="text-muted font-weight-bold">{{ __('Permission Name') }}</span>
                            </th>
                            <th scope="col" class="border-0 px-4 py-3" style="width: 25%">
                                <span class="text-muted font-weight-bold">{{ __('Type') }}</span>
                            </th>
                            <th scope="col" class="border-0 px-4 py-3" style="width: 25%">
                                <span class="text-muted font-weight-bold">{{ __('Assigned to Roles') }}</span>
                            </th>
                            <th scope="col" class="border-0 px-4 py-3 text-center" style="width: 15%">
                                <span class="text-muted font-weight-bold">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($permissions as $permission)
                            <tr class="permission-row">
                                <td class="px-4 py-3">
                                    <span class="badge badge-secondary badge-pill">{{ $permission->id }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-success text-white mr-3">
                                            <i class="fas fa-key"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold text-dark">{{ $permission->name }}</h6>
                                            <small class="text-muted">
                                                {{ $permission->guard_name }} guard
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $type = 'custom';
                                        $badgeClass = 'secondary';
                                        $icon = 'cog';

                                        if (str_contains($permission->name, 'create')) {
                                            $type = 'create';
                                            $badgeClass = 'success';
                                            $icon = 'plus';
                                        } elseif (str_contains($permission->name, 'edit') || str_contains($permission->name, 'update')) {
                                            $type = 'edit';
                                            $badgeClass = 'warning';
                                            $icon = 'edit';
                                        } elseif (str_contains($permission->name, 'delete') || str_contains($permission->name, 'destroy')) {
                                            $type = 'delete';
                                            $badgeClass = 'danger';
                                            $icon = 'trash';
                                        } elseif (str_contains($permission->name, 'view') || str_contains($permission->name, 'list') || str_contains($permission->name, 'read')) {
                                            $type = 'view';
                                            $badgeClass = 'info';
                                            $icon = 'eye';
                                        }
                                    @endphp
                                    <span class="badge badge-{{ $badgeClass }} badge-pill px-3 py-2">
                                        <i class="fas fa-{{ $icon }} mr-1"></i>{{ ucfirst($type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($permission->roles->isNotEmpty())
                                        <div class="roles-wrapper">
                                            @foreach($permission->roles as $index => $role)
                                                @if($index < 3)
                                                    <span class="badge badge-primary badge-pill mb-1 mr-1 role-badge">
                                                        <i class="fas fa-user-shield mr-1"></i>{{ $role->name }}
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if($permission->roles->count() > 3)
                                                <span class="badge badge-dark badge-pill mb-1 role-badge"
                                                      data-toggle="tooltip"
                                                      title="{{ $permission->roles->skip(3)->pluck('name')->implode(', ') }}">
                                                    +{{ $permission->roles->count() - 3 }} {{ __('more') }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ __('Not assigned to any role') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admins.permissions.edit', $permission) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           data-toggle="tooltip"
                                           title="{{ __('Edit Permission') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        @if($permission->roles->count() === 0)
                                            <form action="{{ route('admins.permissions.destroy', $permission) }}"
                                                  method="POST"
                                                  class="d-inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-delete"
                                                        data-toggle="tooltip"
                                                        title="{{ __('Delete Permission') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    disabled
                                                    data-toggle="tooltip"
                                                    title="{{ __('Cannot delete - assigned to roles') }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-key fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">{{ __('No permissions found') }}</h5>
                                        <p class="text-muted">{{ __('Create your first permission to get started') }}</p>
                                        <a href="{{ route('admins.permissions.create') }}" class="btn btn-success mt-3">
                                            <i class="fas fa-plus mr-2"></i>{{ __('Create Permission') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }

        .permission-row {
            transition: all 0.2s ease;
        }

        .permission-row:hover {
            background-color: #f8f9fa;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .role-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            transition: all 0.2s ease;
        }

        .role-badge:hover {
            transform: scale(1.05);
        }

        .roles-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .empty-state {
            padding: 2rem;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .table td {
            vertical-align: middle;
        }

        .bg-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--info) 100%);
        }
    </style>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Delete confirmation with enhanced SweetAlert
            document.querySelectorAll('.btn-delete').forEach(function (button) {
                button.addEventListener('click', function () {
                    const form = this.closest('form');

                    Swal.fire({
                        title: "{{ __('Delete Permission?') }}",
                        html: "<p>{{ __('This action will permanently delete this permission and cannot be undone.') }}</p><p class='text-danger font-weight-bold'>{{ __('Are you absolutely sure?') }}</p>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-trash mr-2"></i>{{ __("Yes, delete it!") }}',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __("Cancel") }}',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn btn-danger btn-lg px-4 mr-2',
                            cancelButton: 'btn btn-secondary btn-lg px-4'
                        },
                        buttonsStyling: false,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: '{{ __("Deleting...") }}',
                                html: '{{ __("Please wait while we delete the permission.") }}',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            form.submit();
                        }
                    });
                });
            });

            // Success message with animation
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ __('Success!') }}",
                html: "<p class='mb-0'>{{ session('success') }}</p>",
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'animated-popup'
                },
                showClass: {
                    popup: 'animate__animated animate__bounceIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut'
                }
            });
            @endif


            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: "{{ __('Error!') }}",
                html: "<p class='mb-0'>{{ session('error') }}</p>",
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: '{{ __("OK") }}',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__shakeX'
                }
            });
            @endif

            @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: "{{ __('Information') }}",
                html: "<p class='mb-0'>{{ session('info') }}</p>",
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            @endif
        });
    </script>
</x-dashboard.main-layout>
