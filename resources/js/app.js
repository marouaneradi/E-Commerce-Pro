// E-Commerce Pro - Main JavaScript

// Dark Mode Toggle
const THEME_KEY = 'ecom-theme';
const html = document.documentElement;

function setTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem(THEME_KEY, theme);
    updateToggleState(theme);
}

function updateToggleState(theme) {
    const toggles = document.querySelectorAll('.dark-toggle');
    toggles.forEach(t => {
        t.setAttribute('aria-checked', theme === 'dark');
        t.title = theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode';
    });
}

function initTheme() {
    const saved = localStorage.getItem(THEME_KEY);
    const preferred = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    setTheme(saved || preferred);
}

document.addEventListener('DOMContentLoaded', () => {
    initTheme();

    // Dark mode toggle
    document.querySelectorAll('.dark-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            setTheme(current === 'dark' ? 'light' : 'dark');
        });
    });

    // Mobile menu
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
        });
    }

    // Quantity selector
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.closest('.qty-selector')?.querySelector('.qty-input');
            if (!input) return;
            const val = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;
            if (btn.dataset.action === 'increase') {
                input.value = Math.min(val + 1, max);
            } else {
                input.value = Math.max(val - 1, min);
            }
        });
    });

    // Auto dismiss alerts
    document.querySelectorAll('.alert[data-dismiss]').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            alert.style.transition = 'all 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        }, parseInt(alert.dataset.dismiss) || 4000);
    });

    // Star rating selector
    document.querySelectorAll('.star-rating').forEach(wrapper => {
        const labels = wrapper.querySelectorAll('label');
        labels.forEach((label, i) => {
            label.addEventListener('mouseover', () => {
                labels.forEach((l, j) => {
                    l.style.color = j <= i ? 'var(--secondary)' : '#d1d5db';
                });
            });
            label.addEventListener('mouseout', () => {
                labels.forEach(l => l.style.color = '');
            });
        });
    });

    // Image preview
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        const previewId = input.dataset.preview;
        const preview = document.getElementById(previewId);
        if (!preview) return;
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (file && preview) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Cart quantity update on change
    document.querySelectorAll('.cart-qty-input').forEach(input => {
        input.addEventListener('change', () => {
            const form = input.closest('form');
            if (form) form.submit();
        });
    });

    // Confirm dialogs
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm || 'Are you sure?')) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    // Dropdown menus
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        dropdown.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    });

    // Animate product cards on scroll
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.product-card, .stat-card, .category-card').forEach(el => {
            observer.observe(el);
        });
    }

    // Smooth scroll to anchor
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
}

// Flash message helper
function showFlash(message, type = 'success') {
    const flash = document.createElement('div');
    flash.className = `alert alert-${type} fade-in`;
    flash.style.cssText = 'position:fixed;top:80px;right:20px;z-index:9999;min-width:300px;max-width:400px;';
    flash.dataset.dismiss = '4000';
    flash.textContent = message;
    document.body.appendChild(flash);
    setTimeout(() => {
        flash.style.opacity = '0';
        flash.style.transform = 'translateY(-8px)';
        flash.style.transition = 'all 0.3s ease';
        setTimeout(() => flash.remove(), 300);
    }, 4000);
}
