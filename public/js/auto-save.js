// Auto-save System
class AutoSave {
    constructor(options = {}) {
        this.propertyId = options.propertyId || this.getPropertyIdFromUrl();
        this.saveDelay = options.saveDelay || 2000;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        this.saveTimeout = null;
        this.lastSaved = null;
        this.isDirty = false;
        
        this.init();
    }

    init() {
        if (!this.propertyId) {
            console.warn('Auto-save: No property ID found');
            return;
        }

        this.attachListeners();
        this.createSaveIndicator();
        this.showLastSaved();
    }

    getPropertyIdFromUrl() {
        const matches = window.location.pathname.match(/\/properties\/(\d+)/);
        return matches ? matches[1] : null;
    }

    attachListeners() {
        const fields = document.querySelectorAll('input[data-autosave], textarea[data-autosave], select[data-autosave]');
        
        fields.forEach(field => {
            field.addEventListener('input', () => this.scheduleAutoSave());
            field.addEventListener('change', () => this.scheduleAutoSave());
        });

        // Save before page unload if dirty
        window.addEventListener('beforeunload', (e) => {
            if (this.isDirty) {
                this.saveNow();
                e.preventDefault();
                e.returnValue = '';
            }
        });
    }

    scheduleAutoSave() {
        this.isDirty = true;
        this.updateSaveIndicator('pending');
        
        clearTimeout(this.saveTimeout);
        this.saveTimeout = setTimeout(() => {
            this.saveNow();
        }, this.saveDelay);
    }

    async saveNow() {
        if (!this.isDirty) return;

        this.updateSaveIndicator('saving');
        
        const formData = this.collectFormData();
        
        try {
            const response = await fetch(`/partner/properties/${this.propertyId}/auto-save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            
            if (result.success) {
                this.isDirty = false;
                this.lastSaved = result.saved_at;
                this.updateSaveIndicator('saved');
                this.showLastSaved();
            } else {
                this.updateSaveIndicator('error');
                console.error('Auto-save failed:', result.message);
            }
        } catch (error) {
            this.updateSaveIndicator('error');
            console.error('Auto-save error:', error);
        }
    }

    collectFormData() {
        const data = {};
        const fields = document.querySelectorAll('input[data-autosave], textarea[data-autosave], select[data-autosave]');
        
        fields.forEach(field => {
            if (field.name && field.value !== '') {
                data[field.name] = field.value;
            }
        });
        
        return data;
    }

    createSaveIndicator() {
        if (document.getElementById('auto-save-indicator')) return;

        const indicator = document.createElement('div');
        indicator.id = 'auto-save-indicator';
        indicator.className = 'fixed top-4 left-4 z-50 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300';
        indicator.style.display = 'none';
        document.body.appendChild(indicator);
    }

    updateSaveIndicator(status) {
        const indicator = document.getElementById('auto-save-indicator');
        if (!indicator) return;

        indicator.style.display = 'block';
        
        switch (status) {
            case 'pending':
                indicator.className = 'fixed top-4 left-4 z-50 px-3 py-2 rounded-lg text-sm font-medium bg-yellow-100 text-yellow-800 transition-all duration-300';
                indicator.textContent = 'Changes pending...';
                break;
            case 'saving':
                indicator.className = 'fixed top-4 left-4 z-50 px-3 py-2 rounded-lg text-sm font-medium bg-blue-100 text-blue-800 transition-all duration-300';
                indicator.textContent = 'Saving...';
                break;
            case 'saved':
                indicator.className = 'fixed top-4 left-4 z-50 px-3 py-2 rounded-lg text-sm font-medium bg-green-100 text-green-800 transition-all duration-300';
                indicator.textContent = 'Saved';
                setTimeout(() => {
                    indicator.style.display = 'none';
                }, 2000);
                break;
            case 'error':
                indicator.className = 'fixed top-4 left-4 z-50 px-3 py-2 rounded-lg text-sm font-medium bg-red-100 text-red-800 transition-all duration-300';
                indicator.textContent = 'Save failed';
                setTimeout(() => {
                    indicator.style.display = 'none';
                }, 3000);
                break;
        }
    }

    showLastSaved() {
        if (!this.lastSaved) return;
        
        let lastSavedElement = document.getElementById('last-saved-time');
        if (!lastSavedElement) {
            lastSavedElement = document.createElement('div');
            lastSavedElement.id = 'last-saved-time';
            lastSavedElement.className = 'text-sm text-gray-500 mt-2';
            
            const form = document.querySelector('form');
            if (form) {
                form.appendChild(lastSavedElement);
            }
        }
        
        lastSavedElement.textContent = `Last saved: ${this.lastSaved}`;
    }
}

// Initialize auto-save when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('[data-autosave]')) {
        window.autoSave = new AutoSave();
    }
});