<script setup>
import { ArrowRight, ExternalLink, Github, Linkedin, Mail } from "lucide-vue-next";
import { useLocale } from "@/Composables/useLocale";

defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["navigate"]);
const { isRtl, t, localized } = useLocale();

const scrollTo = (id) => {
    emit("navigate", id);
};
</script>

<template>
    <section
        id="home"
        class="portfolio-section flex min-h-[calc(100vh-theme(spacing.nav))] items-center py-10 md:py-14"
    >
        <div class="grid w-full items-center gap-10 lg:grid-cols-12 lg:gap-12">
            <!-- Left: introduction -->
            <div class="order-1 space-y-6 lg:col-span-7 lg:space-y-7">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-line bg-surface px-3.5 py-1.5 text-sm text-success"
                >
                    <span class="availability-dot" aria-hidden="true" />
                    {{ t("hero.available") }}
                </div>

                <div class="space-y-3">
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.18em] text-content-muted"
                    >
                        {{ t("hero.greeting") }}
                    </p>
                    <h1
                        class="text-4xl font-bold tracking-tight text-content sm:text-5xl lg:text-[3.25rem] lg:leading-tight"
                    >
                        {{ localized(profile, "name") || t("hero.defaultName") }}
                    </h1>
                    <p class="text-xl font-medium text-primary sm:text-2xl">
                        {{ localized(profile, "title") || t("hero.defaultTitle") }}
                    </p>
                </div>

                <p
                    class="max-w-xl text-base leading-relaxed text-content-secondary sm:text-lg"
                >
                    {{ localized(profile, "bio") || t("hero.defaultBio") }}
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <a
                        href="#projects"
                        class="btn-primary group"
                        @click.prevent="scrollTo('projects')"
                    >
                        {{ t("hero.viewProjects") }}
                        <ArrowRight
                            class="h-4 w-4 transition-transform"
                            :class="isRtl ? 'rotate-180 group-hover:-translate-x-0.5' : 'group-hover:translate-x-0.5'"
                            aria-hidden="true"
                        />
                    </a>

                    <a
                        v-if="profile?.cv_url"
                        :href="profile.cv_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-secondary"
                    >
                        <ExternalLink class="h-4 w-4" aria-hidden="true" />
                        {{ t("hero.viewCv") }}
                    </a>

                    <a
                        href="#contact"
                        class="btn-text-link"
                        @click.prevent="scrollTo('contact')"
                    >
                        <Mail class="h-4 w-4" aria-hidden="true" />
                        {{ t("hero.contact") }}
                    </a>
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <a
                        v-if="profile?.github_url"
                        :href="profile.github_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-muted transition-colors hover:border-line-hover hover:text-content"
                        :aria-label="t('hero.githubProfile')"
                    >
                        <Github class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <a
                        v-if="profile?.linkedin_url"
                        :href="profile.linkedin_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-muted transition-colors hover:border-line-hover hover:text-content"
                        :aria-label="t('hero.linkedinProfile')"
                    >
                        <Linkedin class="h-5 w-5" aria-hidden="true" />
                    </a>
                </div>
            </div>

            <!-- Right: portrait -->
            <div class="order-2 lg:col-span-5">
                <div
                    class="relative mx-auto max-w-sm lg:ms-auto lg:me-0 lg:max-w-none"
                >
                    <div
                        class="absolute -inset-3 rounded-[1.75rem] bg-primary/15 blur-2xl"
                        aria-hidden="true"
                    />
                    <div
                        class="relative overflow-hidden rounded-[1.35rem] border border-line bg-surface shadow-[0_0_0_1px_rgba(79,140,255,0.08)]"
                    >
                        <div
                            class="aspect-[4/5] overflow-hidden bg-surface-elevated"
                        >
                            <img
                                v-if="profile?.hero_image_url"
                                :src="profile.hero_image_url"
                                :alt="`${localized(profile, 'name') || t('hero.defaultName')} ${t('hero.portraitAlt')}`"
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.02]"
                                width="480"
                                height="600"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-surface-elevated to-canvas-deep text-content-muted"
                            >
                                <span class="text-sm tracking-wide">{{ t("hero.portraitSoon") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
