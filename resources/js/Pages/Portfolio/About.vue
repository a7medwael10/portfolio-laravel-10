<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { ExternalLink, GraduationCap, MapPin } from 'lucide-vue-next';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
    education: {
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
    <Head title="About - Ahmed Wael" />
    <PublicLayout :cv-url="profile?.cv_url">
        <div class="max-w-5xl mx-auto space-y-12 py-8">
            
            <div class="space-y-3">
                <span class="text-xs font-mono-code text-cyan-400 uppercase tracking-widest">// Background & Expertise</span>
                <h1 class="text-4xl font-extrabold text-white">About Me</h1>
            </div>

            <!-- About Section Card with Large Clear Photo -->
            <div class="bg-[#0D1B2A] border border-[rgba(148,163,184,0.16)] rounded-2xl p-6 sm:p-8 space-y-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-6 border-b border-slate-800">
                    <div class="p-1 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-2xl shadow-xl shadow-cyan-500/20 shrink-0">
                        <img v-if="profile?.avatar_url || profile?.hero_image_url" 
                             :src="profile?.avatar_url || profile?.hero_image_url" 
                             alt="About Profile Photo" 
                             class="w-44 h-44 sm:w-56 sm:h-56 rounded-[14px] object-cover object-top filter contrast-[1.05]" />
                        <div v-else class="w-44 h-44 sm:w-56 sm:h-56 rounded-[14px] bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-5xl font-bold text-white">
                            AW
                        </div>
                    </div>

                    <div class="space-y-2 text-center sm:text-left">
                        <h2 class="text-3xl font-extrabold text-white">Ahmed Wael</h2>
                        <p class="text-sm font-mono-code text-cyan-400 font-semibold">Full-Stack Developer (Laravel & React)</p>
                        <div class="flex items-center justify-center sm:justify-start gap-2 text-slate-400 text-xs mt-1">
                            <MapPin class="w-3.5 h-3.5 text-cyan-400" />
                            <span>{{ profile?.location || 'Mansoura, Egypt' }}</span>
                        </div>
                        <div class="pt-2 flex flex-wrap justify-center sm:justify-start gap-2 text-xs font-mono-code">
                            <span class="px-2.5 py-1 rounded bg-[#11243A] text-slate-300 border border-slate-700">ITI Open Source Track</span>
                            <span class="px-2.5 py-1 rounded bg-[#11243A] text-slate-300 border border-slate-700">B.Sc. Computers & Control</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 text-slate-300 leading-relaxed text-base">
                    <p>
                        I’m Ahmed Wael, a Full-Stack Developer specializing in building scalable web applications using <strong class="text-white">Laravel</strong> for backend development and <strong class="text-white">React</strong> for modern, responsive user interfaces.
                    </p>
                    <p>
                        I have hands-on experience developing RESTful APIs, designing and optimizing MySQL and MongoDB databases, integrating third-party services, and building secure, maintainable systems. I follow clean-code practices and apply OOP, SOLID principles, and design patterns to create reliable solutions that can grow with business needs.
                    </p>
                    <p>
                        I have worked on various projects, including restaurant management systems, e-commerce platforms, educational applications, reservation systems, logistics solutions, and administrative dashboards.
                    </p>
                    <p>
                        My primary technologies include PHP, Laravel, JavaScript, React, Blade, Bootstrap, Tailwind CSS, MySQL, MongoDB, Git, Docker, and Linux. I’m also familiar with Vue.js, Filament, Express.js, Django, and AI-powered application development.
                    </p>
                    <p>
                        I’m passionate about solving real-world problems, continuously improving my skills, and delivering high-quality products with strong performance, security, and user experience.
                    </p>
                </div>
            </div>

            <!-- Education Section -->
            <div v-if="education && education.length > 0" class="space-y-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <GraduationCap class="w-6 h-6 text-cyan-400" />
                    <span>Education & Training</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div v-for="edu in education" :key="edu.id" class="bg-[#0D1B2A] border border-[rgba(148,163,184,0.16)] rounded-2xl p-6 space-y-3">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-bold text-white">{{ edu.degree }}</h3>
                            <span class="px-2.5 py-1 bg-[#11243A] rounded-full text-xs font-mono-code text-cyan-300">
                                {{ formatDate(edu.start_date) }} - {{ formatDate(edu.end_date) }}
                            </span>
                        </div>

                        <a v-if="edu.institution_url" :href="edu.institution_url" target="_blank" rel="noopener" class="text-sm text-blue-400 hover:underline flex items-center gap-1">
                            <span>{{ edu.institution }}</span>
                            <ExternalLink class="w-3.5 h-3.5" />
                        </a>
                        <p v-else class="text-sm text-blue-400">{{ edu.institution }}</p>

                        <p v-if="edu.field_of_study" class="text-xs text-slate-400">Track: <span class="text-slate-200">{{ edu.field_of_study }}</span></p>
                        <p v-if="edu.grade" class="text-xs text-cyan-300 font-mono-code">Grade: {{ edu.grade }}</p>

                        <ul v-if="edu.description && edu.description.length" class="space-y-1.5 pt-2 text-xs text-slate-300 border-t border-slate-800">
                            <li v-for="(point, idx) in edu.description" :key="idx" class="flex items-start gap-2">
                                <span class="text-cyan-400">▹</span>
                                <span>{{ point }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </PublicLayout>
</template>
