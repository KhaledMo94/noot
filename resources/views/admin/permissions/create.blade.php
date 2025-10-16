<x-dashboard.main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-dark mb-0">
            <i class="fas fa-plus-circle mr-2"></i>{{ __('Create New Permission') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <!-- Page Header with Stats -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 font-weight-bold">{{ __('Create New Permission') }}</h4>
                        <p class="text-muted mb-0">{{ __('Add a new permission to the system') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admins.permissions.index') }}" class="btn btn-secondary btn-lg shadow-sm hover-lift">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Permissions') }}
                </a>
            </div>
        </div>

        <!-- Create Permission Form Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-info text-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="fas fa-key mr-2"></i>{{ __('Permission Information') }}
                            </h5>
                            <span class="badge badge-light badge-pill px-3 py-2">
                                <i class="fas fa-plus-circle mr-1"></i>{{ __('New Permission') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admins.permissions.store') }}" method="POST" id="permissionForm">
                            @csrf

                            <!-- Permission Name Section -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label font-weight-bold text-dark h6">
                                            <i class="fas fa-tag mr-2 text-primary"></i>{{ __('Permission Name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="name"
                                               id="name"
                                               value="{{ old('name') }}"
                                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                                               placeholder="e.g., user-create, post-edit, category-delete"
                                               required
                                               autofocus
                                               autocomplete="off">
                                        @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-lightbulb mr-1 text-warning"></i>
                                            {{ __('Use kebab-case format like "resource-action". Examples: user-create, post-edit, category-delete, settings-view') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Permission Examples -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <h6 class="font-weight-bold text-dark mb-3">
                                                <i class="fas fa-list-alt mr-2 text-primary"></i>{{ __('Common Permission Patterns') }}
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2">
                                                            <span class="badge badge-success badge-pill mr-2">create</span>
                                                            <small class="text-muted">user-create, post-create</small>
                                                        </li>
                                                        <li class="mb-2">
                                                            <span class="badge badge-info badge-pill mr-2">view</span>
                                                            <small class="text-muted">user-view, settings-view</small>
                                                        </li>
                                                        <li class="mb-2">
                                                            <span class="badge badge-warning badge-pill mr-2">edit</span>
                                                            <small class="text-muted">user-edit, post-edit</small>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2">
                                                            <span class="badge badge-danger badge-pill mr-2">delete</span>
                                                            <small class="text-muted">user-delete, category-delete</small>
                                                        </li>
                                                        <li class="mb-2">
                                                            <span class="badge badge-primary badge-pill mr-2">list</span>
                                                            <small class="text-muted">user-list, post-list</small>
                                                        </li>
                                                        <li class="mb-2">
                                                            <span class="badge badge-secondary badge-pill mr-2">manage</span>
                                                            <small class="text-muted">settings-manage, system-manage</small>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admins.permissions.index') }}" class="btn btn-secondary btn-lg shadow-sm hover-lift">
                                            <i class="fas fa-times mr-2"></i>{{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-info btn-lg shadow-sm hover-lift px-5">
                                            <i class="fas fa-save mr-2"></i>{{ __('Create Permission') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }

        .form-control-lg {
            border-radius: 0.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
    </style>

    {{-- JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const permissionForm = document.getElementById('permissionForm');
            const nameInput = document.getElementById('name');

            // Form submission handling
            if (permissionForm) {
                permissionForm.addEventListener('submit', function(e) {
                    const permissionName = nameInput.value.trim();

                    if (!permissionName) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Validation Error") }}',
                            text: '{{ __("Please enter a permission name") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        });
                        return;
                    }

                    // Permission name format validation
                    const permissionNameRegex = /^[a-z-]+$/;
                    if (!permissionNameRegex.test(permissionName)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Invalid Permission Name") }}',
                            text: '{{ __("Permission name can only contain lowercase letters and hyphens.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        });
                        return;
                    }
                });
            }

            // Success/Error message handling
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ __("Success!") }}',
                text: '{{ session("success") }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            @endif

            @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: '{{ __("Validation Error") }}',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: '{{ __("OK") }}'
            });
            @endif
        });
    </script>
</x-dashboard.main-layout>
