// Public Form JavaScript Functions

document.addEventListener('DOMContentLoaded', function() {
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize file upload handlers
    initializeFileUpload();
    
    // Initialize form submission
    initializeFormSubmission();
    
    // Add loading states
    initializeLoadingStates();
});

// Form validation for public forms
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(function(input) {
            input.addEventListener('blur', function() {
                validateField(input);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(input);
            });
        });
        
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
                showAlert('Mohon lengkapi semua field yang wajib diisi', 'error');
            }
        });
    });
}

// Validate individual field
function validateField(field) {
    let isValid = true;
    const value = field.value.trim();
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'Field ini wajib diisi');
        isValid = false;
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Format email tidak valid');
            isValid = false;
        }
    }
    
    // Phone number validation (Indonesian format)
    if (field.name === 'nomor_telepon' && value) {
        const phoneRegex = /^(\+62|62|0)[0-9]{9,13}$/;
        if (!phoneRegex.test(value.replace(/\s|-/g, ''))) {
            showFieldError(field, 'Format nomor telepon tidak valid');
            isValid = false;
        }
    }
    
    // Minimum length validation
    if (field.hasAttribute('minlength') && value.length < field.getAttribute('minlength')) {
        showFieldError(field, `Minimal ${field.getAttribute('minlength')} karakter`);
        isValid = false;
    }
    
    if (isValid) {
        clearFieldError(field);
    }
    
    return isValid;
}

// Validate entire form
function validateForm(form) {
    let isValid = true;
    const fields = form.querySelectorAll('input, textarea, select');
    
    fields.forEach(function(field) {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Show field error
function showFieldError(field, message) {
    field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    field.classList.remove('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error text-red-500 text-sm mt-1';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
    field.parentNode.appendChild(errorDiv);
}

// Clear field error
function clearFieldError(field) {
    field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    field.classList.add('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
    
    const errorMessage = field.parentNode.querySelector('.field-error');
    if (errorMessage) {
        errorMessage.remove();
    }
}

// Initialize file upload handlers
function initializeFileUpload() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            validateFileUpload(input);
        });
    });
}

// Validate file upload
function validateFileUpload(input) {
    const file = input.files[0];
    if (!file) return true;
    
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg'];
    
    // Check file size
    if (file.size > maxSize) {
        showFieldError(input, 'Ukuran file maksimal 5MB');
        input.value = '';
        return false;
    }
    
    // Check file type
    if (!allowedTypes.includes(file.type)) {
        showFieldError(input, 'Format file tidak didukung. Gunakan PDF, DOCX, JPG, atau PNG');
        input.value = '';
        return false;
    }
    
    clearFieldError(input);
    showFileInfo(input, file);
    return true;
}

// Show file information
function showFileInfo(input, file) {
    const existingInfo = input.parentNode.querySelector('.file-info');
    if (existingInfo) {
        existingInfo.remove();
    }
    
    const infoDiv = document.createElement('div');
    infoDiv.className = 'file-info text-sm text-gray-600 mt-1 p-2 bg-gray-50 rounded';
    infoDiv.innerHTML = `
        <i class="fas fa-file mr-2"></i>
        <span class="font-medium">${file.name}</span>
        <span class="text-gray-500">(${formatFileSize(file.size)})</span>
    `;
    input.parentNode.appendChild(infoDiv);
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Initialize form submission with loading states
function initializeFormSubmission() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                showButtonLoading(submitButton);
            }
        });
    });
}

// Initialize loading states
function initializeLoadingStates() {
    const buttons = document.querySelectorAll('button, a[href]');
    
    buttons.forEach(function(button) {
        if (button.type === 'submit') return; // Already handled in form submission
        
        button.addEventListener('click', function() {
            if (this.href && this.href.includes('delete')) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    return false;
                }
            }
            
            showButtonLoading(this);
        });
    });
}

// Show button loading state
function showButtonLoading(button) {
    const originalText = button.innerHTML;
    button.setAttribute('data-original-text', originalText);
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    
    // Reset after 10 seconds as fallback
    setTimeout(function() {
        resetButtonLoading(button);
    }, 10000);
}

// Reset button loading state
function resetButtonLoading(button) {
    const originalText = button.getAttribute('data-original-text');
    if (originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
        button.removeAttribute('data-original-text');
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg max-w-sm`;
    
    const bgColor = {
        'success': 'bg-green-100 border border-green-400 text-green-700',
        'error': 'bg-red-100 border border-red-400 text-red-700',
        'warning': 'bg-yellow-100 border border-yellow-400 text-yellow-700',
        'info': 'bg-blue-100 border border-blue-400 text-blue-700'
    };
    
    const icon = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'warning': 'fa-exclamation-triangle',
        'info': 'fa-info-circle'
    };
    
    alertDiv.className += ` ${bgColor[type] || bgColor.info}`;
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon[type] || icon.info} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-lg leading-none">&times;</button>
        </div>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(function() {
        if (alertDiv.parentNode) {
            alertDiv.style.opacity = '0';
            alertDiv.style.transform = 'translateX(100%)';
            setTimeout(function() {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 300);
        }
    }, 5000);
}

// Smooth scroll to element
function scrollToElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Format phone number as user types
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    
    if (value.startsWith('62')) {
        value = '+' + value;
    } else if (value.startsWith('0')) {
        value = '+62' + value.substring(1);
    } else if (value.length > 0 && !value.startsWith('+')) {
        value = '+62' + value;
    }
    
    input.value = value;
}

// Auto-resize textarea
function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

// Initialize auto-resize for textareas
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(function(textarea) {
        textarea.addEventListener('input', function() {
            autoResizeTextarea(this);
        });
        
        // Initial resize
        autoResizeTextarea(textarea);
    });
    
    // Initialize phone number formatting
    const phoneInputs = document.querySelectorAll('input[name="nomor_telepon"]');
    phoneInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            formatPhoneNumber(this);
        });
    });
});

// Export functions for global use
window.PublicJS = {
    showAlert,
    validateForm,
    scrollToElement,
    formatPhoneNumber,
    autoResizeTextarea
};