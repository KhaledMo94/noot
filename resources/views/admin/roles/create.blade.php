<x-dashboard.main-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-dark mb-0">
            <i class="fas fa-plus-circle mr-2"></i>{{ __('Create New Role') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <!-- Page Header with Stats -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-plus fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-1 font-weight-bold">{{ __('Create New Role') }}</h4>
                        <p class="text-muted mb-0">{{ __('Add a new role to the system with specific permissions') }}</p>
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
            <div class="col-md-4">
                <div class="card border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-gradient p-3 mr-3">
                                <i class="fas fa-shield-alt text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('Total Roles') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ \Spatie\Permission\Models\Role::count() }}</h3>
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
                                <h6 class="text-muted mb-1">{{ __('Available Permissions') }}</h6>
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
                                <i class="fas fa-cogs text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">{{ __('System Roles') }}</h6>
                                <h3 class="mb-0 font-weight-bold">{{ \Spatie\Permission\Models\Role::where('name', '!=', 'super-admin')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Role Form Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-success text-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-weight-bold">
                                <i class="fas fa-user-shield mr-2"></i>{{ __('Role Information') }}
                            </h5>
                            <span class="badge badge-light badge-pill px-3 py-2">
                                <i class="fas fa-plus-circle mr-1"></i>{{ __('New Role') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('admins.roles.store') }}" method="POST" id="roleForm">
                            @csrf

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
                                               value="{{ old('name') }}"
                                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                                               placeholder="e.g., content-manager, moderator, editor"
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
                                            {{ __('Use descriptive names like "content-manager", "moderator", or "editor". Avoid spaces and special characters.') }}
                                        </small>
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
                                            </label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAllPermissions">
                                                <label class="form-check-label text-muted font-weight-bold" for="selectAllPermissions">
                                                    {{ __('Select All Permissions') }}
                                                </label>
                                            </div>
                                        </div>

                                        @if($permissions->count() > 0)
                                            <!-- Permission Search and Filter -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="input-group input-group-lg">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-light border-0">
                                                                    <i class="fas fa-search text-muted"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text"
                                                                   id="permissionSearch"
                                                                   class="form-control border-0 bg-light"
                                                                   placeholder="{{ __('Search permissions...') }}"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-end align-items-center h-100">
                                                        <span class="badge badge-primary badge-pill px-3 py-2 mr-3">
                                                            <span id="selectedCount">0</span> {{ __('selected') }}
                                                        </span>
                                                        <span class="badge badge-info badge-pill px-3 py-2">
                                                            <span id="totalCount">{{ $permissions->count() }}</span> {{ __('total') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Permissions Table -->
                                            <div class="card border-0 bg-light">
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0 align-middle" id="permissionsTable">
                                                            <thead class="bg-dark text-white">
                                                            <tr>
                                                                <th scope="col" class="border-0 px-4 py-3 text-center" style="width: 5%">
                                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                                </th>
                                                                <th scope="col" class="border-0 px-4 py-3" style="width: 35%">
                                                                    <span class="font-weight-bold">{{ __('Permission Name') }}</span>
                                                                </th>
                                                                <th scope="col" class="border-0 px-4 py-3" style="width: 45%">
                                                                    <span class="font-weight-bold">{{ __('Description') }}</span>
                                                                </th>
                                                                <th scope="col" class="border-0 px-4 py-3 text-center" style="width: 15%">
                                                                    <span class="font-weight-bold">{{ __('Type') }}</span>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($permissions as $permission)
                                                                <tr class="permission-row" data-permission-name="{{ strtolower($permission->name) }}">
                                                                    <td class="px-4 py-3 text-center">
                                                                        <input type="checkbox"
                                                                               name="permissions[]"
                                                                               value="{{ $permission->id }}"
                                                                               id="permission_{{ $permission->id }}"
                                                                               class="form-check-input permission-checkbox">
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <label for="permission_{{ $permission->id }}" class="mb-0 font-weight-bold text-dark cursor-pointer">
                                                                            <code class="permission-name">{{ $permission->name }}</code>
                                                                        </label>
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <span class="text-muted permission-description">
                                                                            {{ __(ucfirst(str_replace('-', ' ', $permission->name)) . ' permission') }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="px-4 py-3 text-center">
                                                                        @php
                                                                            $permissionType = 'custom';
                                                                            if (str_contains($permission->name, 'create')) $permissionType = 'create';
                                                                            elseif (str_contains($permission->name, 'edit') || str_contains($permission->name, 'update')) $permissionType = 'edit';
                                                                            elseif (str_contains($permission->name, 'delete') || str_contains($permission->name, 'destroy')) $permissionType = 'delete';
                                                                            elseif (str_contains($permission->name, 'view') || str_contains($permission->name, 'list') || str_contains($permission->name, 'read')) $permissionType = 'view';
                                                                        @endphp
                                                                        <span class="badge badge-{{ $permissionType === 'create' ? 'success' : ($permissionType === 'edit' ? 'warning' : ($permissionType === 'delete' ? 'danger' : ($permissionType === 'view' ? 'info' : 'secondary'))) }} badge-pill px-3 py-2">
                                                                            <i class="fas fa-{{ $permissionType === 'create' ? 'plus' : ($permissionType === 'edit' ? 'edit' : ($permissionType === 'delete' ? 'trash' : ($permissionType === 'view' ? 'eye' : 'cog'))) }} mr-1"></i>
                                                                            {{ __(ucfirst($permissionType)) }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quick Selection Buttons -->
{{--                                            <div class="row mt-4">--}}
{{--                                                <div class="col-12">--}}
{{--                                                    <div class="card border-0 bg-light">--}}
{{--                                                        <div class="card-body">--}}
{{--                                                            <h6 class="font-weight-bold text-dark mb-3">--}}
{{--                                                                <i class="fas fa-bolt mr-2 text-warning"></i>{{ __('Quick Selection') }}--}}
{{--                                                            </h6>--}}
{{--                                                            <div class="d-flex flex-wrap gap-2">--}}
{{--                                                                <button type="button" class="btn btn-outline-primary btn-sm quick-select" data-type="view">--}}
{{--                                                                    <i class="fas fa-eye mr-1"></i>{{ __('All View Permissions') }}--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-outline-success btn-sm quick-select" data-type="create">--}}
{{--                                                                    <i class="fas fa-plus mr-1"></i>{{ __('All Create Permissions') }}--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-outline-warning btn-sm quick-select" data-type="edit">--}}
{{--                                                                    <i class="fas fa-edit mr-1"></i>{{ __('All Edit Permissions') }}--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-outline-danger btn-sm quick-select" data-type="delete">--}}
{{--                                                                    <i class="fas fa-trash mr-1"></i>{{ __('All Delete Permissions') }}--}}
{{--                                                                </button>--}}
{{--                                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelection">--}}
{{--                                                                    <i class="fas fa-times mr-1"></i>{{ __('Clear All') }}--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        @else
                                            <!-- No Permissions Available -->
                                            <div class="text-center py-5 bg-light rounded-lg">
                                                <i class="fas fa-key fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">{{ __('No Permissions Available') }}</h5>
                                                <p class="text-muted">{{ __('Please create some permissions first to assign to roles.') }}</p>
                                                <a href="{{ route('admins.permissions.create') }}" class="btn btn-primary mt-3">
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
                                        <button type="submit" class="btn btn-success btn-lg shadow-sm hover-lift px-5" id="submitBtn">
                                            <i class="fas fa-save mr-2"></i>{{ __('Create Role') }}
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
            transform: translateX(5px);
        }

        .permission-row.hidden {
            display: none;
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
            font-family: 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', monospace;
        }

        .permission-checkbox:checked + label code {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }

        .quick-select {
            transition: all 0.2s ease;
        }

        .quick-select:hover {
            transform: translateY(-2px);
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>

    {{-- JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const selectAll = document.getElementById('selectAll');
            const selectAllPermissions = document.getElementById('selectAllPermissions');
            const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            const permissionSearch = document.getElementById('permissionSearch');
            const permissionsTable = document.getElementById('permissionsTable');
            const selectedCountElement = document.getElementById('selectedCount');
            const totalCountElement = document.getElementById('totalCount');
            const quickSelectButtons = document.querySelectorAll('.quick-select');
            const clearSelectionBtn = document.getElementById('clearSelection');
            const roleForm = document.getElementById('roleForm');
            const submitBtn = document.getElementById('submitBtn');

            // Initialize counters
            function updateCounters() {
                const selectedCount = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;
                const visibleCount = Array.from(permissionsTable.querySelectorAll('.permission-row:not(.hidden)')).length;

                if (selectedCountElement) {
                    selectedCountElement.textContent = selectedCount;
                }

                if (totalCountElement) {
                    totalCountElement.textContent = visibleCount;
                }
            }

            // Select All functionality
            function setupSelectAll() {
                // Table select all
                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        const visibleCheckboxes = Array.from(permissionsTable.querySelectorAll('.permission-row:not(.hidden) .permission-checkbox'));
                        visibleCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        updateSelectAllState();
                        updateCounters();
                    });
                }

                // Header select all
                if (selectAllPermissions) {
                    selectAllPermissions.addEventListener('change', function() {
                        permissionCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        if (selectAll) selectAll.checked = this.checked;
                        updateCounters();
                    });
                }

                // Individual checkbox change
                permissionCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectAllState();
                        updateCounters();
                    });
                });
            }

            // Update select all checkbox state
            function updateSelectAllState() {
                const visibleCheckboxes = Array.from(permissionsTable.querySelectorAll('.permission-row:not(.hidden) .permission-checkbox'));
                const allChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(checkbox => checkbox.checked);
                const someChecked = visibleCheckboxes.some(checkbox => checkbox.checked);

                if (selectAll) {
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = someChecked && !allChecked;
                }

                if (selectAllPermissions) {
                    selectAllPermissions.checked = allChecked;
                    selectAllPermissions.indeterminate = someChecked && !allChecked;
                }
            }

            // Search functionality
            function setupSearch() {
                if (permissionSearch && permissionsTable) {
                    permissionSearch.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase().trim();
                        const rows = permissionsTable.querySelectorAll('.permission-row');

                        rows.forEach(row => {
                            const permissionName = row.getAttribute('data-permission-name');
                            const permissionCode = row.querySelector('.permission-name').textContent.toLowerCase();
                            const permissionDescription = row.querySelector('.permission-description').textContent.toLowerCase();

                            const matches = permissionName.includes(searchTerm) ||
                                permissionCode.includes(searchTerm) ||
                                permissionDescription.includes(searchTerm);

                            if (matches || searchTerm === '') {
                                row.classList.remove('hidden');
                            } else {
                                row.classList.add('hidden');
                            }
                        });

                        updateSelectAllState();
                        updateCounters();
                    });
                }
            }

            // Quick selection buttons
            function setupQuickSelection() {
                quickSelectButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const type = this.getAttribute('data-type');
                        const visibleRows = Array.from(permissionsTable.querySelectorAll('.permission-row:not(.hidden)'));

                        visibleRows.forEach(row => {
                            const badge = row.querySelector('.badge');
                            if (badge) {
                                const badgeText = badge.textContent.toLowerCase();
                                if (badgeText.includes(type)) {
                                    const checkbox = row.querySelector('.permission-checkbox');
                                    if (checkbox) {
                                        checkbox.checked = true;
                                    }
                                }
                            }
                        });

                        updateSelectAllState();
                        updateCounters();

                        // Show feedback
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("Permissions Selected") }}',
                            text: `{{ __("All") }} ${type} {{ __("permissions have been selected.") }}`,
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    });
                });

                // Clear selection
                if (clearSelectionBtn) {
                    clearSelectionBtn.addEventListener('click', function() {
                        permissionCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                        });
                        updateSelectAllState();
                        updateCounters();

                        Swal.fire({
                            icon: 'info',
                            title: '{{ __("Selection Cleared") }}',
                            text: '{{ __("All permission selections have been cleared.") }}',
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    });
                }
            }

            // Form submission handling
            function setupFormSubmission() {
                if (roleForm) {
                    roleForm.addEventListener('submit', function(e) {
                        const roleName = document.getElementById('name').value.trim();
                        const selectedPermissions = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;

                        // Validation
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

                        // Role name format validation
                        const roleNameRegex = /^[a-z0-9-]+$/;
                        if (!roleNameRegex.test(roleName)) {
                            e.preventDefault();
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("Invalid Role Name") }}',
                                text: '{{ __("Role name can only contain lowercase letters, numbers, and hyphens.") }}',
                                confirmButtonText: '{{ __("OK") }}'
                            });
                            return;
                        }

                        // Show loading state
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __("Creating Role...") }}';
                            submitBtn.disabled = true;
                        }

                        // Optional: Show confirmation for many permissions
                        if (selectedPermissions > 10) {
                            e.preventDefault();
                            Swal.fire({
                                title: '{{ __("Confirm Role Creation") }}',
                                html: `You are about to create a new role "<strong>${roleName}</strong>" with <strong>${selectedPermissions}</strong> permissions.<br><br>Are you sure you want to continue?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#28a745',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: '<i class="fas fa-check mr-2"></i>{{ __("Yes, create it!") }}',
                                cancelButtonText: '<i class="fas fa-times mr-2"></i>{{ __("Review") }}',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    roleForm.submit();
                                } else {
                                    if (submitBtn) {
                                        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>{{ __("Create Role") }}';
                                        submitBtn.disabled = false;
                                    }
                                }
                            });
                        }
                    });
                }
            }

            // Role name suggestions
            function setupRoleNameSuggestions() {
                const nameInput = document.getElementById('name');
                const suggestions = ['content-manager', 'moderator', 'editor', 'author', 'contributor', 'viewer'];

                if (nameInput) {
                    nameInput.addEventListener('focus', function() {
                        if (!this.value) {
                            this.setAttribute('placeholder', 'e.g., ' + suggestions.join(', '));
                        }
                    });
                }
            }

            // Initialize everything
            function init() {
                setupSelectAll();
                setupSearch();
                setupQuickSelection();
                setupFormSubmission();
                setupRoleNameSuggestions();
                updateCounters();
            }

            // Run initialization
            init();

            // Success/Error message handling
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
                confirmButtonText: '{{ __("OK") }}'
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
