<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { 
    ArrowRight, Github, Linkedin, Mail, MapPin, GraduationCap, 
    ExternalLink, Layers, Briefcase, MonitorSmartphone, Send, Phone, Loader2, Download, Building2, User
} from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    education: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    experiences: {
        type: Array,
        default: () => [],
    },
    projects: {
        type: Array,
        default: () => [],
    },
});

// Helper functions
const formatDate = (dateString) => {
    if (!dateString) return 'Present';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};

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

// Contact Form State
const contactForm = useForm({
    name: '',
    email: '',
    message: '',
});

const submitContact = () => {
    contactForm.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset();
        },
    });
};

const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>

<template>
    <Head title="Ahmed Wael - Full Stack / Backend Developer" />
    <PublicLayout>
        <!-- HERO SECTION -->
        <section id="home" class="scroll-mt-28 flex items-center justify-center min-h-[75vh] py-12">
            <div class="text-center space-y-8 animate-fade-in-up max-w-3xl mx-auto">
                <div class="inline-block mb-2 p-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm">
                    <div class="flex items-center gap-2 px-4 py-1 text-sm text-cyan-400">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                        </span>
                        Available for new opportunities
                    </div>
                </div>

                <div v-if="profile?.hero_image_url" class="mb-6">
                    <img :src="profile.hero_image_url" alt="Profile Photo" class="w-44 h-44 md:w-56 md:h-56 rounded-full mx-auto object-cover border-4 border-slate-800 shadow-[0_0_28px_rgba(99,102,241,0.55)] transition-transform hover:scale-105 duration-300" />
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-6">
                    Hi, I'm <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400">{{ profile?.name || 'Ahmed Wael' }}</span>
                </h1>
                
                <h2 class="text-2xl md:text-3xl font-medium text-slate-300 mb-6">
                    {{ profile?.title || 'Backend Developer' }}
                </h2>
                
                <p class="text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed mb-10">
                    {{ profile?.bio || 'Building scalable backends and optimizing RESTful APIs.' }}
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a v-if="profile?.cv_url" :href="profile.cv_url" download target="_blank" class="px-8 py-3 font-semibold text-cyan-300 rounded-full border border-cyan-500/50 hover:border-cyan-400 hover:text-white hover:bg-cyan-500/10 transition-all duration-300 flex items-center gap-2 cursor-pointer shadow-[0_0_15px_rgba(34,211,238,0.25)]">
                        <Download class="w-5 h-5" />
                        Download CV
                    </a>

                    <a href="#projects" @click.prevent="scrollToSection('projects')" class="group relative px-8 py-3 font-semibold text-white rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 transition-all duration-300 shadow-[0_0_20px_rgba(99,102,241,0.4)] hover:shadow-[0_0_30px_rgba(99,102,241,0.6)] flex items-center gap-2 cursor-pointer">
                        View Projects
                        <ArrowRight class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                    </a>
                    
                    <a href="#contact" @click.prevent="scrollToSection('contact')" class="px-8 py-3 font-semibold text-slate-300 rounded-full border border-slate-600 hover:border-slate-400 hover:text-white transition-all duration-300 flex items-center gap-2 hover:bg-slate-800/50 cursor-pointer">
                        <Mail class="w-5 h-5" />
                        Contact Me
                    </a>
                </div>
                
                <div class="flex items-center justify-center gap-6 mt-12">
                    <a v-if="profile?.github_url" :href="profile.github_url" target="_blank" class="text-slate-400 hover:text-white hover:scale-110 transition-all duration-300">
                        <span class="sr-only">GitHub</span>
                        <Github class="w-6 h-6" />
                    </a>
                    <a v-if="profile?.linkedin_url" :href="profile.linkedin_url" target="_blank" class="text-slate-400 hover:text-[#0A66C2] hover:scale-110 transition-all duration-300">
                        <span class="sr-only">LinkedIn</span>
                        <Linkedin class="w-6 h-6" />
                    </a>
                </div>
            </div>
        </section>

        <!-- ABOUT & EDUCATION SECTION -->
        <section id="about" class="scroll-mt-28 max-w-4xl mx-auto space-y-16 py-8">
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <div v-if="profile?.avatar_url" class="flex-shrink-0">
                        <img :src="profile.avatar_url" alt="About Profile" class="h-28 w-28 md:h-36 md:w-36 rounded-2xl object-cover shadow-lg border-2 border-cyan-500 transform rotate-3 hover:rotate-0 transition-transform duration-300" />
                    </div>
                    <div v-else class="flex-shrink-0 h-28 w-28 md:h-36 md:w-36 bg-gradient-to-br from-indigo-500 to-cyan-400 rounded-2xl flex items-center justify-center transform rotate-3 shadow-lg">
                        <span class="text-5xl font-bold text-white">{{ profile?.name?.charAt(0) || 'A' }}</span>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white">About Me</h2>
                        <div class="flex items-center gap-2 text-slate-400 mt-1">
                            <MapPin class="w-4 h-4 text-cyan-400" />
                            <span>{{ profile?.location || 'Location not specified' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/50 backdrop-blur-md rounded-3xl p-8 border border-white/5 shadow-xl hover:border-white/10 transition-colors">
                    <p class="text-lg text-slate-300 leading-relaxed">
                        {{ profile?.about_text || profile?.bio }}
                    </p>
                </div>
            </div>

            <!-- Education Subsection -->
            <div v-if="education && education.length > 0" class="space-y-8">
                <div class="flex items-center gap-4">
                    <GraduationCap class="w-8 h-8 text-cyan-400" />
                    <h3 class="text-3xl font-bold text-white">Education</h3>
                </div>

                <div class="space-y-6">
                    <div v-for="edu in education" :key="edu.id" 
                         class="group relative pl-8 before:absolute before:inset-y-0 before:left-0 before:w-px before:bg-slate-700 hover:before:bg-cyan-500 before:transition-colors">
                        
                        <div class="absolute left-[-4px] top-2 h-2 w-2 rounded-full bg-slate-600 group-hover:bg-cyan-400 group-hover:shadow-[0_0_10px_rgba(34,211,238,0.8)] transition-all duration-300"></div>
                        
                        <div class="bg-slate-800/30 backdrop-blur-sm rounded-2xl p-6 border border-white/5 group-hover:bg-slate-800/50 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4">
                                <div>
                                    <h4 class="text-xl font-bold text-white">{{ edu.degree }}</h4>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-2">
                                        <a v-if="edu.institution_url" :href="edu.institution_url" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                                            {{ edu.institution }}
                                            <ExternalLink class="h-4 w-4" />
                                        </a>
                                        <p v-else class="text-indigo-400 font-medium">{{ edu.institution }}</p>

                                        <p v-if="edu.location" class="inline-flex items-center gap-1.5 text-sm text-slate-400">
                                            <MapPin class="h-4 w-4 text-cyan-400" />
                                            {{ edu.location }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 sm:mt-0 px-3 py-1 bg-slate-800 rounded-full border border-slate-700 text-sm text-slate-300 whitespace-nowrap">
                                    {{ formatDate(edu.start_date) }} - {{ formatDate(edu.end_date) }}
                                </div>
                            </div>

                            <p v-if="edu.field_of_study" class="text-slate-400 mb-2">Track: <span class="text-slate-300">{{ edu.field_of_study }}</span></p>
                            <p v-if="edu.grade" class="text-slate-400 mb-4">Grade: <span class="text-slate-300">{{ edu.grade }}</span></p>

                            <ul v-if="edu.description && edu.description.length" class="space-y-2 mt-4">
                                <li v-for="(point, idx) in edu.description" :key="idx" class="text-slate-400 flex items-start gap-2">
                                    <span class="text-cyan-500 mt-1.5 text-xs">▹</span>
                                    <span>{{ point }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SKILLS SECTION -->
        <section id="skills" class="scroll-mt-28 max-w-6xl mx-auto space-y-12 py-8">
            <div class="text-center space-y-4 mb-12">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-indigo-400 mb-6 transform rotate-3">
                    <Layers class="w-8 h-8" />
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Technical Arsenal</h2>
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
        </section>

        <!-- EXPERIENCE SECTION -->
        <section id="experience" class="scroll-mt-28 max-w-4xl mx-auto space-y-12 py-8">
            <div class="text-center space-y-4 mb-12">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-purple-400 mb-6 transform -rotate-3">
                    <Briefcase class="w-8 h-8" />
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Professional Journey</h2>
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
        </section>

        <!-- PROJECTS SECTION -->
        <section id="projects" class="scroll-mt-28 max-w-7xl mx-auto space-y-12 py-8">
            <div class="text-center space-y-4 mb-12">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-cyan-400 mb-6 transform rotate-3">
                    <MonitorSmartphone class="w-8 h-8" />
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Featured Projects</h2>
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
        </section>

        <!-- CONTACT SECTION -->
        <section id="contact" class="scroll-mt-28 max-w-6xl mx-auto space-y-12 py-8 mb-12">
            <div class="text-center space-y-4 mb-12">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-emerald-400 mb-6 transform -rotate-3">
                    <Send class="w-8 h-8" />
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Let's Connect</h2>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg pt-2">
                    Open to new opportunities and interesting projects. Feel free to drop a message.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">Get in touch</h3>
                        <p class="text-slate-400 leading-relaxed">
                            I'm currently looking for new opportunities as a Backend / Full Stack Developer. Whether you have a question or just want to say hi, I'll try my best to get back to you!
                        </p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <Mail class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Email</p>
                                <a :href="`mailto:${profile?.email || 'ahmed.wael1025@gmail.com'}`" class="text-lg text-white font-medium hover:text-emerald-400 transition-colors">
                                    {{ profile?.email || 'ahmed.wael1025@gmail.com' }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <MapPin class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Location</p>
                                <p class="text-lg text-white font-medium">{{ profile?.location || 'Mansoura, Egypt' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <Phone class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Phone</p>
                                <p class="text-lg text-white font-medium">{{ profile?.phone || '+201212808098' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-slate-800/30 backdrop-blur-md rounded-3xl p-8 sm:p-10 border border-white/5 shadow-2xl relative overflow-hidden">
                    <!-- Success state banner overlay -->
                    <div v-if="$page.props.flash?.success" class="mb-6 bg-emerald-500/20 border border-emerald-500/50 rounded-xl p-4 text-emerald-400 text-center font-medium">
                        {{ $page.props.flash.success }}
                    </div>

                    <form @submit.prevent="submitContact" class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-slate-300">Name</label>
                            <input id="name" v-model="contactForm.name" type="text" required
                                   class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                   placeholder="John Doe" />
                            <div v-if="contactForm.errors.name" class="text-red-400 text-sm mt-1">{{ contactForm.errors.name }}</div>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-slate-300">Email Address</label>
                            <input id="email" v-model="contactForm.email" type="email" required
                                   class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                   placeholder="john@example.com" />
                            <div v-if="contactForm.errors.email" class="text-red-400 text-sm mt-1">{{ contactForm.errors.email }}</div>
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-medium text-slate-300">Message</label>
                            <textarea id="message" v-model="contactForm.message" rows="5" required
                                      class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all resize-none"
                                      placeholder="What's on your mind?"></textarea>
                            <div v-if="contactForm.errors.message" class="text-red-400 text-sm mt-1">{{ contactForm.errors.message }}</div>
                        </div>

                        <button type="submit" :disabled="contactForm.processing"
                                class="w-full group relative px-8 py-3.5 font-semibold text-white rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 transition-all duration-300 shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span v-if="!contactForm.processing">Send Message</span>
                            <span v-else>Sending...</span>
                            <Loader2 v-if="contactForm.processing" class="w-5 h-5 animate-spin" />
                            <Send v-else class="w-5 h-5 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform" />
                        </button>
                    </form>
                </div>

            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
