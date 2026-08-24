<script setup>
import SectionHeader from '@/Components/Portfolio/SectionHeader.vue';
import ProjectsCarousel from '@/Components/Portfolio/ProjectsCarousel.vue';

defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
    getMainImage: {
        type: Function,
        default: null,
    },
});
</script>

<template>
    <section id="projects" class="portfolio-section">
        <SectionHeader
            label="Work"
            title="Projects"
            description="Selected work across restaurant, e-commerce, education, reservation, logistics, and admin platforms."
        />

        <ProjectsCarousel
            :projects="projects"
            :get-main-image="getMainImage"
        />
    </section>
</template>

