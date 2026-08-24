<script setup>
import { computed } from 'vue';
import { ExternalLink, GraduationCap, MapPin } from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    education: {
        type: Array,
        default: () => [],
    },
    formatDate: {
        type: Function,
        required: true,
    },
});

const defaultAboutParagraphs = [
    'I’m Ahmed Wael, a Full-Stack Developer specializing in building scalable web applications using Laravel for backend development and React for modern, responsive user interfaces.',
    'I have hands-on experience developing RESTful APIs, designing and optimizing MySQL and MongoDB databases, integrating third-party services, and building secure, maintainable systems. I follow clean-code practices and apply OOP, SOLID principles, and design patterns to create reliable solutions that can grow with business needs.',
    'I have worked on various projects, including restaurant management systems, e-commerce platforms, educational applications, reservation systems, logistics solutions, and administrative dashboards.',
    'My primary technologies include PHP, Laravel, JavaScript, React, Blade, Bootstrap, Tailwind CSS, MySQL, MongoDB, Git, Docker, and Linux. I’m also familiar with Vue.js, Filament, Express.js, Django, and AI-powered application development.',
    'I’m passionate about solving real-world problems, continuously improving my skills, and delivering high-quality products with strong performance, security, and user experience.',
];

const aboutParagraphs = computed(() => {
    const source = props.profile?.about_text || props.profile?.bio;
    if (source && String(source).trim()) {
        const parts = String(source)
            .split(/\n\n+/)
            .map((part) => part.trim())
            .filter(Boolean);
        return parts.length ? parts : [String(source).trim()];
    }
    return defaultAboutParagraphs;
});
</script>

<template>
    <section id="about" class="portfolio-section">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
            <div class="lg:col-span-5">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-accent">
                    About
                </p>
                <h2 class="text-3xl font-bold tracking-tight text-content sm:text-4xl md:text-5xl">
                    About Me
                </h2>
                <div
                    v-if="profile?.location"
                    class="mt-4 inline-flex items-center gap-2 text-content-muted"
                >
                    <MapPin class="h-4 w-4 text-primary" aria-hidden="true" />
                    <span>{{ profile.location }}</span>
                </div>
            </div>

            <div class="space-y-4 lg:col-span-7">
                <p
                    v-for="(paragraph, index) in aboutParagraphs"
                    :key="index"
                    class="max-w-prose text-base leading-relaxed text-content-secondary sm:text-lg"
                >
                    {{ paragraph }}
                </p>
            </div>
        </div>

        <div v-if="education?.length" class="mt-16 md:mt-20">
            <div class="mb-8 flex items-center gap-3">
                <GraduationCap class="h-6 w-6 text-primary" aria-hidden="true" />
                <h3 class="text-2xl font-bold text-content sm:text-3xl">Education</h3>
            </div>

            <ol class="relative space-y-0 border-l border-line pl-6 md:pl-8">
                <li
                    v-for="edu in education"
                    :key="edu.id"
                    class="relative pb-10 last:pb-0"
                >
                    <span
                        class="absolute -left-[1.9rem] top-1.5 h-2.5 w-2.5 rounded-full border-2 border-primary bg-canvas md:-left-[2.15rem]"
                        aria-hidden="true"
                    />

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-baseline sm:justify-between sm:gap-6">
                        <h4 class="text-lg font-semibold text-content sm:text-xl">
                            {{ edu.degree }}
                        </h4>
                        <p class="shrink-0 text-sm text-content-muted">
                            {{ formatDate(edu.start_date) }} – {{ formatDate(edu.end_date) }}
                        </p>
                    </div>

                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                        <a
                            v-if="edu.institution_url"
                            :href="edu.institution_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 font-medium text-primary transition-colors hover:text-primary-hover"
                        >
                            {{ edu.institution }}
                            <ExternalLink class="h-3.5 w-3.5" aria-hidden="true" />
                            <span class="sr-only">(opens in new tab)</span>
                        </a>
                        <p v-else class="font-medium text-primary">{{ edu.institution }}</p>

                        <p
                            v-if="edu.location"
                            class="inline-flex items-center gap-1.5 text-sm text-content-muted"
                        >
                            <MapPin class="h-3.5 w-3.5" aria-hidden="true" />
                            {{ edu.location }}
                        </p>
                    </div>

                    <div class="mt-3 space-y-1 text-sm text-content-muted">
                        <p v-if="edu.field_of_study">
                            Track:
                            <span class="text-content-secondary">{{ edu.field_of_study }}</span>
                        </p>
                        <p v-if="edu.grade">
                            Grade:
                            <span class="text-content-secondary">{{ edu.grade }}</span>
                        </p>
                    </div>

                    <ul
                        v-if="edu.description?.length"
                        class="mt-4 space-y-2"
                    >
                        <li
                            v-for="(point, idx) in edu.description"
                            :key="idx"
                            class="flex items-start gap-2 text-content-secondary"
                        >
                            <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-accent" aria-hidden="true" />
                            <span>{{ point }}</span>
                        </li>
                    </ul>
                </li>
            </ol>
        </div>
    </section>
</template>
