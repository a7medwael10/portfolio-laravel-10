<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Briefcase, ExternalLink, MapPin } from 'lucide-vue-next';

defineProps({
    experiences: {
        type: Array,
        required: true,
    }
});

const formatDate = (dateString) => {
    if (!dateString) return 'Present';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};
</script>

<template>
    <Head title="Experience - Ahmed Wael" />
    <PublicLayout>
        <div class="max-w-4xl mx-auto space-y-12 animate-fade-in-up">
            <div class="text-center space-y-4 mb-16">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-purple-400 mb-6 transform -rotate-3">
                    <Briefcase class="w-8 h-8" />
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Professional Journey</h1>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg pt-2">
                    My background in building scalable backends and leading projects from ideation to production.
                </p>
            </div>

            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-4 sm:before:mx-auto sm:before:w-0.5 sm:before:bg-gradient-to-b sm:before:from-purple-500 sm:before:via-indigo-500 sm:before:to-slate-800 before:bg-gradient-to-b before:from-purple-500 before:via-indigo-500 before:to-slate-800">
                
                <div v-for="(exp, index) in experiences" :key="exp.id" 
                     class="relative flex items-center justify-between sm:justify-normal sm:even:flex-row-reverse group"
                     :class="{'sm:even:text-right': true}">
                    
                    <!-- Timeline Node -->
                    <div class="absolute left-4 sm:left-1/2 w-4 h-4 rounded-full bg-slate-900 border-2 border-purple-500 transform -translate-x-1/2 sm:-translate-x-1/2 shadow-[0_0_10px_rgba(168,85,247,0.5)] group-hover:bg-purple-500 group-hover:scale-125 transition-all duration-300 z-10 flex-shrink-0"></div>

                    <!-- Content Card -->
                    <div class="w-full pl-10 sm:pl-0 sm:w-1/2 sm:px-8">
                        <div class="bg-slate-800/40 backdrop-blur-sm rounded-3xl p-6 sm:p-8 border border-white/5 group-hover:bg-slate-800/60 group-hover:border-purple-500/30 transition-all duration-500 shadow-lg group-hover:-translate-y-1">
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 bg-slate-900/80 rounded-full border border-slate-700 text-xs font-semibold text-purple-400 mb-4 sm:w-fit"
                                      :class="{'sm:ml-auto': index % 2 !== 0}">
                                    {{ formatDate(exp.start_date) }} - {{ formatDate(exp.end_date) }}
                                </span>
                                
                                <h3 class="text-2xl font-bold text-white">{{ exp.title }}</h3>
                                <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-2"
                                     :class="{ 'sm:justify-end': index % 2 !== 0 }">
                                    <a v-if="exp.company_url" :href="exp.company_url" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-indigo-400 hover:text-indigo-300 font-medium text-lg transition-colors">
                                        {{ exp.company }}
                                        <ExternalLink class="h-4 w-4" />
                                    </a>
                                    <p v-else class="text-indigo-400 font-medium text-lg">{{ exp.company }}</p>

                                    <p v-if="exp.work_location" class="inline-flex items-center gap-1.5 text-sm text-slate-400">
                                        <MapPin class="h-4 w-4 text-purple-400" />
                                        {{ exp.work_location }}
                                    </p>
                                </div>
                            </div>
                            
                            <ul v-if="exp.description && exp.description.length" class="space-y-3 mt-6 text-left">
                                <li v-for="(point, idx) in exp.description" :key="idx" class="text-slate-400 flex items-start gap-3">
                                    <span class="text-purple-500 mt-1 flex-shrink-0">▹</span>
                                    <span class="leading-relaxed">{{ point }}</span>
                                </li>
                            </ul>
                        </div>
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
