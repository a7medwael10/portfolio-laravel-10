<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Layers } from 'lucide-vue-next';

defineProps({
    categories: {
        type: Array,
        required: true,
    }
});
</script>

<template>
    <Head title="Skills - Ahmed Wael" />
    <PublicLayout>
        <div class="max-w-6xl mx-auto space-y-12 animate-fade-in-up">
            <div class="text-center space-y-4 mb-16">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-indigo-400 mb-6 transform rotate-3">
                    <Layers class="w-8 h-8" />
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Technical Arsenal</h1>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg pt-2">
                    A comprehensive overview of the tools, frameworks, and languages I use to build robust digital solutions.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="category in categories" :key="category.id" 
                     class="group bg-slate-800/40 backdrop-blur-md rounded-3xl p-8 border border-white/5 hover:border-indigo-500/30 hover:bg-slate-800/60 transition-all duration-500 shadow-lg hover:shadow-indigo-500/10">
                    
                    <h3 class="text-xl font-bold text-white mb-6 border-b border-slate-700 pb-4 group-hover:text-indigo-300 transition-colors">
                        {{ category.name }}
                    </h3>
                    
                    <div class="flex flex-wrap gap-2">
                        <span v-for="skill in category.skills" :key="skill.id"
                              class="px-3 py-1.5 bg-slate-900/50 border border-slate-700 text-slate-300 text-sm font-medium rounded-lg hover:border-cyan-400 hover:text-cyan-300 transition-colors cursor-default">
                            {{ skill.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
