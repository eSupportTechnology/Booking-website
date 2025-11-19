// Global Notification System
class NotificationSystem {
    constructor() {
        this.container = this.createContainer();
        this.notifications = [];
        this.init();
    }

    init() {
        this.attachGlobalErrorHandlers();
        this.exposeGlobalMethods();
    }

    createContainer() {
        const container = document.createElement('div');
        container.id = 'notification-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2 max-w-sm';
        document.body.appendChild(container);
        return container;
    }

    show(message, type = 'info', duration = 5000) {
        const notification = this.createNotification(message, type, duration);
        this.container.appendChild(notification);
        this.notifications.push(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
        }, 100);

        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                this.remove(notification);
            }, duration);
        }

        return notification;
    }

    createNotification(message, type, duration) {
        const notification = document.createElement('div');
        notification.className = `transform transition-all duration-300 translate-x-full opacity-0 ${this.getTypeClasses(type)} px-4 py-3 rounded-lg shadow-lg flex items-center justify-between max-w-sm`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${this.getIcon(type)}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
            </div>
            <button class="ml-4 flex-shrink-0 text-current hover:opacity-75 transition-opacity" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        `;

        return notification;
    }

    getTypeClasses(type) {
        const classes = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        return classes[type] || classes.info;
    }

    getIcon(type) {
        const icons = {
            success: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>`,
            error: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>`,
            warning: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>`,
            info: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>`
        };
        return icons[type] || icons.info;
    }

    remove(notification) {
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
            this.notifications = this.notifications.filter(n => n !== notification);
        }, 300);
    }

    clear() {
        this.notifications.forEach(notification => this.remove(notification));
    }

    attachGlobalErrorHandlers() {
        // Handle unhandled promise rejections
        window.addEventListener('unhandledrejection', (event) => {
            console.error('Unhandled promise rejection:', event.reason);
            this.show('Something went wrong. Please try again.', 'error');
        });

        // Handle JavaScript errors
        window.addEventListener('error', (event) => {
            console.error('JavaScript error:', event.error);
            this.show('An unexpected error occurred.', 'error');
        });

        // Handle fetch errors globally
        const originalFetch = window.fetch;
        window.fetch = async (...args) => {
            try {
                const response = await originalFetch(...args);
                
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    const message = errorData.message || `HTTP ${response.status}: ${response.statusText}`;
                    this.show(message, 'error');
                }
                
                return response;
            } catch (error) {
                this.show('Network error. Please check your connection.', 'error');
                throw error;
            }
        };
    }

    exposeGlobalMethods() {
        window.showNotification = (message, type, duration) => this.show(message, type, duration);
        window.clearNotifications = () => this.clear();
        
        // Convenience methods
        window.showSuccess = (message, duration) => this.show(message, 'success', duration);
        window.showError = (message, duration) => this.show(message, 'error', duration);
        window.showWarning = (message, duration) => this.show(message, 'warning', duration);
        window.showInfo = (message, duration) => this.show(message, 'info', duration);
    }
}

// Enhanced Error Handler for AJAX requests
class AjaxErrorHandler {
    static handle(error, customMessage = null) {
        let message = customMessage || 'An error occurred';
        
        if (error.response) {
            // Server responded with error status
            const status = error.response.status;
            const data = error.response.data;
            
            switch (status) {
                case 400:
                    message = data.message || 'Bad request';
                    break;
                case 401:
                    message = 'You are not authorized. Please log in again.';
                    setTimeout(() => window.location.href = '/partner/login', 2000);
                    break;
                case 403:
                    message = 'You do not have permission to perform this action.';
                    break;
                case 404:
                    message = 'The requested resource was not found.';
                    break;
                case 422:
                    message = data.message || 'Validation failed';
                    if (data.errors) {
                        // Show validation errors
                        Object.values(data.errors).flat().forEach(error => {
                            window.showError(error, 8000);
                        });
                        return;
                    }
                    break;
                case 500:
                    message = 'Server error. Please try again later.';
                    break;
                default:
                    message = data.message || `Error ${status}`;
            }
        } else if (error.request) {
            // Network error
            message = 'Network error. Please check your connection.';
        }
        
        window.showError(message);
    }
}

// Form Error Display Helper
class FormErrorDisplay {
    static showFieldErrors(form, errors) {
        // Clear existing errors
        form.querySelectorAll('.field-error').forEach(el => el.remove());
        form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'bg-red-50');
        });
        
        // Show new errors
        Object.keys(errors).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.classList.add('border-red-500', 'bg-red-50');
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error text-red-500 text-sm mt-1';
                errorDiv.textContent = Array.isArray(errors[fieldName]) 
                    ? errors[fieldName][0] 
                    : errors[fieldName];
                
                field.parentNode.appendChild(errorDiv);
            }
        });
    }
    
    static clearFieldErrors(form) {
        form.querySelectorAll('.field-error').forEach(el => el.remove());
        form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'bg-red-50');
        });
    }
}

// Initialize notification system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.notificationSystem = new NotificationSystem();
    window.AjaxErrorHandler = AjaxErrorHandler;
    window.FormErrorDisplay = FormErrorDisplay;
});