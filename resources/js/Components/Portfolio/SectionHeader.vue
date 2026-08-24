<script setup>
defineProps({
    label: {
        type: String,
        default: '',
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
    align: {
        type: String,
        default: 'left',
        validator: (value) => ['left', 'center'].includes(value),
    },
});
</script>

<template>
    <div
        class="mb-10 md:mb-12"
        :class="align === 'center' ? 'text-center mx-auto max-w-2xl' : 'max-w-3xl'"
    >
        <p
            v-if="label"
            class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-accent"
        >
            {{ label }}
        </p>
        <h2 class="text-3xl font-bold tracking-tight text-content sm:text-4xl md:text-5xl">
            {{ title }}
        </h2>
        <p
            v-if="description"
            class="mt-4 text-base leading-relaxed text-content-muted sm:text-lg"
            :class="align === 'center' ? 'mx-auto max-w-xl' : 'max-w-2xl'"
        >
            {{ description }}
        </p>
    </div>
</template>
