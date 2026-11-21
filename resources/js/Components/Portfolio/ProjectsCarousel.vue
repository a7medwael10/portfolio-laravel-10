<script setup>
import { ref, computed, watch, nextTick, onUnmounted } from 'vue';
import {
    ChevronLeft,
    ChevronRight,
    ExternalLink,
    Github,
    Building2,
    Briefcase,
    User,
    FolderGit2,
    X,
} from 'lucide-vue-next';
import { useLocale } from '@/Composables/useLocale';

const { locale, t, localized } = useLocale();

const props = defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
    getMainImage: {
        type: Function,
        default: null,
    },
});

const currentIndex = ref(0);
const isDragging = ref(false);
const startX = ref(0);
const startY = ref(0);
const dragDeltaX = ref(0);
const isSwipingHorizontal = ref(false);
const wasDragged = ref(false);
const selectedProject = ref(null);
const closeButton = ref(null);

const count = computed(() => props.projects?.length || 0);

watch(
    () => props.projects,
    (newProjects) => {
        if (!newProjects || newProjects.length === 0) {
            currentIndex.value = 0;
        } else if (currentIndex.value >= newProjects.length) {
            currentIndex.value = newProjects.length - 1;
        }
    },
    { immediate: true, deep: true }
);

const next = () => {
    if (count.value <= 1) return;
    currentIndex.value = (currentIndex.value + 1) % count.value;
};

const prev = () => {
    if (count.value <= 1) return;
    currentIndex.value = (currentIndex.value - 1 + count.value) % count.value;
};

const goTo = (index) => {
    if (index >= 0 && index < count.value) {
        currentIndex.value = index;
    }
};

const getOffset = (index) => {
    const total = count.value;
    if (total <= 1) return 0;
    let diff = index - currentIndex.value;
    if (diff > total / 2) {
        diff -= total;
    } else if (diff < -total / 2) {
        diff += total;
    }
    return diff;
};

const resolveImage = (project) => {
    if (!project) return null;
    if (typeof props.getMainImage === 'function') {
        const url = props.getMainImage(project);
        if (url) return url;
    }
    if (project.main_image_url) {
        return project.main_image_url;
    }
    if (project.images && project.images.length > 0) {
        const main = project.images.find((img) => img.is_main);
        const image = main || project.images[0];
        if (image.image_url) return image.image_url;
        if (image.image_path) {
            return image.image_path.startsWith('http')
                ? image.image_path
                : `/media/images/${image.image_path.replace(/^storage\//, '')}`;
        }
    }
    return null;
};

const getTypeMeta = (project) => {
    if (!project) return { label: t('projects.project'), icon: Briefcase };
    if (project.experience || project.type === 'company') {
        return {
            label: project.experience ? localized(project.experience, 'company') : t('projects.companyExperience'),
            icon: Building2,
        };
    }
    if (project.type === 'personal') {
        return { label: t('projects.personalProject'), icon: User };
    }
    return { label: t('projects.freelance'), icon: Briefcase };
};

const handlePointerDown = (e) => {
    if (count.value <= 1) return;
    if (e.button !== undefined && e.button !== 0) return;

    startX.value = e.clientX;
    startY.value = e.clientY;
    dragDeltaX.value = 0;
    isDragging.value = true;
    isSwipingHorizontal.value = false;
    wasDragged.value = false;
};

const handlePointerMove = (e) => {
    if (!isDragging.value) return;

    const deltaX = e.clientX - startX.value;
    const deltaY = e.clientY - startY.value;

    if (!isSwipingHorizontal.value) {
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 6) {
            isSwipingHorizontal.value = true;
        } else if (Math.abs(deltaY) > Math.abs(deltaX) && Math.abs(deltaY) > 6) {
            isDragging.value = false;
            dragDeltaX.value = 0;
            return;
        }
    }

    if (isSwipingHorizontal.value) {
        dragDeltaX.value = deltaX;
        wasDragged.value = Math.abs(deltaX) > 8;
    }
};

