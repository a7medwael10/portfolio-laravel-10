<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { ExternalLink, Github, MonitorSmartphone, Building2, Briefcase, User } from 'lucide-vue-next';

defineProps({
    projects: {
        type: Array,
        required: true,
    }
});

const getMainImage = (project) => {
    if (project.main_image_url) {
        return project.main_image_url;
    }

    if (project.images && project.images.length > 0) {
        const main = project.images.find(img => img.is_main);
        const image = main || project.images[0];

        if (image.image_url) {
            return image.image_url;
        }

        if (image.image_path) {
            return image.image_path.startsWith('http') ? image.image_path : `/storage/${image.image_path}`;
        }
    }

    return `https://dummyimage.com/1200x800/1e293b/6366f1.png&text=${encodeURIComponent(project.title)}`;
};
</script>

<template>
    <Head title="Projects - Ahmed Wael" />
    <PublicLayout>
        <div class="max-w-7xl mx-auto space-y-12 animate-fade-in-up">
            <div class="text-center space-y-4 mb-16">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-cyan-400 mb-6 transform rotate-3">
                    <MonitorSmartphone class="w-8 h-8" />
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Featured Projects</h1>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg pt-2">
                    A selection of the technical challenges I've tackled and products I've delivered.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <div v-for="project in projects" :key="project.id" 
                     class="group flex flex-col bg-slate-800/30 backdrop-blur-md rounded-3xl overflow-hidden border border-white/5 hover:border-cyan-500/30 hover:bg-slate-800/60 transition-all duration-500 shadow-xl hover:shadow-2xl hover:-translate-y-2">
                    
                    <div class="relative w-full overflow-hidden shrink-0" style="padding-bottom: 60%;">
                        <img :src="getMainImage(project)" :alt="project.title" 
                             class="absolute inset-0 w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105" />
                        
                        <!-- Overlay Links -->
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4 backdrop-blur-sm">
                            <a v-if="project.github_url" :href="project.github_url" target="_blank" 
                               class="bg-white/10 hover:bg-white text-white hover:text-slate-900 p-4 rounded-full transition-colors duration-300 shadow-lg backdrop-blur-md">
                                <Github class="w-6 h-6" />
                            </a>
                            <a v-if="project.live_url" :href="project.live_url" target="_blank" 
                               class="bg-cyan-500 hover:bg-cyan-400 text-white p-4 rounded-full transition-colors duration-300 shadow-[0_0_15px_rgba(34,211,238,0.5)] cursor-pointer">
                                <ExternalLink class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-8 flex flex-col flex-grow">
                        <!-- Project Category/Company Badge -->
                        <div class="flex items-center gap-2 mb-3">
                            <span v-if="project.experience || project.type === 'company'" 
                                  class="inline-flex items-center gap-1.5 px-3 py-1 bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xs font-semibold rounded-full">
                                <Building2 class="w-3.5 h-3.5" />
                                {{ project.experience ? project.experience.company : 'Company Experience' }}
                            </span>
                            <span v-else-if="project.type === 'personal'" 
                                  class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-xs font-semibold rounded-full">
                                <User class="w-3.5 h-3.5" />
                                Personal Project
                            </span>
                            <span v-else 
                                  class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold rounded-full">
                                <Briefcase class="w-3.5 h-3.5" />
                                Freelance
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-cyan-300 transition-colors">{{ project.title }}</h3>
                        
                        <p class="text-slate-400 leading-relaxed mb-8 flex-grow">
                            {{ project.description }}
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mt-auto">
                            <span v-for="skill in project.skills" :key="skill.id"
                                  class="px-3 py-1 bg-slate-900/80 border border-slate-700/50 text-indigo-300 text-xs font-medium rounded-lg">
                                {{ skill.name }}
                            </span>
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
