<x-dashboard.main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-dark mb-0">
            <i class="fas fa-edit mr-2"></i>{{ __('Edit Permission') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 font-weight-bold">{{ __('Edit Permission: ') }}<span class="text-primary">{{ $permission->name }}</span></h4>
                        <p class="text-muted mb-0">{{ __('Update permission information') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admins.permissions.index') }}" class="btn btn-secondary btn-lg shadow-sm hover-lift">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Permissions') }}
                </a>
            </div>
        </div>

        <!-- Edit Permission Form Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-warning text-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="fas fa-key mr-2"></i>{{ __('Edit Permission Information') }}
                            </h5>
                            <span class="badge badge-light badge-pill px-3 py-2">
                                <i class="fas fa-edit mr-1"></i>{{ __('Editing') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admins.permissions.update', $permission) }}" method="POST" id="permissionForm">
                            @csrf
                            @method('PUT')

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
                                               value="{{ old('name', $permission->name) }}"
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
                                            {{ __('Use kebab-case format like "resource-action".') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Permission Info -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <h6 class="font-weight-bold text-dark mb-3">
                                                <i class="fas fa-info-circle mr-2 text-primary"></i>{{ __('Permission Details') }}
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <h6 class="text-muted mb-1">{{ __('Permission ID') }}</h6>
                                                        <h4 class="font-weight-bold text-primary">#{{ $permission->id }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <h6 class="text-muted mb-1">{{ __('Guard Name') }}</h6>
                                                        <h4 class="font-weight-bold text-info">{{ $permission->guard_name }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <h6 class="text-muted mb-1">{{ __('Assigned to Roles') }}</h6>
                                                        <h4 class="font-weight-bold text-success">{{ $permission->roles->count() }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admins.permissions.index') }}" class="btn btn-secondary btn-lg shadow-sm hover-lift">
                                            <i class="fas fa-times mr-2"></i>{{ __('Cancel') }}
                                        </a>
                                        <div>
                                            <button type="button" class="btn btn-outline-danger btn-lg shadow-sm hover-lift mr-3" id="resetForm">
                                                <i class="fas fa-undo mr-2"></i>{{ __('Reset') }}
                                            </button>
                                            <button type="submit" class="btn btn-warning btn-lg shadow-sm hover-lift px-5">
                                                <i class="fas fa-save mr-2"></i>{{ __('Update Permission') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const permissionForm = document.getElementById('permissionForm');
            const resetFormBtn = document.getElementById('resetForm');
            const originalName = "{{ $permission->name }}";

            if (resetFormBtn) {
                resetFormBtn.addEventListener('click', function() {
                    document.getElementById('name').value = originalName;

                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("Form Reset") }}',
                        text: '{{ __("Form has been reset to original values.") }}',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            }


            if (permissionForm) {
                permissionForm.addEventListener('submit', function(e) {
                    const permissionName = document.getElementById('name').value.trim();

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
