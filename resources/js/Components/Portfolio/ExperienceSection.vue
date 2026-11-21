<script setup>
import { ExternalLink, MapPin } from 'lucide-vue-next';
import SectionHeader from '@/Components/Portfolio/SectionHeader.vue';
import { useLocale } from '@/Composables/useLocale';

defineProps({
    experiences: {
        type: Array,
        default: () => [],
    },
    formatDate: {
        type: Function,
        required: true,
    },
});

const { t, localized } = useLocale();
</script>

<template>
    <section id="experience" class="portfolio-section">
        <SectionHeader
            :label="t('experience.label')"
            :title="t('experience.title')"
            :description="t('experience.description')"
        />

        <div v-if="experiences?.length" class="relative">
            <div
                class="absolute bottom-2 start-[0.4375rem] top-2 w-px bg-line md:start-[9.5rem]"
                aria-hidden="true"
            />

            <ol class="space-y-0">
                <li
                    v-for="exp in experiences"
                    :key="exp.id"
                    class="relative grid gap-4 pb-10 last:pb-0 md:grid-cols-[9rem_1fr] md:gap-8"
                >
                    <div class="relative ps-7 md:ps-0">
                        <span
                            class="absolute start-0 top-1.5 h-2.5 w-2.5 rounded-full border-2 border-primary bg-canvas md:start-auto md:-end-[1.2rem]"
                            aria-hidden="true"
                        />
                        <p class="text-sm text-content-muted md:pt-0.5 md:text-end">
                            {{ formatDate(exp.start_date) }}
                            <span class="text-content-muted/70">–</span>
                            {{ formatDate(exp.end_date) }}
                        </p>
                    </div>

                    <article class="portfolio-card p-5 sm:p-6">
                        <h3 class="text-xl font-semibold text-content sm:text-2xl">
                            {{ localized(exp, 'title') }}
                        </h3>

                        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                            <a
                                v-if="exp.company_url"
                                :href="exp.company_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 font-medium text-primary transition-colors hover:text-primary-hover"
                            >
                                {{ localized(exp, 'company') }}
                                <ExternalLink class="h-3.5 w-3.5" aria-hidden="true" />
                                <span class="sr-only">{{ t('experience.opensInNewTab') }}</span>
                            </a>
                            <p v-else class="font-medium text-primary">{{ localized(exp, 'company') }}</p>

                            <p
                                v-if="localized(exp, 'work_location')"
                                class="inline-flex items-center gap-1.5 text-sm text-content-muted"
                            >
                                <MapPin class="h-3.5 w-3.5" aria-hidden="true" />
                                {{ localized(exp, 'work_location') }}
                            </p>
                        </div>

                        <ul
                            v-if="localized(exp, 'description')?.length"
                            class="mt-5 space-y-2.5"
                        >
                            <li
                                v-for="(point, idx) in localized(exp, 'description')"
                                :key="idx"
                                class="flex items-start gap-2.5 text-content-secondary"
                            >
                                <span
                                    class="mt-2 h-1 w-1 shrink-0 rounded-full bg-primary"
                                    aria-hidden="true"
                                />
                                <span class="leading-relaxed">{{ point }}</span>
                            </li>
                        </ul>
                    </article>
                </li>
            </ol>
        </div>
    </section>
</template>
