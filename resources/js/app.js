// Turbo Drive: navigasi halaman tidak memuat ulang seluruh dokumen — hanya <body>
// diganti, elemen bertanda data-turbo-permanent (navbar/footer/logo) dipertahankan.
import '@hotwired/turbo';

let heroInterval = null;
let fadeObserver = null;

// ===== Mobile drawer =====
function initDrawer() {
    const toggle = document.getElementById('navbarToggle');
    const closeBtn = document.getElementById('drawerClose');
    const drawer = document.getElementById('mobileDrawer');

    if (!toggle || !closeBtn || !drawer || drawer.dataset.bound) {
        return;
    }
    drawer.dataset.bound = '1';

    const open = () => {
        drawer.classList.add('open');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const close = () => {
        drawer.classList.remove('open');
        drawer.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    toggle.addEventListener('click', open);
    closeBtn.addEventListener('click', close);
    drawer.addEventListener('click', (e) => {
        if (e.target.tagName === 'A') close();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });
}

// ===== Fade-up modern =====
function initFadeUp() {
    if (fadeObserver) {
        fadeObserver.disconnect();
        fadeObserver = null;
    }

    const els = document.querySelectorAll('.fade-up');
    if (!els.length) {
        return;
    }

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced || !('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('show'));
        return;
    }

    fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                fadeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    els.forEach((el) => fadeObserver.observe(el));
}

// ===== Rotasi tagline hero =====
function initHeroTagline() {
    if (heroInterval) {
        clearInterval(heroInterval);
        heroInterval = null;
    }

    const el = document.getElementById('hero-tagline');
    if (!el || !el.dataset.taglines) {
        return;
    }

    const quotes = JSON.parse(el.dataset.taglines || '[]');
    if (quotes.length < 2) {
        return;
    }

    const [current, incoming] = [...el.querySelectorAll('.hero-tagline-item')];
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let index = 0;

    // prefers-reduced-motion: ganti teks langsung, tanpa animasi.
    if (reducedMotion) {
        heroInterval = setInterval(() => {
            index = (index + 1) % quotes.length;
            current.textContent = quotes[index];
        }, 5000);

        return;
    }

    heroInterval = setInterval(() => {
        const next = (index + 1) % quotes.length;
        incoming.textContent = quotes[next];
        incoming.style.opacity = 1;
        current.style.opacity = 0;

        window.setTimeout(() => {
            current.style.transition = 'none';
            incoming.style.transition = 'none';
            current.textContent = quotes[next];
            current.style.opacity = 1;
            incoming.style.opacity = 0;
            void current.offsetHeight; // paksa reflow agar transisi tidak me-flash
            current.style.transition = '';
            incoming.style.transition = '';

            index = next;
        }, 800);
    }, 5000);
}

function initPage() {
    initDrawer();
    initFadeUp();
    initHeroTagline();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPage);
} else {
    initPage();
}

// Jalankan ulang setelah Turbo mengganti isi halaman.
document.addEventListener('turbo:render', initPage);
document.addEventListener('turbo:load', initPage);