<x-dashboard.main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-dark mb-0">
            <i class="fas fa-user-shield mr-2"></i>{{ __('Roles Management') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <!-- Page Header with Stats -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 font-weight-bold">{{ __('System Roles') }}</h4>
                        <p class="text-muted mb-0">{{ __('Manage user roles and permissions') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admins.roles.create') }}" class="btn btn-primary btn-lg shadow-sm hover-lift">
                    <i class="fas fa-plus-circle mr-2"></i>{{ __('Create New Role') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-gradient p-3 mr-3">
                                <i class="fas fa-shield-alt text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Total Roles') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $roles->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-gradient p-3 mr-3">
                                <i class="fas fa-key text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Total Permissions') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $roles->sum(fn($r) => $r->permissions->count()) }}</h3>
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
                                <i class="fas fa-lock text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Protected Roles') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $roles->where('name', 'super-admin')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-list-ul mr-2"></i>{{ __('Roles List') }}
                    </h5>
                    <span class="badge badge-light badge-pill px-3 py-2">
                        {{ $roles->count() }} {{ __('Roles') }}
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
                            <th scope="col" class="border-0 px-4 py-3" style="width: 25%">
                                <span class="text-muted font-weight-bold">{{ __('Role Name') }}</span>
                            </th>
                            <th scope="col" class="border-0 px-4 py-3">
                                <span class="text-muted font-weight-bold">{{ __('Permissions') }}</span>
                            </th>
                            <th scope="col" class="border-0 px-4 py-3 text-center" style="width: 15%">
                                <span class="text-muted font-weight-bold">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                            <tr class="role-row">
                                <td class="px-4 py-3">
                                    <span class="badge badge-secondary badge-pill">{{ $role->id }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white mr-3">
                                            {{ strtoupper(substr($role->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold text-capitalize">{{ $role->name }}</h6>
                                            @if($role->name === 'super-admin')
                                                <small class="text-danger">
                                                    <i class="fas fa-crown mr-1"></i>{{ __('Protected Role') }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($role->permissions->isNotEmpty())
                                        <div class="permissions-wrapper">
                                            @foreach($role->permissions as $index => $permission)
                                                @if($index < 5)
                                                    <span class="badge badge-info badge-pill mb-1 mr-1 permission-badge">
                                                        <i class="fas fa-check-circle mr-1"></i>{{ $permission->name }}
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if($role->permissions->count() > 5)
                                                <span class="badge badge-dark badge-pill mb-1 permission-badge"
                                                      data-toggle="tooltip"
                                                      title="{{ $role->permissions->skip(5)->pluck('name')->implode(', ') }}">
                                                    +{{ $role->permissions->count() - 5 }} {{ __('more') }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ __('No permissions assigned') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admins.roles.edit', $role) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           data-toggle="tooltip"
                                           title="{{ __('Edit Role') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        @if($role->name !== 'super-admin')
                                            <form action="{{ route('admins.roles.destroy', $role) }}"
                                                  method="POST"
                                                  class="d-inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-delete"
                                                        data-toggle="tooltip"
                                                        title="{{ __('Delete Role') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    disabled
                                                    data-toggle="tooltip"
                                                    title="{{ __('Cannot delete protected role') }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">{{ __('No roles found') }}</h5>
                                        <p class="text-muted">{{ __('Create your first role to get started') }}</p>
                                        <a href="{{ route('admins.roles.create') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus mr-2"></i>{{ __('Create Role') }}
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
            .bg-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .hover-lift {
                transition: all 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
            }

            .role-row {
                transition: all 0.2s ease;
            }

            .role-row:hover {
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

            .permission-badge {
                font-size: 0.75rem;
                padding: 0.35em 0.65em;
                transition: all 0.2s ease;
            }

            .permission-badge:hover {
                transform: scale(1.05);
            }

            .permissions-wrapper {
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
                            title: "{{ __('Delete Role?') }}",
                            html: "<p>{{ __('This action will permanently delete this role and cannot be undone.') }}</p><p class='text-danger font-weight-bold'>{{ __('Are you absolutely sure?') }}</p>",
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
                                    html: '{{ __("Please wait while we delete the role.") }}',
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

                // Error message with animation
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

                // Info message
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
