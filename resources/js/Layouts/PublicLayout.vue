<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { Menu, X } from 'lucide-vue-next';

const isMenuOpen = ref(false);
const activeSection = ref('home');

const navLinks = [
    { name: 'Home', id: 'home', href: '#home' },
    { name: 'About', id: 'about', href: '#about' },
    { name: 'Skills', id: 'skills', href: '#skills' },
    { name: 'Experience', id: 'experience', href: '#experience' },
    { name: 'Projects', id: 'projects', href: '#projects' },
    { name: 'Contact', id: 'contact', href: '#contact' },
];

const scrollToSection = (id) => {
    isMenuOpen.value = false;
    activeSection.value = id;
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
};

let observer = null;

onMounted(() => {
    // Check if initial URL has hash
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
    <div class="min-h-screen bg-slate-900 text-slate-50 font-sans selection:bg-indigo-500 selection:text-white">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-md bg-slate-900/80 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center hover:scale-105 transition-transform duration-300 cursor-pointer">
                        <a href="#home" @click.prevent="scrollToSection('home')" class="flex items-center">
                            <img src="/images/logo.png" alt="AW Logo" class="h-12 w-auto mix-blend-screen" />
                        </a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a v-for="link in navLinks" :key="link.id" :href="link.href"
                           @click.prevent="scrollToSection(link.id)"
                           class="text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200 py-2 cursor-pointer relative"
                           :class="{ 'text-white border-b-2 border-indigo-500 font-semibold': activeSection === link.id }">
                            {{ link.name }}
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="isMenuOpen = !isMenuOpen" class="text-slate-300 hover:text-white focus:outline-none">
                            <Menu v-if="!isMenuOpen" class="h-6 w-6" />
                            <X v-else class="h-6 w-6" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div v-show="isMenuOpen" class="md:hidden bg-slate-800 border-b border-white/10">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a v-for="link in navLinks" :key="link.id" :href="link.href"
                       @click.prevent="scrollToSection(link.id)"
                       class="block px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:text-white hover:bg-slate-700 transition cursor-pointer"
                       :class="{ 'bg-slate-700 text-white font-semibold': activeSection === link.id }">
                        {{ link.name }}
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-20 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen flex flex-col space-y-24">
            <slot />
        </main>
        
        <!-- Footer -->
        <footer class="py-8 border-t border-white/10 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500">
                &copy; {{ new Date().getFullYear() }} Ahmed Wael. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
html {
    scroll-behavior: smooth;
}
body {
    font-family: 'Inter', sans-serif;
    background-color: #0f172a;
}
</style>
