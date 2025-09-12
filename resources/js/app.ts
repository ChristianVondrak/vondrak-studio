import '../css/app.css';
import '../css/globals.css';
import '../css/scroll-effects.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const vue = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        // v-reveal directive
        vue.directive('reveal', {
            mounted(el: HTMLElement, binding) {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    el.classList.add('is-visible');
                    return;
                }
                const variant = binding.arg || null;
                if (variant) el.dataset.reveal = variant;
                const delay = binding.modifiers && Object.keys(binding.modifiers)[0];
                let delayMs = 0;
                if (delay && /^d\d+$/.test(delay)) {
                    delayMs = parseInt(delay.substring(1), 10);
                }
                el.classList.add('reveal');
                const io = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Apply delay AFTER intersection, not in CSS
                            setTimeout(() => {
                                el.classList.add('is-visible');
                            }, delayMs);
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });
                io.observe(el);
            },
        });

        vue.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
