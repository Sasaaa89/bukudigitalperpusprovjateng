// Admin Dashboard JavaScript Functions

// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Form validation
    const forms = document.querySelectorAll('form[data-validate="true"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
            }
        });
    });
    
    // Initialize tooltips
    initializeTooltips();
    
    // Initialize data tables
    initializeDataTables();
});

// Form validation function
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            showFieldError(field, 'Field ini wajib diisi');
            isValid = false;
        } else {
            clearFieldError(field);
        }
        
        // Email validation
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                showFieldError(field, 'Format email tidak valid');
                isValid = false;
            }
        }
    });
    
    return isValid;
}

// Show field error
function showFieldError(field, message) {
    field.classList.add('form-error');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Add new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-red-500 text-sm mt-1';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

// Clear field error
function clearFieldError(field) {
    field.classList.remove('form-error');
    const errorMessage = field.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

// Initialize tooltips
function initializeTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(function(element) {
        element.addEventListener('mouseenter', function() {
            showTooltip(element, element.getAttribute('data-tooltip'));
        });
        
        element.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    });
}

// Show tooltip
function showTooltip(element, text) {
    const tooltip = document.createElement('div');
    tooltip.id = 'tooltip';
    tooltip.className = 'absolute bg-gray-800 text-white text-sm px-2 py-1 rounded shadow-lg z-50';
    tooltip.textContent = text;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

// Hide tooltip
function hideTooltip() {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

// Initialize data tables with search and pagination
function initializeDataTables() {
    const tables = document.querySelectorAll('.data-table');
    tables.forEach(function(table) {
        addTableSearch(table);
        addTablePagination(table);
    });
}

// Add search functionality to table
function addTableSearch(table) {
    const searchInput = table.parentNode.querySelector('.table-search');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// Add pagination to table
function addTablePagination(table) {
    const paginationContainer = table.parentNode.querySelector('.table-pagination');
    if (!paginationContainer) return;
    
    const rowsPerPage = 10;
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    
    let currentPage = 1;
    
    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        
        rows.forEach(function(row, index) {
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        updatePaginationButtons(page, totalPages);
    }
    
    function updatePaginationButtons(current, total) {
        paginationContainer.innerHTML = '';
        
        // Previous button
        const prevBtn = createPaginationButton('Previous', current > 1);
        prevBtn.addEventListener('click', function() {
            if (current > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });
        paginationContainer.appendChild(prevBtn);
        
        // Page numbers
        for (let i = 1; i <= total; i++) {
            const pageBtn = createPaginationButton(i.toString(), true, i === current);
            pageBtn.addEventListener('click', function() {
                currentPage = i;
                showPage(currentPage);
            });
            paginationContainer.appendChild(pageBtn);
        }
        
        // Next button
        const nextBtn = createPaginationButton('Next', current < total);
        nextBtn.addEventListener('click', function() {
            if (current < total) {
                currentPage++;
                showPage(currentPage);
            }
        });
        paginationContainer.appendChild(nextBtn);
    }
    
    function createPaginationButton(text, enabled, active = false) {
        const button = document.createElement('button');
        button.textContent = text;
        button.className = `px-3 py-1 mx-1 text-sm border rounded ${
            active ? 'bg-blue-500 text-white border-blue-500' :
            enabled ? 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' :
            'bg-gray-100 text-gray-400 border-gray-300 cursor-not-allowed'
        }`;
        button.disabled = !enabled;
        return button;
    }
    
    // Initialize first page
    showPage(1);
}

// Utility functions
function showLoading(element) {
    element.classList.add('loading');
    const spinner = document.createElement('div');
    spinner.className = 'spinner';
    element.appendChild(spinner);
}

function hideLoading(element) {
    element.classList.remove('loading');
    const spinner = element.querySelector('.spinner');
    if (spinner) {
        spinner.remove();
    }
}

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-slide-in fixed top-4 right-4 z-50 px-4 py-3 rounded shadow-lg`;
    
    const bgColor = {
        'success': 'bg-green-100 border-green-400 text-green-700',
        'error': 'bg-red-100 border-red-400 text-red-700',
        'warning': 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info': 'bg-blue-100 border-blue-400 text-blue-700'
    };
    
    alertDiv.className += ` ${bgColor[type] || bgColor.info}`;
    alertDiv.textContent = message;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(function() {
        alertDiv.style.opacity = '0';
        setTimeout(function() {
            alertDiv.remove();
        }, 300);
    }, 5000);
}

function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
    return confirm(message);
}

// AJAX helper function
function ajaxRequest(url, method = 'GET', data = null) {
    return new Promise(function(resolve, reject) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        resolve(xhr.responseText);
                    }
                } else {
                    reject(new Error('Request failed: ' + xhr.status));
                }
            }
        };
        
        if (data) {
            xhr.send(JSON.stringify(data));
        } else {
            xhr.send();
        }
    });
}

// Export functions for global use
window.AdminJS = {
    validateForm,
    showAlert,
    confirmDelete,
    ajaxRequest,
    showLoading,
    hideLoading
};