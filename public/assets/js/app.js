// Pêche Marine TN — Client-side JavaScript

document.addEventListener('DOMContentLoaded', () => {

    // ─── Toast Notification System ───
    const toastContainer = document.querySelector('.toast-container');
    if (toastContainer) {
        toastContainer.querySelectorAll('.toast-notification').forEach(toast => {
            const duration = 4000;
            toast.style.setProperty('--duration', duration + 'ms');
            // Click to dismiss
            toast.addEventListener('click', () => dismissToast(toast));
            // Auto dismiss
            setTimeout(() => dismissToast(toast), duration);
        });
    }
    function dismissToast(toast) {
        if (toast.classList.contains('removing')) return;
        toast.classList.add('removing');
        setTimeout(() => toast.remove(), 350);
    }

    // ─── Scroll Reveal ───
    const reveals = document.querySelectorAll('.reveal');
    if (reveals.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('revealed');
                    }, i * 80); // stagger
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(el => observer.observe(el));
    }

    // ─── Back to Top ───
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.scrollY > 400);
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ─── Animated Counters ───
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count);
        const suffix = el.dataset.suffix || '';
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(el, target, suffix);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        observer.observe(el);
    });
    function animateCounter(el, target, suffix) {
        let current = 0;
        const step = Math.max(1, Math.floor(target / 30));
        const interval = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(interval);
                el.classList.add('counted');
            }
            el.textContent = current + suffix;
        }, 40);
    }

    // ─── Quantity controls in cart ───
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

    // ─── Add to cart with feedback ───
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Ajouté !';
                btn.disabled = true;
                btn.classList.add('btn-success');
                btn.classList.remove('btn-primary');
            }
            setTimeout(() => {
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-cart-plus me-1"></i>Ajouter';
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                }
            }, 500);
        });
    });

    // ─── Password visibility toggle ───
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

    // ─── Dark mode toggle ───
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const updateIcon = () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            themeToggle.querySelector('i').className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        };
        updateIcon();
        themeToggle.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateIcon();
        });
    }
});
