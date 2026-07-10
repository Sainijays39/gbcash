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

const mapRange = (value, inMin, inMax, outMin, outMax) => {
    const t = Math.min(1, Math.max(0, (value - inMin) / (inMax - inMin)));
    return outMin + t * (outMax - outMin);
};

const lerp = (a, b, t) => a + (b - a) * t;

Alpine.data('cinematicHero', (metricValue = 12400) => ({
    progress: 0,
    tiltX: 0,
    tiltY: 0,
    mouseX: '50%',
    mouseY: '50%',
    reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    isMobile: window.matchMedia('(max-width: 1023px)').matches,
    ticking: false,

    init() {
        this.handleResize = () => {
            this.isMobile = window.matchMedia('(max-width: 1023px)').matches;
        };
        window.addEventListener('resize', this.handleResize);

        if (this.reducedMotion) {
            this.progress = 0.45;
            return;
        }

        this.handleScroll = () => {
            if (this.ticking) return;
            this.ticking = true;
            requestAnimationFrame(() => {
                this.update();
                this.ticking = false;
            });
        };
        this.handleMouseMove = (event) => {
            const xVal = (event.clientX / window.innerWidth - 0.5) * 2;
            const yVal = (event.clientY / window.innerHeight - 0.5) * 2;
            this.tiltY = xVal * 12;
            this.tiltX = -yVal * 12;
        };

        window.addEventListener('scroll', this.handleScroll, { passive: true });
        window.addEventListener('mousemove', this.handleMouseMove, { passive: true });
        this.update();
    },

    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
        window.removeEventListener('mousemove', this.handleMouseMove);
    },

    update() {
        const rect = this.$el.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        const total = rect.height - vh;
        this.progress = total > 0 ? Math.min(1, Math.max(0, -rect.top / total)) : 0;
    },

    onCardMouseMove(event) {
        const rect = event.currentTarget.getBoundingClientRect();
        this.mouseX = `${event.clientX - rect.left}px`;
        this.mouseY = `${event.clientY - rect.top}px`;
    },

    get cardSheenStyle() {
        return `--mouse-x: ${this.mouseX}; --mouse-y: ${this.mouseY};`;
    },

    // 0 while framed, 1 while fullscreen — rises 0.18-0.32, holds, then falls back 0.78-0.92
    get cardShape() {
        const p = this.progress;
        if (p < 0.32) return mapRange(p, 0.18, 0.32, 0, 1);
        if (p < 0.78) return 1;
        return 1 - mapRange(p, 0.78, 0.92, 0, 1);
    },

    get cardStyle() {
        const framedSize = this.isMobile ? 92 : 85;
        const framedRadius = this.isMobile ? 32 : 40;
        const width = lerp(framedSize, 100, this.cardShape);
        const height = lerp(framedSize, 100, this.cardShape);
        const radius = lerp(framedRadius, 0, this.cardShape);

        let y = 0;
        if (this.progress < 0.28) {
            y = mapRange(this.progress, 0, 0.28, 100, 0);
        } else if (this.progress >= 0.92) {
            y = mapRange(this.progress, 0.92, 1, 0, -120);
        }

        return `width: ${width}vw; height: ${height}vh; border-radius: ${radius}px; transform: translateY(${y}vh); ${this.cardSheenStyle}`;
    },

    get heroTextStyle() {
        const opacity = 1 - mapRange(this.progress, 0, 0.18, 0, 1);
        const scale = lerp(1, 1.15, mapRange(this.progress, 0, 0.18, 0, 1));
        const blur = mapRange(this.progress, 0, 0.18, 0, 20);
        return `opacity: ${opacity}; transform: scale(${scale}); filter: blur(${blur}px);`;
    },

    get mockupStyle() {
        const enter = mapRange(this.progress, 0.28, 0.5, 0, 1);
        const exit = mapRange(this.progress, 0.65, 0.78, 0, 1);
        const opacity = Math.min(enter, 1 - exit);
        const scale = lerp(0.6, 1, enter) - exit * 0.1;
        const y = lerp(60, 0, enter) - exit * 40;
        const tiltX = this.reducedMotion ? 0 : this.tiltX;
        const tiltY = this.reducedMotion ? 0 : this.tiltY;
        return `opacity: ${opacity}; transform: translateY(${y}px) scale(${scale}) rotateX(${tiltX}deg) rotateY(${tiltY}deg);`;
    },

    sideTextStyle(direction = 1) {
        const enter = mapRange(this.progress, 0.32, 0.5, 0, 1);
        const exit = mapRange(this.progress, 0.65, 0.78, 0, 1);
        const opacity = Math.min(enter, 1 - exit);
        const x = lerp(60 * direction, 0, enter);
        return `opacity: ${opacity}; transform: translateX(${x}px);`;
    },

    get leftTextStyle() {
        return this.sideTextStyle(-1);
    },

    get rightTextStyle() {
        return this.sideTextStyle(1);
    },

    get badgeStyle() {
        const enter = mapRange(this.progress, 0.38, 0.58, 0, 1);
        const exit = mapRange(this.progress, 0.65, 0.78, 0, 1);
        const opacity = Math.min(enter, 1 - exit);
        const y = lerp(40, 0, enter);
        const scale = lerp(0.8, 1, enter);
        return `opacity: ${opacity}; transform: translateY(${y}px) scale(${scale});`;
    },

    get ringProgress() {
        return mapRange(this.progress, 0.36, 0.56, 0, 1);
    },

    get ringOffset() {
        const circumference = 402;
        return circumference - this.ringProgress * (circumference - 20);
    },

    get counterValue() {
        return Math.round(this.ringProgress * metricValue).toLocaleString('en-IN');
    },

    get ctaStyle() {
        const opacity = mapRange(this.progress, 0.68, 0.85, 0, 1);
        const scale = lerp(0.8, 1, opacity);
        const blur = lerp(20, 0, opacity);
        return `opacity: ${opacity}; transform: scale(${scale}); filter: blur(${blur}px); pointer-events: ${opacity > 0.5 ? 'auto' : 'none'};`;
    },
}));

