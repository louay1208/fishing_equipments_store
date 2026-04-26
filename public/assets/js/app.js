// Pêche Marine TN — Client-side JavaScript

document.addEventListener('DOMContentLoaded', () => {
    // Auto-dismiss flash messages
    document.querySelectorAll('.flash-message').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.3s, transform 0.3s';
            el.style.opacity = '0';
            el.style.transform = 'translateX(100%)';
            setTimeout(() => el.remove(), 300);
        }, 4000);
    });

    // Quantity controls in cart
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.qty-control').querySelector('input');
            const form = this.closest('form');
            let val = parseInt(input.value) || 1;
            if (this.dataset.action === 'plus') val++;
            else if (this.dataset.action === 'minus' && val > 1) val--;
            input.value = val;
            if (form) form.submit();
        });
    });

    // Add to cart with feedback
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Ajouté !';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-primary');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
            }, 1500);
        });
    });

    // Confirm delete actions
    document.querySelectorAll('.confirm-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ?')) {
                e.preventDefault();
            }
        });
    });

    // Search debounce
    const searchInput = document.getElementById('product-search');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.closest('form').submit();
            }, 500);
        });
    }

    // Password visibility toggle
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });
});
