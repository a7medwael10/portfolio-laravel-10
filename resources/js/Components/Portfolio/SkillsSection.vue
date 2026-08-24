<script setup>
import { computed } from 'vue';
import SectionHeader from '@/Components/Portfolio/SectionHeader.vue';

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});

const processedCategories = computed(() => {
    if (!props.categories || !props.categories.length) return [];

    // Sort categories by number of skills descending (categories with most items first)
    const sorted = [...props.categories].sort((a, b) => {
        const countA = a.skills?.length || 0;
        const countB = b.skills?.length || 0;
        return countB - countA;
    });

    const total = sorted.length;

    return sorted.map((category, index) => {
        const skillCount = category.skills?.length || 0;
        let classes = [];

        // Medium screens (2 columns):
        if (index === 0 || (total % 2 === 1 && index === total - 1)) {
            classes.push('md:col-span-2');
        } else {
            classes.push('md:col-span-1');
        }

        // Large screens (3 columns):
        if (total === 7) {
            // Layout for 7 categories: Row 1 (2+1), Row 2 (1+2), Row 3 (1+1+1)
            if (index === 0 || index === 3) {
                classes.push('lg:col-span-2');
            } else {
                classes.push('lg:col-span-1');
            }
        } else {
            const lgRemainder = total % 3;
            if (index === 0 && skillCount >= 4) {
                classes.push('lg:col-span-2');
            } else if (lgRemainder === 1 && index === total - 1) {
                classes.push('lg:col-span-3');
            } else if (lgRemainder === 2 && index === total - 1) {
                classes.push('lg:col-span-2');
            } else {
                classes.push('lg:col-span-1');
            }
        }

        return {
            ...category,
            spanClass: classes.join(' '),
            skillCount,
        };
    });
});

const categoryNumber = (index) => String(index + 1).padStart(2, '0');

const gridCols = computed(() => {
    const total = props.categories?.length || 0;
    if (total <= 1) return 'grid-cols-1';
    return 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
});
</script>

<template>
    <section id="skills" class="portfolio-section">
        <SectionHeader
            label="Expertise"
            title="Technical Skills"
            description="My core stack includes PHP, Laravel, Node.js, NestJS, JavaScript, React, Vue.js, and Next.js, supported by MySQL, MongoDB, Docker, and Git to build secure, scalable, and maintainable applications."
        />

        <div
            v-if="processedCategories?.length"
            class="grid gap-4 md:gap-5"
            :class="gridCols"
        >
            <article
                v-for="(category, index) in processedCategories"
                :key="category.id"
                class="portfolio-card flex flex-col p-6 sm:p-7"
                :class="category.spanClass"
            >
                <div class="mb-5 flex items-start justify-between gap-4 border-b border-line pb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-content sm:text-xl">
                            {{ category.name }}
                        </h3>
                        <span class="mt-1 inline-block text-xs font-mono text-primary font-medium">
                            {{ category.skillCount }} {{ category.skillCount === 1 ? 'skill' : 'skills' }}
                        </span>
                    </div>
                    <span
                        class="shrink-0 font-mono text-xs text-content-muted"
                        aria-hidden="true"
                    >
                        {{ categoryNumber(index) }}
                    </span>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="skill in category.skills"
                        :key="skill.id"
                        class="skill-tag"
                    >
                        {{ skill.name }}
                    </span>
                </div>
            </article>
        </div>
    </section>
</template>
