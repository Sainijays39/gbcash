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

Alpine.data('scrollCard', () => ({
    progress: 1,
    isMobile: window.matchMedia('(max-width: 768px)').matches,
    reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    ticking: false,

    init() {
        if (this.reducedMotion) {
            this.progress = 1;
            return;
        }

        this.handleScroll = () => {
            if (this.ticking) return;
            this.ticking = true;
            requestAnimationFrame(() => {
                this.updateProgress();
                this.ticking = false;
            });
        };
        this.handleResize = () => {
            this.isMobile = window.matchMedia('(max-width: 768px)').matches;
        };

        window.addEventListener('scroll', this.handleScroll, { passive: true });
        window.addEventListener('resize', this.handleResize);
        this.updateProgress();
    },

    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
    },

    updateProgress() {
        const rect = this.$el.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        const total = rect.height + vh;
        const scrolled = vh - rect.top;
        this.progress = Math.min(1, Math.max(0, scrolled / total));
    },

    get rotate() {
        return 20 * (1 - this.progress);
    },

    get scale() {
        return this.isMobile ? 0.7 + 0.2 * this.progress : 1.05 - 0.05 * this.progress;
    },

    get cardStyle() {
        return `transform: perspective(1200px) rotateX(${this.rotate}deg) scale(${this.scale});`;
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
