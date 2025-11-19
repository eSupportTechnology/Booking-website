// Bulk Operations Manager
class BulkOperationsManager {
    constructor() {
        this.selectedProperties = new Set();
        this.init();
    }

    init() {
        this.attachEventListeners();
        this.createBulkToolbar();
    }

    attachEventListeners() {
        // Select all checkbox
        const selectAllCheckbox = document.getElementById('select-all-properties');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => {
                this.toggleSelectAll(e.target.checked);
            });
        }

        // Individual property checkboxes
        document.querySelectorAll('.property-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                this.toggleProperty(e.target.value, e.target.checked);
            });
        });
    }

    createBulkToolbar() {
        const toolbar = document.createElement('div');
        toolbar.id = 'bulk-toolbar';
        toolbar.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-4 border border-gray-200 hidden z-50';
        toolbar.innerHTML = `
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">
                    <span id="selected-count">0</span> properties selected
                </span>
                <div class="flex space-x-2">
                    <button onclick="bulkManager.showBulkModal('activate')" 
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Activate
                    </button>
                    <button onclick="bulkManager.showBulkModal('deactivate')" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                        Deactivate
                    </button>
                    <button onclick="bulkManager.showBulkModal('update_pricing')" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        Update Pricing
                    </button>
                    <button onclick="bulkManager.showBulkModal('export')" 
                            class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
                        Export
                    </button>
                    <button onclick="bulkManager.showBulkModal('delete')" 
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                        Delete
                    </button>
                </div>
                <button onclick="bulkManager.clearSelection()" 
                        class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
        document.body.appendChild(toolbar);
    }

    toggleSelectAll(checked) {
        document.querySelectorAll('.property-checkbox').forEach(checkbox => {
            checkbox.checked = checked;
            this.toggleProperty(checkbox.value, checked);
        });
    }

    toggleProperty(propertyId, selected) {
        if (selected) {
            this.selectedProperties.add(propertyId);
        } else {
            this.selectedProperties.delete(propertyId);
        }
        this.updateToolbar();
    }

    updateToolbar() {
        const toolbar = document.getElementById('bulk-toolbar');
        const countElement = document.getElementById('selected-count');
        
        if (this.selectedProperties.size > 0) {
            toolbar.classList.remove('hidden');
            countElement.textContent = this.selectedProperties.size;
        } else {
            toolbar.classList.add('hidden');
        }
    }

    clearSelection() {
        this.selectedProperties.clear();
        document.querySelectorAll('.property-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        document.getElementById('select-all-properties').checked = false;
        this.updateToolbar();
    }

    showBulkModal(action) {
        if (this.selectedProperties.size === 0) {
            window.showError('Please select at least one property');
            return;
        }

        const modal = this.createBulkModal(action);
        document.body.appendChild(modal);
    }

    createBulkModal(action) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center';
        modal.innerHTML = this.getBulkModalContent(action);
        return modal;
    }

    getBulkModalContent(action) {
        const selectedCount = this.selectedProperties.size;
        
        switch (action) {
            case 'activate':
            case 'deactivate':
            case 'delete':
                return `
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                ${action.charAt(0).toUpperCase() + action.slice(1)} Properties
                            </h3>
                            <p class="text-sm text-gray-600 mb-6">
                                Are you sure you want to ${action} ${selectedCount} selected properties?
                            </p>
                            <div class="flex justify-end space-x-3">
                                <button onclick="this.closest('.fixed').remove()" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                    Cancel
                                </button>
                                <button onclick="bulkManager.executeBulkAction('${action}'); this.closest('.fixed').remove()" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-md">
                                    ${action.charAt(0).toUpperCase() + action.slice(1)}
                                </button>
                            </div>
                        </div>
                    </div>
                `;

            case 'update_pricing':
                return `
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Pricing</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Adult Price</label>
                                    <input type="number" id="bulk-adult-price" step="0.01" min="0" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Child Price</label>
                                    <input type="number" id="bulk-child-price" step="0.01" min="0" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Commission Rate (%)</label>
                                    <input type="number" id="bulk-commission-rate" step="0.01" min="0" max="100" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3 mt-6">
                                <button onclick="this.closest('.fixed').remove()" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                    Cancel
                                </button>
                                <button onclick="bulkManager.executeBulkPricing(); this.closest('.fixed').remove()" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-md">
                                    Update Pricing
                                </button>
                            </div>
                        </div>
                    </div>
                `;

            case 'export':
                return `
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Export Properties</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                                    <select id="export-format" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option value="csv">CSV</option>
                                        <option value="json">JSON</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3 mt-6">
                                <button onclick="this.closest('.fixed').remove()" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                    Cancel
                                </button>
                                <button onclick="bulkManager.executeBulkExport(); this.closest('.fixed').remove()" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-purple-500 hover:bg-purple-600 rounded-md">
                                    Export
                                </button>
                            </div>
                        </div>
                    </div>
                `;
        }
    }

    async executeBulkAction(action) {
        try {
            const response = await fetch('/partner/properties/bulk-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    property_ids: Array.from(this.selectedProperties),
                    action: action
                })
            });

            const result = await response.json();
            if (result.success) {
                window.showSuccess(result.message);
                this.clearSelection();
                window.location.reload();
            } else {
                window.showError(result.message);
            }
        } catch (error) {
            window.showError('Failed to execute bulk action');
        }
    }

    async executeBulkPricing() {
        const adultPrice = document.getElementById('bulk-adult-price').value;
        const childPrice = document.getElementById('bulk-child-price').value;
        const commissionRate = document.getElementById('bulk-commission-rate').value;

        const data = {
            property_ids: Array.from(this.selectedProperties),
            action: 'update_pricing'
        };

        if (adultPrice) data.adult_price = parseFloat(adultPrice);
        if (childPrice) data.child_price = parseFloat(childPrice);
        if (commissionRate) data.commission_rate = parseFloat(commissionRate);

        try {
            const response = await fetch('/partner/properties/bulk-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                window.showSuccess(result.message);
                this.clearSelection();
                window.location.reload();
            } else {
                window.showError(result.message);
            }
        } catch (error) {
            window.showError('Failed to update pricing');
        }
    }

    async executeBulkExport() {
        const format = document.getElementById('export-format').value;

        try {
            const response = await fetch('/partner/properties/bulk-export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    property_ids: Array.from(this.selectedProperties),
                    format: format
                })
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `properties_export.${format}`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                window.showSuccess('Export completed successfully');
            } else {
                window.showError('Failed to export properties');
            }
        } catch (error) {
            window.showError('Failed to export properties');
        }
    }
}

// Initialize bulk operations when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.property-checkbox')) {
        window.bulkManager = new BulkOperationsManager();
    }
});