const handlePointerUp = () => {
    if (!isDragging.value) return;

    const threshold = 45;
    if (dragDeltaX.value < -threshold) {
        next();
    } else if (dragDeltaX.value > threshold) {
        prev();
    }

    isDragging.value = false;
    dragDeltaX.value = 0;
    isSwipingHorizontal.value = false;
};

const handleCardClick = (index, offset, e) => {
    if (wasDragged.value) {
        e?.preventDefault();
        wasDragged.value = false;
        return;
    }
    if (offset !== 0) {
        goTo(index);
        return;
    }

    selectedProject.value = props.projects[index];
    nextTick(() => closeButton.value?.focus());
};

const closeProject = () => {
    selectedProject.value = null;
};

const handleCardKeydown = (index, offset) => {
    if (offset === 0) {
        selectedProject.value = props.projects[index];
        nextTick(() => closeButton.value?.focus());
    }
};

const handleEscape = (event) => {
    if (event.key === 'Escape' && selectedProject.value) {
        closeProject();
    }
};

watch(selectedProject, (project) => {
    document.body.style.overflow = project ? 'hidden' : '';
});

if (typeof document !== 'undefined') {
    document.addEventListener('keydown', handleEscape);
}

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
    document.body.style.overflow = '';
});
</script>

<template>
    <div
        class="projects-carousel-wrapper relative w-full"
        tabindex="0"
        role="region"
        aria-roledescription="carousel"
        aria-label="Projects Carousel"
        @keydown.left.prevent="prev"
        @keydown.right.prevent="next"
    >
        <!-- Empty State -->
        <div v-if="count === 0" class="portfolio-card p-12 text-center my-8">
            <p class="text-content-muted text-lg font-medium">
                {{ t('projects.noProjects') }}
            </p>
        </div>

        <!-- Carousel Stage -->
        <div
            v-else
            dir="ltr"
            class="carousel-container relative w-full overflow-x-clip px-1 py-6 sm:py-8"
            @pointerdown="handlePointerDown"
            @pointermove="handlePointerMove"
            @pointerup="handlePointerUp"
            @pointercancel="handlePointerUp"
            @mouseleave="handlePointerUp"
        >
            <!-- Desktop Side Nav Arrows -->
            <button
                v-if="count > 1"
                type="button"
                class="carousel-nav-btn prev-btn hidden lg:flex"
                :aria-label="t('projects.prevProject')"
                @click="prev"
            >
                <ChevronLeft class="h-6 w-6" aria-hidden="true" />
            </button>

            <button
                v-if="count > 1"
                type="button"
                class="carousel-nav-btn next-btn hidden lg:flex"
                :aria-label="t('projects.nextProject')"
                @click="next"
            >
                <ChevronRight class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Cards Grid Stage -->
            <div class="carousel-stage relative grid grid-cols-1 items-stretch justify-items-center w-full min-h-[360px] sm:min-h-[400px]">
                <article
                    v-for="(project, index) in projects"
                    :key="project.id || index"
                    :dir="locale === 'ar' ? 'rtl' : 'ltr'"
                    class="carousel-card portfolio-card group flex flex-col overflow-hidden"
                    :class="{
                        'is-active': getOffset(index) === 0,
                        'is-dragging': isDragging,
                        'cursor-pointer': true,
                    }"
                    :data-offset="getOffset(index)"
                    :aria-hidden="getOffset(index) !== 0"
                    :aria-label="getOffset(index) === 0 ? `${t('projects.viewDetails')}: ${localized(project, 'title')}` : undefined"
                    :tabindex="getOffset(index) === 0 ? 0 : -1"
                    :role="getOffset(index) === 0 ? 'button' : undefined"
                    :style="{
                        '--card-offset': getOffset(index),
                        '--drag-x': `${dragDeltaX}px`,
                    }"
                    @click="handleCardClick(index, getOffset(index), $event)"
                    @keydown.enter.prevent="handleCardKeydown(index, getOffset(index))"
                    @keydown.space.prevent="handleCardKeydown(index, getOffset(index))"
                >
                    <!-- Project Image -->
                    <div class="relative aspect-[16/10] w-full overflow-hidden bg-surface-elevated shrink-0">
                        <img
                            v-if="resolveImage(project)"
                            :src="resolveImage(project)"
                            :alt="`${localized(project, 'title')} ${t('projects.screenshotAlt')}`"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                            loading="lazy"
                            width="800"
                            height="500"
                        />
                        <div
                            v-else
                            class="flex h-full w-full flex-col items-center justify-center bg-canvas-deep p-6 text-center"
                        >
                            <FolderGit2 class="h-10 w-10 text-content-muted/50 mb-2" aria-hidden="true" />
                            <p class="font-semibold text-content-muted text-base">{{ localized(project, 'title') }}</p>
                        </div>
                    </div>

                    <!-- Project Content -->
                    <div class="flex flex-1 flex-col p-6 sm:p-7">
                        <!-- Category/Experience Badge -->
                        <div class="mb-3 inline-flex items-center gap-1.5 text-xs sm:text-sm text-content-muted">
                            <component
                                :is="getTypeMeta(project).icon"
                                class="h-4 w-4 text-primary shrink-0"
                                aria-hidden="true"
                            />
                            <span class="truncate font-medium">{{ getTypeMeta(project).label }}</span>
                        </div>

                        <!-- Project Title -->
                        <h3 class="text-xl font-bold text-content sm:text-2xl tracking-tight line-clamp-1">
                            {{ localized(project, 'title') }}
                        </h3>

                        <div class="mt-auto flex items-center justify-between gap-3 pt-6 text-sm font-semibold text-primary">
                            <span>{{ t('projects.viewDetails') }}</span>
                            <ExternalLink class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true" />
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Controls: Counter & Indicators & Mobile Arrows -->
        <div v-if="count > 1" class="carousel-controls mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 px-2">
            <!-- Counter Status -->
            <div class="flex items-center gap-2">
                <span class="text-xs sm:text-sm font-semibold text-content-muted tracking-wide">
                    {{ currentIndex + 1 }} / {{ count }}
                </span>
                <span class="sr-only" aria-live="polite">
                    Showing project {{ currentIndex + 1 }} of {{ count }}: {{ projects[currentIndex]?.title }}
                </span>
            </div>

            <!-- Indicator Dots -->
            <div class="flex items-center gap-2" role="tablist" aria-label="Project selection">
                <button
                    v-for="(_, idx) in projects"
                    :key="idx"
                    type="button"
                    role="tab"
                    :aria-selected="idx === currentIndex"
                    :aria-label="`Go to project ${idx + 1}`"
                    class="indicator-dot transition-all duration-300 focus:outline-none"
                    :class="idx === currentIndex ? 'bg-primary w-7 h-2.5 rounded-full shadow-sm' : 'bg-content-muted/30 hover:bg-content-muted/60 w-2.5 h-2.5 rounded-full'"
                    @click="goTo(idx)"
                />
            </div>

            <!-- Mobile Navigation Buttons -->
            <div class="flex lg:hidden items-center gap-3">
                <button
                    type="button"
                    class="carousel-nav-btn-mobile"
                    aria-label="Previous project"
                    @click="prev"
                >
                    <ChevronLeft class="h-5 w-5" aria-hidden="true" />
                </button>
                <button
                    type="button"
                    class="carousel-nav-btn-mobile"
                    aria-label="Next project"
                    @click="next"
                >
                    <ChevronRight class="h-5 w-5" aria-hidden="true" />
                </button>
            </div>
        </div>

        <Teleport to="body">
            <Transition name="project-modal">
                <div
                    v-if="selectedProject"
                    class="project-modal-backdrop fixed inset-0 z-[100] overflow-y-auto bg-black/75 px-4 py-6 backdrop-blur-sm sm:px-6 sm:py-10"
                    role="presentation"
                    @mousedown.self="closeProject"
                >
                    <section
                        class="project-modal-panel relative mx-auto w-full max-w-4xl overflow-hidden rounded-2xl border border-line bg-surface-elevated shadow-2xl"
                        role="dialog"
                        aria-modal="true"
                        :aria-labelledby="`project-modal-title-${selectedProject.id}`"
                    >
                        <button
                            ref="closeButton"
                            type="button"
                            class="absolute end-3 top-3 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-black/55 text-white transition hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-primary sm:end-4 sm:top-4"
                            :aria-label="t('projects.closeDetails')"
                            @click="closeProject"
                        >
                            <X class="h-5 w-5" aria-hidden="true" />
                        </button>

                        <div class="relative aspect-[16/9] w-full overflow-hidden bg-canvas-deep">
                            <img
                                v-if="resolveImage(selectedProject)"
                                :src="resolveImage(selectedProject)"
                                :alt="`${localized(selectedProject, 'title')} ${t('projects.screenshotAlt')}`"
                                class="h-full w-full object-cover"
                                width="1200"
                                height="675"
                            />
                            <div v-else class="flex h-full items-center justify-center">
                                <FolderGit2 class="h-14 w-14 text-content-muted/50" aria-hidden="true" />
                            </div>
                            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/70 to-transparent" />
                        </div>

                        <div class="p-6 sm:p-8">
                            <div class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-content-muted">
                                <component :is="getTypeMeta(selectedProject).icon" class="h-4 w-4 text-primary" aria-hidden="true" />
                                <span>{{ getTypeMeta(selectedProject).label }}</span>
                            </div>

                            <h2
                                :id="`project-modal-title-${selectedProject.id}`"
                                class="text-2xl font-bold tracking-tight text-content sm:text-3xl"
                            >
                                {{ localized(selectedProject, 'title') }}
                            </h2>

                            <div class="mt-6">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-content-muted">{{ t('projects.aboutProject') }}</h3>
                                <p class="mt-3 whitespace-pre-line text-base leading-7 text-content-secondary">
                                    {{ localized(selectedProject, 'description') || t('projects.noDescription') }}
                                </p>
                            </div>

                            <div v-if="selectedProject.skills?.length" class="mt-7">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-content-muted">{{ t('projects.technologies') }}</h3>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span
                                        v-for="skill in selectedProject.skills"
                                        :key="skill.id || skill.name"
                                        class="skill-tag text-sm"
                                    >
                                        {{ localized(skill, 'name') }}
                                    </span>
                                </div>
                            </div>

                            <div v-if="selectedProject.github_url || selectedProject.live_url" class="mt-8 flex flex-wrap gap-3 border-t border-line pt-6">
                                <a
                                    v-if="selectedProject.github_url"
                                    :href="selectedProject.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-secondary"
                                >
                                    <Github class="h-4 w-4" aria-hidden="true" />
                                    <span>{{ t('projects.github') }}</span>
                                </a>
                                <a
                                    v-if="selectedProject.live_url"
                                    :href="selectedProject.live_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-primary"
                                >
                                    <ExternalLink class="h-4 w-4" aria-hidden="true" />
                                    <span>{{ t('projects.liveDemo') }}</span>
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<style scoped>
.projects-carousel-wrapper:focus-visible {
    outline: 2px solid var(--color-primary);
    outline-offset: 4px;
    border-radius: var(--radius-card);
}

