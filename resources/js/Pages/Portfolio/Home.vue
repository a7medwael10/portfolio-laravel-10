<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Components/Portfolio/HeroSection.vue';
import AboutSection from '@/Components/Portfolio/AboutSection.vue';
import SkillsSection from '@/Components/Portfolio/SkillsSection.vue';
import ExperienceSection from '@/Components/Portfolio/ExperienceSection.vue';
import ProjectsSection from '@/Components/Portfolio/ProjectsSection.vue';
import ContactSection from '@/Components/Portfolio/ContactSection.vue';

defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    education: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    experiences: {
        type: Array,
        default: () => [],
    },
    projects: {
        type: Array,
        default: () => [],
    },
});

const formatDate = (dateString) => {
    if (!dateString) return 'Present';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};

const getMainImage = (project) => {
    if (project.main_image_url) {
        return project.main_image_url;
    }

    if (project.images && project.images.length > 0) {
        const main = project.images.find((img) => img.is_main);
        const image = main || project.images[0];

        if (image.image_url) {
            return image.image_url;
        }

        if (image.image_path) {
            return image.image_path.startsWith('http')
                ? image.image_path
                : `/storage/${image.image_path}`;
        }
    }

    return null;
};

const contactForm = useForm({
    name: '',
    email: '',
    message: '',
});

const submitContact = () => {
    contactForm.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset();
        },
    });
};

const prefersReducedMotion = () =>
    typeof window !== 'undefined' &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({
            behavior: prefersReducedMotion() ? 'auto' : 'smooth',
        });
    }
};
</script>

<template>
    <Head title="Ahmed Wael - Full-Stack Developer">
        <meta
            head-key="description"
            name="description"
            content="Full-Stack Developer specializing in Laravel backends, React interfaces, REST APIs, and scalable MySQL and MongoDB systems."
        />
    </Head>

    <PublicLayout :profile="profile">
        <HeroSection :profile="profile" @navigate="scrollToSection" />
        <AboutSection
            :profile="profile"
            :education="education"
            :format-date="formatDate"
        />
        <SkillsSection :categories="categories" />
        <ExperienceSection
            :experiences="experiences"
            :format-date="formatDate"
        />
        <ProjectsSection
            :projects="projects"
            :get-main-image="getMainImage"
        />
        <ContactSection
            :profile="profile"
            :contact-form="contactForm"
            :submit-contact="submitContact"
        />
    </PublicLayout>
</template>
