<script setup>
import SectionHeader from '@/Components/Portfolio/SectionHeader.vue';
import ProjectsCarousel from '@/Components/Portfolio/ProjectsCarousel.vue';
import { useLocale } from '@/Composables/useLocale';

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

const { t } = useLocale();
</script>

<template>
    <section id="projects" class="portfolio-section">
        <SectionHeader
            :label="t('projects.label')"
            :title="t('projects.title')"
            :description="t('projects.description')"
        />

        <ProjectsCarousel
            :projects="projects"
            :get-main-image="getMainImage"
        />
    </section>
</template>

