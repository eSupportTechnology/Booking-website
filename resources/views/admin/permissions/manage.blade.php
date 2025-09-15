@extends('admin.master')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-user-shield mr-3"></i>
                        Manage Permissions
                    </h1>
                    <p class="text-blue-100 mt-1">Configure access rights for <span class="font-semibold">{{ $admin->username }}</span></p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-blue-100">Admin Status</div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ ucfirst($admin->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Permission Summary -->
        <div class="bg-gray-50 p-4 border-b">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span id="permission-count">{{ count($adminPermissions) }} permissions currently assigned</span>
                </div>
                <div class="flex space-x-2">
                    <button type="button" id="select-all-btn" class="px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
                        <i class="fas fa-check-double mr-1"></i> Select All
                    </button>
                    <button type="button" id="clear-all-btn" class="px-3 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600">
                        <i class="fas fa-times mr-1"></i> Clear All
                    </button>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.permissions.update', $admin) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($permissions as $category => $categoryPermissions)
                <div class="permission-category bg-gray-50 rounded-lg p-4 border">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            @if($category === 'Dashboard')
                                <i class="fas fa-tachometer-alt mr-2 text-blue-500"></i>
                            @elseif($category === 'Users')
                                <i class="fas fa-users mr-2 text-green-500"></i>
                            @elseif($category === 'Property')
                                <i class="fas fa-building mr-2 text-purple-500"></i>
                            @elseif($category === 'Rental')
                                <i class="fas fa-car mr-2 text-orange-500"></i>
                            @elseif($category === 'Admin Management')
                                <i class="fas fa-user-shield mr-2 text-red-500"></i>
                            @else
                                <i class="fas fa-cog mr-2 text-gray-500"></i>
                            @endif
                            {{ $category }}
                        </h3>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="category-toggle sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-2 text-xs text-gray-600">Toggle All</span>
                        </label>
                    </div>
                    
                    <div class="space-y-2">
                        @foreach($categoryPermissions as $permission)
                        <label class="flex items-center p-2 rounded hover:bg-white transition-colors cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" 
                                       name="permissions[]" 
                                       value="{{ $permission->name }}"
                                       class="permission-checkbox sr-only peer"
                                       {{ in_array($permission->name, $adminPermissions) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $permission->name }}
                                </div>
                            </div>
                            @if(in_array($permission->name, $adminPermissions))
                                <span class="text-green-500 text-xs">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                <a href="{{ route('admin.accounts.index') }}" class="flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Admin Accounts
                </a>
                <button type="submit" class="flex items-center px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i> Update Permissions
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const permissionCount = document.getElementById('permission-count');
    const selectAllBtn = document.getElementById('select-all-btn');
    const clearAllBtn = document.getElementById('clear-all-btn');
    
    function updateCount() {
        const checkedCount = document.querySelectorAll('.permission-checkbox:checked').length;
        permissionCount.textContent = `${checkedCount} permissions currently assigned`;
    }
    
    // Initialize category toggle states
    function initializeCategoryToggles() {
        document.querySelectorAll('.permission-category').forEach(category => {
            const categoryToggle = category.querySelector('.category-toggle');
            const categoryCheckboxes = category.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(categoryCheckboxes).every(checkbox => checkbox.checked);
            categoryToggle.checked = allChecked;
        });
    }
    
    initializeCategoryToggles();
    
    // Select/Clear all functionality
    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(cb => cb.checked = true);
        document.querySelectorAll('.category-toggle').forEach(toggle => toggle.checked = true);
        updateCount();
    });
    
    clearAllBtn.addEventListener('click', function() {
        checkboxes.forEach(cb => cb.checked = false);
        document.querySelectorAll('.category-toggle').forEach(toggle => toggle.checked = false);
        updateCount();
    });
    
    // Category toggle functionality
    document.querySelectorAll('.category-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const category = this.closest('.permission-category');
            const categoryCheckboxes = category.querySelectorAll('.permission-checkbox');
            
            categoryCheckboxes.forEach(cb => cb.checked = this.checked);
            updateCount();
        });
    });
    
    // Update count on individual checkbox change and sync category toggles
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            updateCount();
            
            // Update category toggle state
            const category = this.closest('.permission-category');
            const categoryToggle = category.querySelector('.category-toggle');
            const categoryCheckboxes = category.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(categoryCheckboxes).every(checkbox => checkbox.checked);
            const anyChecked = Array.from(categoryCheckboxes).some(checkbox => checkbox.checked);
            
            categoryToggle.checked = allChecked;
        });
    });
});
</script>
@endsection