.carousel-stage {
    display: grid;
    grid-template-columns: 1fr;
    align-items: stretch;
    justify-items: center;
}

.carousel-card {
    grid-column: 1 / -1;
    grid-row: 1 / -1;
    width: 100%;
    max-width: 100%;
    transition: transform 400ms cubic-bezier(0.16, 1, 0.3, 1),
                opacity 400ms ease,
                border-color 300ms ease,
                background-color 300ms ease,
                box-shadow 300ms ease;
    will-change: transform, opacity;
    touch-action: pan-y;
    user-select: none;
}

.carousel-card.is-dragging {
    transition: none !important;
}

.carousel-card:focus-visible {
    outline: 2px solid var(--color-primary);
    outline-offset: 4px;
}

.project-modal-enter-active,
.project-modal-leave-active {
    transition: opacity 200ms ease;
}

.project-modal-enter-active .project-modal-panel,
.project-modal-leave-active .project-modal-panel {
    transition: transform 200ms ease, opacity 200ms ease;
}

.project-modal-enter-from,
.project-modal-leave-to {
    opacity: 0;
}

.project-modal-enter-from .project-modal-panel,
.project-modal-leave-to .project-modal-panel {
    opacity: 0;
    transform: translateY(1rem) scale(0.98);
}

/* Base Mobile view (1 full card) */
.carousel-card {
    transform: translateX(calc(var(--card-offset) * 105% + var(--drag-x)));
    opacity: 0;
    pointer-events: none;
    z-index: 0;
}