Alpine.data('magneticButton', (strength = 0.4) => ({
    x: 0,
    y: 0,
    reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    onMouseMove(event) {
        if (this.reducedMotion) return;
        const rect = event.currentTarget.getBoundingClientRect();
        this.x = (event.clientX - rect.left - rect.width / 2) * strength;
        this.y = (event.clientY - rect.top - rect.height / 2) * strength;
    },
    onMouseLeave() {
        this.x = 0;
        this.y = 0;
    },
    get magneticStyle() {
        return `transform: translate(${this.x}px, ${this.y}px)`;
    },
}));

Alpine.data('cinematicFooterReveal', () => ({
    progress: 1,
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
                this.update();
                this.ticking = false;
            });
        };

        window.addEventListener('scroll', this.handleScroll, { passive: true });
        this.update();
    },

    destroy() {
        window.removeEventListener('scroll', this.handleScroll);
    },

    update() {
        const rect = this.$el.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        const start = vh * 0.85;
        const end = vh * 0.35;
        this.progress = Math.min(1, Math.max(0, (start - rect.top) / (start - end)));
    },

    get giantTextStyle() {
        const y = 8 * (1 - this.progress);
        const scale = 0.85 + 0.15 * this.progress;
        return `transform: translateY(${y}vh) scale(${scale}); opacity: ${this.progress};`;
    },

    get contentStyle() {
        const y = 40 * (1 - this.progress);
        return `transform: translateY(${y}px); opacity: ${this.progress};`;
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

const initNavScrollSpy = () => {
    const links = document.querySelectorAll('[data-nav-link]');
    const sections = [...new Set([...links].map((link) => link.dataset.navLink))]
        .map((id) => document.getElementById(id))
        .filter(Boolean);

    if (!links.length || !sections.length) return;

    const setActive = (id) => {
        links.forEach((link) => link.classList.toggle('is-active', link.dataset.navLink === id));
    };

    const observer = new IntersectionObserver(
        (entries) => {
            const visible = entries.filter((entry) => entry.isIntersecting);
            if (visible.length) setActive(visible[0].target.id);
        },
        { rootMargin: '-45% 0px -50% 0px', threshold: 0 },
    );

    sections.forEach((section) => observer.observe(section));
};

document.addEventListener('DOMContentLoaded', initNavScrollSpy);
