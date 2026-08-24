<script setup>
import { ref, computed, watch } from 'vue';
import {
    ChevronLeft,
    ChevronRight,
    ExternalLink,
    Github,
    Building2,
    Briefcase,
    User,
    FolderGit2,
} from 'lucide-vue-next';

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
                : `/storage/${image.image_path}`;
        }
    }
    return null;
};

const getTypeMeta = (project) => {
    if (!project) return { label: 'Project', icon: Briefcase };
    if (project.experience || project.type === 'company') {
        return {
            label: project.experience ? project.experience.company : 'Company Experience',
            icon: Building2,
        };
    }
    if (project.type === 'personal') {
        return { label: 'Personal Project', icon: User };
    }
    return { label: 'Freelance', icon: Briefcase };
};

const handlePointerDown = (e) => {
    if (count.value <= 1) return;
    if (e.button !== undefined && e.button !== 0) return;

    startX.value = e.clientX;
    startY.value = e.clientY;
    dragDeltaX.value = 0;
    isDragging.value = true;
    isSwipingHorizontal.value = false;
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
    if (Math.abs(dragDeltaX.value) > 8) {
        e?.preventDefault();
        return;
    }
    if (offset !== 0) {
        goTo(index);
    }
};
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
                No projects available at the moment.
            </p>
        </div>

        <!-- Carousel Stage -->
        <div
            v-else
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
                aria-label="Previous project"
                @click="prev"
            >
                <ChevronLeft class="h-6 w-6" aria-hidden="true" />
            </button>

            <button
                v-if="count > 1"
                type="button"
                class="carousel-nav-btn next-btn hidden lg:flex"
                aria-label="Next project"
                @click="next"
            >
                <ChevronRight class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Cards Grid Stage -->
            <div class="carousel-stage relative grid grid-cols-1 items-stretch justify-items-center w-full min-h-[460px]">
                <article
                    v-for="(project, index) in projects"
                    :key="project.id || index"
                    class="carousel-card portfolio-card group flex flex-col overflow-hidden"
                    :class="{
                        'is-active': getOffset(index) === 0,
                        'is-dragging': isDragging,
                        'cursor-pointer': getOffset(index) !== 0,
                    }"
                    :data-offset="getOffset(index)"
                    :aria-hidden="getOffset(index) !== 0"
                    :style="{
                        '--card-offset': getOffset(index),
                        '--drag-x': `${dragDeltaX}px`,
                    }"
                    @click="handleCardClick(index, getOffset(index), $event)"
                >
                    <!-- Project Image -->
                    <div class="relative aspect-[16/10] w-full overflow-hidden bg-surface-elevated shrink-0">
                        <img
                            v-if="resolveImage(project)"
                            :src="resolveImage(project)"
                            :alt="`${project.title} project screenshot`"
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
                            <p class="font-semibold text-content-muted text-base">{{ project.title }}</p>
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
                            {{ project.title }}
                        </h3>

                        <!-- Description -->
                        <p class="mt-3 flex-1 text-content-secondary leading-relaxed text-sm sm:text-base line-clamp-3 sm:line-clamp-4">
                            {{ project.description }}
                        </p>

                        <!-- Technology Tags -->
                        <div
                            v-if="project.skills?.length"
                            class="mt-5 flex flex-wrap gap-1.5 sm:gap-2"
                        >
                            <span
                                v-for="skill in project.skills"
                                :key="skill.id || skill.name"
                                class="skill-tag text-xs"
                            >
                                {{ skill.name }}
                            </span>
                        </div>

                        <!-- Permanent Action Buttons -->
                        <div class="mt-6 flex flex-wrap gap-3 pt-2">
                            <a
                                v-if="project.github_url"
                                :href="project.github_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-secondary !min-h-[40px] !px-4 !py-2 text-xs sm:text-sm font-semibold"
                                :aria-label="`View ${project.title} on GitHub`"
                                :tabindex="getOffset(index) === 0 ? 0 : -1"
                                @click.stop
                            >
                                <Github class="h-4 w-4" aria-hidden="true" />
                                <span>GitHub</span>
                            </a>
                            <a
                                v-if="project.live_url"
                                :href="project.live_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-primary !min-h-[40px] !px-4 !py-2 text-xs sm:text-sm font-semibold"
                                :aria-label="`View live demo of ${project.title}`"
                                :tabindex="getOffset(index) === 0 ? 0 : -1"
                                @click.stop
                            >
                                <ExternalLink class="h-4 w-4" aria-hidden="true" />
                                <span>Live demo</span>
                            </a>
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
