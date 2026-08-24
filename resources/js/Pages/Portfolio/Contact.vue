<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Send, MapPin, Mail, Phone, Loader2 } from 'lucide-vue-next';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const phone = computed(() => props.profile?.phone || '+201212808098');
const email = computed(() => props.profile?.email || 'ahmed.wael1025@gmail.com');
const location = computed(() => props.profile?.location || 'Mansoura, Egypt');
const whatsappUrl = computed(() => {
    if (props.profile?.whatsapp_url) {
        return props.profile.whatsapp_url;
    }
    const digitsOnly = phone.value.replace(/\D/g, '');
    return digitsOnly ? `https://wa.me/${digitsOnly}` : 'https://wa.me/201212808098';
});

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Contact - Ahmed Wael" />
    <PublicLayout :profile="profile">
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
                        <a :href="`mailto:${email}`" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <Mail class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Email</p>
                                <p class="text-lg text-white font-medium group-hover:text-emerald-400 transition-colors">{{ email }}</p>
                            </div>
                        </a>
                        
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <MapPin class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Location</p>
                                <p class="text-lg text-white font-medium">{{ location }}</p>
                            </div>
                        </div>
                        
                        <a :href="`tel:${phone}`" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <Phone class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Phone</p>
                                <p class="text-lg text-white font-medium group-hover:text-emerald-400 transition-colors">{{ phone }}</p>
                            </div>
                        </a>

                        <a :href="whatsappUrl" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-800/80 rounded-xl flex items-center justify-center border border-slate-700 group-hover:border-emerald-500/50 group-hover:text-emerald-400 transition-colors text-slate-300">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.461c-1.826 0-3.606-.492-5.161-1.424l-.37-.22-3.834 1.006 1.024-3.737-.241-.383A10.37 10.37 0 0 1 2.3 12.002C2.3 6.645 6.645 2.3 12.001 2.3c2.595 0 5.034 1.011 6.87 2.846A9.66 9.66 0 0 1 21.7 12.002c0 5.357-4.345 9.701-9.649 9.701m8.536-18.237A11.93 11.93 0 0 0 12.001 0C5.384 0 .01 5.373.01 11.998c0 2.113.551 4.177 1.597 5.99L0 24l6.155-1.614a11.94 11.94 0 0 0 5.845 1.513h.005c6.616 0 11.99-5.373 11.99-11.999 0-3.206-1.249-6.219-3.517-8.487"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">WhatsApp</p>
                                <p class="text-lg text-white font-medium group-hover:text-emerald-400 transition-colors">{{ phone }}</p>
                            </div>
                        </a>
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
