import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Chart from 'chart.js/auto';

window.Chart = Chart;

Alpine.plugin(collapse);

Alpine.data('tiltCard', (intensity = 10) => ({
    rotateX: 0,
    rotateY: 0,
    reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    onMouseMove(event) {
        if (this.reducedMotion) return;
        const rect = event.currentTarget.getBoundingClientRect();
        const px = (event.clientX - rect.left) / rect.width - 0.5;
        const py = (event.clientY - rect.top) / rect.height - 0.5;
        this.rotateY = px * intensity;
        this.rotateX = py * -intensity;
    },
    onMouseLeave() {
        this.rotateX = 0;
        this.rotateY = 0;
    },
    get tiltStyle() {
        return `transform: rotateX(${this.rotateX}deg) rotateY(${this.rotateY}deg)`;
    },
}));

Alpine.store('toast', {
    items: [],
    push(message, type = 'success') {
        const id = Date.now() + Math.random();
        this.items.push({ id, message, type });
        setTimeout(() => this.remove(id), 4000);
    },
    remove(id) {
        this.items = this.items.filter((item) => item.id !== id);
    },
});

window.Alpine = Alpine;
Alpine.start();

window.apiFetch = async (url, options = {}) => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const response = await fetch(url, {
        ...options,
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': token ?? '',
            ...(options.headers ?? {}),
        },
    });

    const data = await response.json().catch(() => ({}));

    if (!response.ok) {
        throw { status: response.status, data };
    }

    return data;
};

const initScrollReveal = () => {
    const targets = document.querySelectorAll('[data-reveal]');

    if (!targets.length) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' },
    );

    targets.forEach((el) => observer.observe(el));
};

document.addEventListener('DOMContentLoaded', initScrollReveal);
