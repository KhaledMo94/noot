<x-dashboard.main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-dark mb-0">
            <i class="fas fa-edit mr-2"></i>{{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <!-- Page Header with Stats -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-edit fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 font-weight-bold">{{ __('Edit Role: ') }}<span class="text-primary">{{ $role->name }}</span></h4>
                        <p class="text-muted mb-0">{{ __('Update role information and permissions') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admins.roles.index') }}" class="btn btn-secondary btn-lg shadow-sm hover-lift">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Roles') }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-gradient p-3 mr-3">
                                <i class="fas fa-shield-alt text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Role ID') }}</h6>
                                <h3 class="mb-0 font-weight-bold">#{{ $role->id }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-gradient p-3 mr-3">
                                <i class="fas fa-key text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Current Permissions') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $role->permissions->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-gradient p-3 mr-3">
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Users Assigned') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ $role->users()->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-gradient p-3 mr-3">
                                <i class="fas fa-calendar text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Last Updated') }}</h6>
                                <h6 class="mb-0 font-weight-bold">{{ $role->updated_at->format('M d, Y') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Role Form Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-warning text-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="fas fa-user-shield mr-2"></i>{{ __('Edit Role Information') }}
                            </h5>
                            <span class="badge badge-light badge-pill px-3 py-2">
                                <i class="fas fa-edit mr-1"></i>{{ __('Editing') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admins.roles.update', $role) }}" method="POST" id="roleForm">
                            @csrf
                            @method('PUT')

                            <!-- Role Name Section -->
                            <div class="row mb-5">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label font-weight-bold text-dark h6">
                                            <i class="fas fa-tag mr-2 text-primary"></i>{{ __('Role Name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="name"
                                               id="name"
                                               value="{{ old('name', $role->name) }}"
                                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                                               placeholder="e.g., content-manager, moderator, editor"
                                               required
                                               autofocus
                                            {{ $role->name === 'super-admin' ? 'readonly' : '' }}>
                                        @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                        @if($role->name === 'super-admin')
                                            <small class="form-text text-warning mt-2">
                                                <i class="fas fa-lock mr-1"></i>
                                                {{ __('This is a protected system role. The name cannot be changed.') }}
                                            </small>
                                        @else
                                            <small class="form-text text-muted mt-2">
                                                <i class="fas fa-lightbulb mr-1 text-warning"></i>
                                                {{ __('Use descriptive names without spaces or special characters.') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions Section -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="permissions-section">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <label class="form-label font-weight-bold text-dark h6 mb-0">
                                                <i class="fas fa-key mr-2 text-primary"></i>{{ __('Role Permissions') }}
                                                <span class="badge badge-primary ml-2">{{ $role->permissions->count() }} {{ __('assigned') }}</span>
                                            </label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                                                <label class="form-check-label text-muted font-weight-bold" for="selectAllPermissions">
                                                    {{ __('Select All Permissions') }}
                                                </label>
                                            </div>
                                        </div>

                                        @if($permissions->count() > 0)
                                            <div class="card border-0 bg-light">
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0 align-middle">
                                                            <thead class="bg-dark text-white">
                                                            <tr>
                                                                <th scope="col" class="border-0 px-4 py-3 text-center" style="width: 5%">
                                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                                </th>
                                                                <th scope="col" class="border-0 px-4 py-3" style="width: 30%">
                                                                    <span class="font-weight-bold">{{ __('Permission') }}</span>
                                                                </th>
                                                                <th scope="col" class="border-0 px-4 py-3" style="width: 40%">
                                                                    <span class="font-weight-bold">{{ __('Description') }}</span>
                                                                </th>
                                                                <th scope="col" class="border-0 px-4 py-3 text-center" style="width: 25%">
                                                                    <span class="font-weight-bold">{{ __('Status') }}</span>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($permissions as $permission)
                                                                <tr class="permission-row">
                                                                    <td class="px-4 py-3 text-center">
                                                                        <input type="checkbox"
                                                                               name="permissions[]"
                                                                               value="{{ $permission->id }}"
                                                                               id="permission_{{ $permission->id }}"
                                                                               class="form-check-input permission-checkbox"
                                                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <label for="permission_{{ $permission->id }}" class="mb-0 font-weight-bold text-dark cursor-pointer">
                                                                            <code>{{ $permission->name }}</code>
                                                                        </label>
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <span class="text-muted">
                                                                            {{ __(ucfirst(str_replace('-', ' ', $permission->name)) . ' permission') }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="px-4 py-3 text-center">
                                                                        @if(in_array($permission->id, $rolePermissions))
                                                                            <span class="badge badge-success badge-pill px-3 py-2">
                                                                                <i class="fas fa-check-circle mr-1"></i>{{ __('Assigned') }}
                                                                            </span>
                                                                        @else
                                                                            <span class="badge badge-secondary badge-pill px-3 py-2">
                                                                                <i class="fas fa-times-circle mr-1"></i>{{ __('Not Assigned') }}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Permission Summary -->
                                            <div class="row mt-4">
                                                <div class="col-md-4">
                                                    <div class="card bg-primary text-white">
                                                        <div class="card-body text-center py-3">
                                                            <h4 class="mb-0 font-weight-bold" id="selectedCount">0</h4>
                                                            <small>{{ __('Selected Permissions') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body text-center py-3">
                                                            <h4 class="mb-0 font-weight-bold" id="assignedCount">{{ $role->permissions->count() }}</h4>
                                                            <small>{{ __('Currently Assigned') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card bg-info text-white">
                                                        <div class="card-body text-center py-3">
                                                            <h4 class="mb-0 font-weight-bold" id="totalCount">{{ $permissions->count() }}</h4>
                                                            <small>{{ __('Total Available') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-5 bg-light rounded-lg">
                                                <i class="fas fa-key fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">{{ __('No Permissions Available') }}</h5>
                                                <p class="text-muted">{{ __('Please create some permissions first') }}</p>
                                                <a href="{{ route('permissions.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus mr-2"></i>{{ __('Create Permission') }}
                                                </a>
                                            </div>
                                        @endif
                                        @error('permissions')
                                        <div class="invalid-feedback d-block mt-2">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admins.roles.index') }}" class="btn btn-secondary btn-lg shadow-sm hover-lift">
                                            <i class="fas fa-times mr-2"></i>{{ __('Cancel') }}
                                        </a>
                                        <div>
                                            <button type="button" class="btn btn-outline-danger btn-lg shadow-sm hover-lift mr-3" id="resetForm">
                                                <i class="fas fa-undo mr-2"></i>{{ __('Reset Changes') }}
                                            </button>
                                            <button type="submit" class="btn btn-warning btn-lg shadow-sm hover-lift px-5">
                                                <i class="fas fa-save mr-2"></i>{{ __('Update Role') }}
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

        .permission-row {
            transition: all 0.2s ease;
        }

        .permission-row:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .permissions-section {
            border-radius: 0.5rem;
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

        .form-control-lg:read-only {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #6c757d;
        }

        .table th {
            border-top: none;
            font-weight: 600;
        }

        code {
            background-color: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
            color: #e83e8c;
        }

        .permission-checkbox:checked + label code {
            background-color: #d4edda;
            color: #155724;
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const selectAll = document.getElementById('selectAll');
            const selectAllPermissions = document.getElementById('selectAllPermissions');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            const selectedCountElement = document.getElementById('selectedCount');
            const assignedCountElement = document.getElementById('assignedCount');


            function updateSelectedCount() {
                const selectedCount = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;
                if (selectedCountElement) {
                    selectedCountElement.textContent = selectedCount;
                }
            }


            function setupSelectAll() {

                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        permissionCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        updateSelectAllPermissions();
                        updateSelectedCount();
                    });
                }


                if (selectAllPermissions) {
                    selectAllPermissions.addEventListener('change', function() {
                        permissionCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        if (selectAll) selectAll.checked = this.checked;
                        updateSelectedCount();
                    });
                }


                permissionCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectAllPermissions();
                        updateSelectedCount();
                    });
                });
            }


            function updateSelectAllPermissions() {
                const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
                const someChecked = Array.from(permissionCheckboxes).some(checkbox => checkbox.checked);

                if (selectAll) selectAll.checked = allChecked;
                if (selectAllPermissions) {
                    selectAllPermissions.checked = allChecked;
                    selectAllPermissions.indeterminate = someChecked && !allChecked;
                }
            }

            function setupFormReset() {
                const resetForm = document.getElementById('resetForm');
                const originalFormData = new FormData(document.getElementById('roleForm'));

                if (resetForm) {
                    resetForm.addEventListener('click', function() {
                        Swal.fire({
                            title: '{{ __("Reset Changes?") }}',
                            text: '{{ __("This will reset all changes you made to the original values.") }}',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fas fa-undo mr-2"></i>{{ __("Yes, reset!") }}',
                            cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __("Cancel") }}',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {

                                permissionCheckboxes.forEach(checkbox => {
                                    const permissionId = checkbox.value;
                                    checkbox.checked = {{ $role->permissions->pluck('id') }}.includes(parseInt(permissionId));
                                });

                                // Reset select all states
                                updateSelectAllPermissions();
                                updateSelectedCount();


                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __("Reset!") }}',
                                    text: '{{ __("Form has been reset to original values.") }}',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    });
                }
            }

            function setupFormSubmission() {
                const roleForm = document.getElementById('roleForm');

                if (roleForm) {
                    roleForm.addEventListener('submit', function(e) {
                        const roleName = document.getElementById('name').value.trim();
                        const selectedPermissions = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;


                        if (!roleName) {
                            e.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("Validation Error") }}',
                                text: '{{ __("Please enter a role name") }}',
                                confirmButtonText: '{{ __("OK") }}'
                            });
                            return;
                        }

                        const submitBtn = roleForm.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __("Updating Role...") }}';
                            submitBtn.disabled = true;
                        }

                        const currentAssigned = {{ $role->permissions->count() }};
                        if (Math.abs(selectedPermissions - currentAssigned) > 5) {
                            e.preventDefault();
                            Swal.fire({
                                title: '{{ __("Confirm Permission Changes") }}',
                                html: `You are changing from <strong>${currentAssigned}</strong> to <strong>${selectedPermissions}</strong> permissions.<br><br>Are you sure you want to continue?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<i class="fas fa-check mr-2"></i>{{ __("Yes, update!") }}',
                                cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __("Review") }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    roleForm.submit();
                                } else {
                                    if (submitBtn) {
                                        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>{{ __("Update Role") }}';
                                        submitBtn.disabled = false;
                                    }
                                }
                            });
                        }
                    });
                }
            }

            function init() {
                setupSelectAll();
                setupFormReset();
                setupFormSubmission();
                updateSelectedCount();
                updateSelectAllPermissions();
            }

            init();

            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ __("Success!") }}',
                text: '{{ session("success") }}',
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ __("Error!") }}',
                text: '{{ session("error") }}',
                confirmButtonText: '{{ __("OK") }}',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
            @endif

            @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: '{{ __("Validation Error") }}',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: '{{ __("OK") }}',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
            @endif
        });
    </script>
</x-dashboard.main-layout>
