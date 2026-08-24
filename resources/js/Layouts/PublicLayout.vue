<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { Github, Linkedin, Menu, Moon, Sun, X } from 'lucide-vue-next';
import { useTheme } from '@/Composables/useTheme';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
});

const isMenuOpen = ref(false);
const activeSection = ref('home');
const { theme, toggleTheme } = useTheme();

const navLinks = [
    { name: 'Home', id: 'home', href: '#home' },
    { name: 'About', id: 'about', href: '#about' },
    { name: 'Skills', id: 'skills', href: '#skills' },
    { name: 'Experience', id: 'experience', href: '#experience' },
    { name: 'Projects', id: 'projects', href: '#projects' },
    { name: 'Contact', id: 'contact', href: '#contact' },
];

const prefersReducedMotion = () =>
    typeof window !== 'undefined' &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const scrollToSection = (id) => {
    isMenuOpen.value = false;
    activeSection.value = id;
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({
            behavior: prefersReducedMotion() ? 'auto' : 'smooth',
        });
    }
};

const navCta = computed(() => {
    if (props.profile?.cv_url) {
        return {
            type: 'cv',
            label: 'Download CV',
            href: props.profile.cv_url,
        };
    }
    return {
        type: 'talk',
        label: 'Let’s Talk',
        href: '#contact',
    };
});

const currentYear = new Date().getFullYear();
const themeLabel = computed(() =>
    theme.value === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
);

let observer = null;

onMounted(() => {
    if (window.location.hash) {
        const hashId = window.location.hash.substring(1);
        setTimeout(() => scrollToSection(hashId), 100);
    }

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activeSection.value = entry.target.id;
                }
            });
        },
        { threshold: 0.2, rootMargin: '-80px 0px -40% 0px' }
    );

    navLinks.forEach((link) => {
        const el = document.getElementById(link.id);
        if (el) observer.observe(el);
    });
});

onUnmounted(() => {
    if (observer) {
        observer.disconnect();
    }
});
</script>

