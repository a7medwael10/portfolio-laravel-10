<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Send, MapPin, Mail, Phone, Loader2 } from 'lucide-vue-next';

// You could pass the profile as a prop if you want to show the specific contact info dynamically
const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            // You can also add some toast notification here
        },
    });
};
</script>

<template>
    <Head title="Contact - Ahmed Wael" />
    <PublicLayout>
        <div class="max-w-6xl mx-auto space-y-12 animate-fade-in-up mb-12">
            <div class="text-center space-y-4 mb-16">
                <div class="mx-auto w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700 shadow-lg text-emerald-400 mb-6 transform -rotate-3">
                    <Send class="w-8 h-8" />
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Let's Connect</h1>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg pt-2">
                    Open to new opportunities and interesting projects. Feel free to drop a message.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                
                <!-- Contact Info -->
                <div class="space-y-8 lg:sticky lg:top-32">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">Get in touch</h3>
                        <p class="text-slate-400 leading-relaxed">
                            I'm currently looking for new opportunities as a Backend Developer. Whether you have a question or just want to say hi, I'll try my best to get back to you!
                        </p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <Mail class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Email</p>
                                <p class="text-lg text-white font-medium">ahmed.wael1025@gmail.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <MapPin class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Location</p>
                                <p class="text-lg text-white font-medium">Mansoura, Egypt</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <Phone class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Phone</p>
                                <p class="text-lg text-white font-medium">+201212808098</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-slate-800/30 backdrop-blur-md rounded-3xl p-8 sm:p-10 border border-white/5 shadow-2xl relative overflow-hidden">
                    <!-- Success state banner overlay -->
                    <div v-if="$page.props.flash?.success" class="absolute top-0 left-0 right-0 bg-emerald-500/20 border-b border-emerald-500/50 px-6 py-4 backdrop-blur-md z-10 flex items-center text-emerald-400 justify-center font-medium">
                        {{ $page.props.flash.success }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-6 pt-4">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-slate-300">Name</label>
                            <input id="name" v-model="form.name" type="text" required
                                   class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                   placeholder="John Doe" />
                            <div v-if="form.errors.name" class="text-red-400 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-slate-300">Email Address</label>
                            <input id="email" v-model="form.email" type="email" required
                                   class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                   placeholder="john@example.com" />
                            <div v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-medium text-slate-300">Message</label>
                            <textarea id="message" v-model="form.message" rows="5" required
                                      class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all resize-none"
                                      placeholder="What's on your mind?"></textarea>
                            <div v-if="form.errors.message" class="text-red-400 text-sm mt-1">{{ form.errors.message }}</div>
                        </div>

                        <button type="submit" :disabled="form.processing"
                                class="w-full group relative px-8 py-3.5 font-semibold text-white rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 transition-all duration-300 shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span v-if="!form.processing">Send Message</span>
                            <span v-else>Sending...</span>
                            <Loader2 v-if="form.processing" class="w-5 h-5 animate-spin" />
                            <Send v-else class="w-5 h-5 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform" />
                        </button>
                    </form>
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