.carousel-card[data-offset="0"] {
    transform: translateX(calc(0px + var(--drag-x))) scale(1);
    opacity: 1;
    pointer-events: auto;
    z-index: 20;
    border-color: var(--color-border-hover);
    background-color: var(--color-surface-elevated);
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5), 0 0 20px -5px var(--glow-primary);
}

/* Tablet view (768px - 1023px) */
@media (min-width: 768px) and (max-width: 1023px) {
    .carousel-card {
        width: 75%;
    }
    .carousel-card[data-offset="0"] {
        transform: translateX(calc(0px + var(--drag-x))) scale(1.03);
        opacity: 1;
        pointer-events: auto;
        z-index: 20;
    }
    .carousel-card[data-offset="-1"] {
        transform: translateX(calc(-88% + var(--drag-x))) scale(0.92);
        opacity: 0.65;
        pointer-events: auto;
        z-index: 10;
    }
    .carousel-card[data-offset="1"] {
        transform: translateX(calc(88% + var(--drag-x))) scale(0.92);
        opacity: 0.65;
        pointer-events: auto;
        z-index: 10;
    }
    .carousel-card:not([data-offset="0"]):not([data-offset="-1"]):not([data-offset="1"]) {
        transform: translateX(calc(var(--card-offset) * 150% + var(--drag-x))) scale(0.85);
        opacity: 0;
        pointer-events: none;
        z-index: 0;
    }
}