<template>
    <div class="portfolio-shell font-sans antialiased">
        <a
            href="#home"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-btn focus:bg-primary focus:px-4 focus:py-2 focus:text-white"
            @click.prevent="scrollToSection('home')"
        >
            Skip to content
        </a>

        <header class="fixed inset-x-0 top-0 z-50">
            <nav
                class="border-b border-line bg-canvas/80 backdrop-blur-md"
                aria-label="Primary"
            >
                <div class="portfolio-container">
                    <div class="flex h-nav items-center justify-between gap-4">
                        <a
                            href="#home"
                            class="flex shrink-0 items-center"
                            @click.prevent="scrollToSection('home')"
                        >
                            <img
                                src="/images/logo.png"
                                alt="AW Logo"
                                class="portfolio-logo h-10 w-auto sm:h-11"
                                width="120"
                                height="44"
                            />
                        </a>

                        <div class="hidden items-center gap-1 md:flex lg:gap-2">
                            <a
                                v-for="link in navLinks"
                                :key="link.id"
                                :href="link.href"
                                class="relative px-3 py-2 text-sm font-medium text-content-secondary transition-colors hover:text-content"
                                :class="{ 'nav-link-active': activeSection === link.id }"
                                @click.prevent="scrollToSection(link.id)"
                            >
                                {{ link.name }}
                            </a>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="theme-toggle"
                                :aria-label="themeLabel"
                                :title="themeLabel"
                                @click="toggleTheme"
                            >
                                <Sun
                                    v-if="theme === 'dark'"
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                                <Moon
                                    v-else
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                            </button>

                            <div class="hidden items-center md:flex">
                                <a
                                    v-if="navCta.type === 'cv'"
                                    :href="navCta.href"
                                    download
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-primary !min-h-[40px] !px-4 !py-2 text-sm"
                                >
                                    {{ navCta.label }}
                                </a>
                                <a
                                    v-else
                                    :href="navCta.href"
                                    class="btn-primary !min-h-[40px] !px-4 !py-2 text-sm"
                                    @click.prevent="scrollToSection('contact')"
                                >
                                    {{ navCta.label }}
                                </a>
                            </div>

                            <button
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-secondary transition-colors hover:border-line-hover hover:text-content md:hidden"
                                :aria-expanded="isMenuOpen"
                                aria-controls="mobile-nav"
                                :aria-label="isMenuOpen ? 'Close menu' : 'Open menu'"
                                @click="isMenuOpen = !isMenuOpen"
                            >
                                <Menu v-if="!isMenuOpen" class="h-5 w-5" aria-hidden="true" />
                                <X v-else class="h-5 w-5" aria-hidden="true" />
                            </button>
                        </div>
                    </div>
                </div>

                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 -translate-y-1"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-1"
                >
                    <div
                        v-show="isMenuOpen"
                        id="mobile-nav"
                        class="border-t border-line bg-surface md:hidden"
                    >
                        <div class="portfolio-container space-y-1 py-3">
                            <a
                                v-for="link in navLinks"
                                :key="link.id"
                                :href="link.href"
                                class="flex min-h-11 items-center rounded-btn px-3 text-base font-medium text-content-secondary transition-colors hover:bg-surface-hover hover:text-content"
                                :class="{
                                    'bg-surface-hover text-primary': activeSection === link.id,
                                }"
                                @click.prevent="scrollToSection(link.id)"
                            >
                                {{ link.name }}
                            </a>

                            <div class="border-t border-line pt-3">
                                <a
                                    v-if="navCta.type === 'cv'"
                                    :href="navCta.href"
                                    download
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-primary w-full"
                                    @click="isMenuOpen = false"
                                >
                                    {{ navCta.label }}
                                </a>
                                <a
                                    v-else
                                    :href="navCta.href"
                                    class="btn-primary w-full"
                                    @click.prevent="scrollToSection('contact')"
                                >
                                    {{ navCta.label }}
                                </a>
                            </div>
                        </div>
                    </div>
                </Transition>
            </nav>
        </header>

        <main class="relative z-10 pt-nav">
            <div class="portfolio-container flex min-h-[calc(100vh-theme(spacing.nav))] flex-col">
                <slot />
            </div>
        </main>

        <footer class="relative z-10 border-t border-line">
            <div class="portfolio-container flex flex-col gap-6 py-10 sm:flex-row sm:items-center sm:justify-between">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <img
                            src="/images/logo.png"
                            alt=""
                            class="portfolio-logo h-8 w-auto"
                            width="80"
                            height="32"
                            aria-hidden="true"
                        />
                        <div>
                            <p class="font-semibold text-content">
                                {{ profile?.name || 'Ahmed Wael' }}
                            </p>
                            <p class="text-sm text-content-muted">
                                {{ profile?.title || 'Full-Stack Developer' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-content-muted">
                        Building reliable digital experiences...    
                    </p>
                </div>

                <div class="flex flex-col gap-4 sm:items-end">
                    <div
                        v-if="profile?.github_url || profile?.linkedin_url"
                        class="flex items-center gap-3"
                    >
                        <a
                            v-if="profile?.github_url"
                            :href="profile.github_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-muted transition-colors hover:border-line-hover hover:text-content"
                            aria-label="GitHub profile"
                        >
                            <Github class="h-5 w-5" aria-hidden="true" />
                        </a>
                        <a
                            v-if="profile?.linkedin_url"
                            :href="profile.linkedin_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-muted transition-colors hover:border-line-hover hover:text-content"
                            aria-label="LinkedIn profile"
                        >
                            <Linkedin class="h-5 w-5" aria-hidden="true" />
                        </a>
                    </div>
                    <p class="text-sm text-content-muted">
                        &copy; {{ currentYear }} {{ profile?.name || 'Ahmed Wael' }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
