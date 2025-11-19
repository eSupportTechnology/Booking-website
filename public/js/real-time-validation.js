// Real-time Form Validation System
class FormValidator {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        this.init();
    }

    init() {
        this.attachValidationListeners();
        this.attachFormSubmitValidation();
    }

    attachValidationListeners() {
        document.querySelectorAll('input[data-validate], textarea[data-validate], select[data-validate]').forEach(input => {
            input.addEventListener('blur', (e) => this.validateField(e.target));
            input.addEventListener('input', (e) => this.clearFieldError(e.target));
        });
    }

    async validateField(field) {
        if (!field.value.trim() && !field.hasAttribute('required')) return;

        try {
            const response = await fetch('/partner/validate-field', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    field: field.name,
                    value: field.value
                })
            });

            const result = await response.json();
            this.showFieldValidation(field, result);
        } catch (error) {
            console.error('Validation error:', error);
        }
    }

    showFieldValidation(field, result) {
        this.clearFieldError(field);
        
        if (!result.valid) {
            field.classList.add('border-red-500', 'bg-red-50');
            field.classList.remove('border-green-500', 'bg-green-50');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-500 text-sm mt-1 field-error';
            errorDiv.textContent = result.message;
            field.parentNode.appendChild(errorDiv);
        } else if (field.value.trim()) {
            field.classList.add('border-green-500', 'bg-green-50');
            field.classList.remove('border-red-500', 'bg-red-50');
        }
    }

    clearFieldError(field) {
        field.classList.remove('border-red-500', 'bg-red-50', 'border-green-500', 'bg-green-50');
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) errorDiv.remove();
    }

    attachFormSubmitValidation() {
        document.querySelectorAll('form[data-validate]').forEach(form => {
            form.addEventListener('submit', (e) => this.validateFormOnSubmit(e));
        });
    }

    async validateFormOnSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/partner/validate-form', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            
            if (result.valid) {
                form.submit();
            } else {
                this.showFormErrors(form, result.errors);
                window.showNotification('Please fix the errors before submitting', 'error');
            }
        } catch (error) {
            console.error('Form validation error:', error);
            window.showNotification('Validation failed. Please try again.', 'error');
        }
    }

    showFormErrors(form, errors) {
        Object.keys(errors).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                this.showFieldValidation(field, {
                    valid: false,
                    message: errors[fieldName][0]
                });
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new FormValidator();
});