/* Desktop view (1024px+) */
@media (min-width: 1024px) {
    .carousel-card {
        width: 32%;
    }
    .carousel-card[data-offset="0"] {
        transform: translateX(calc(0px + var(--drag-x))) scale(1.05);
        opacity: 1;
        pointer-events: auto;
        z-index: 20;
    }
    .carousel-card[data-offset="-1"] {
        transform: translateX(calc(-108% + var(--drag-x))) scale(0.94);
        opacity: 0.72;
        pointer-events: auto;
        z-index: 10;
    }
    .carousel-card[data-offset="1"] {
        transform: translateX(calc(108% + var(--drag-x))) scale(0.94);
        opacity: 0.72;
        pointer-events: auto;
        z-index: 10;
    }
    .carousel-card:not([data-offset="0"]):not([data-offset="-1"]):not([data-offset="1"]) {
        transform: translateX(calc(var(--card-offset) * 200% + var(--drag-x))) scale(0.85);
        opacity: 0;
        pointer-events: none;
        z-index: 0;
    }
}

/* Desktop Navigation Arrow Buttons */
.carousel-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 30;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: 9999px;
    border: 1px solid var(--color-border);
    background-color: var(--color-surface-elevated);
    color: var(--color-text);
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.carousel-nav-btn:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
    background-color: var(--color-surface-hover);
    transform: translateY(-50%) scale(1.08);
}

.carousel-nav-btn.prev-btn {
    left: -1rem;
}

@media (min-width: 1280px) {
    .carousel-nav-btn.prev-btn {
        left: -1.75rem;
    }
}

.carousel-nav-btn.next-btn {
    right: -1rem;
}

@media (min-width: 1280px) {
    .carousel-nav-btn.next-btn {
        right: -1.75rem;
    }
}

/* Mobile Navigation Buttons */
.carousel-nav-btn-mobile {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    border: 1px solid var(--color-border);
    background-color: var(--color-surface-elevated);
    color: var(--color-text);
    transition: all 0.2s ease;
}

.carousel-nav-btn-mobile:hover,
.carousel-nav-btn-mobile:active {
    border-color: var(--color-primary);
    color: var(--color-primary);
    background-color: var(--color-surface-hover);
}

/* Prefers Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .carousel-card {
        transition: none !important;
    }
    .carousel-card:not([data-offset="0"]) {
        display: none !important;
    }
    .carousel-card[data-offset="0"] {
        transform: none !important;
    }
}
</style>
