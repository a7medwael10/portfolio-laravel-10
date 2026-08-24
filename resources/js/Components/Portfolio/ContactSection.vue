<script setup>
import { Github, Linkedin, Loader2, Mail, MapPin, Phone, Send } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import SectionHeader from '@/Components/Portfolio/SectionHeader.vue';

defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    contactForm: {
        type: Object,
        required: true,
    },
    submitContact: {
        type: Function,
        required: true,
    },
});

const page = usePage();
</script>

<template>
    <section id="contact" class="portfolio-section pb-16 md:pb-20">
        <SectionHeader
            label="Contact"
            title="Let’s Connect"
            description="Open to new opportunities and interesting projects. Feel free to drop a message."
        />

        <div class="portfolio-card overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <!-- Details -->
                <div class="border-b border-line p-6 sm:p-8 lg:border-b-0 lg:border-r lg:p-10">
                    <h3 class="text-2xl font-bold text-content">Get in touch</h3>
                    <p class="mt-3 max-w-md text-content-secondary leading-relaxed">
                      I’m a Software Engineer and Full-Stack Developer focused on building scalable, reliable, and user-friendly web applications. Have a project or opportunity in mind? Let’s connect.
                    </p>

                    <ul class="mt-8 space-y-5">
                        <li class="flex items-start gap-4">
                            <span
                                class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-btn border border-line bg-surface-elevated text-primary"
                                aria-hidden="true"
                            >
                                <Mail class="h-5 w-5" />
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm text-content-muted">Email</p>
                                <a
                                    :href="`mailto:${profile?.email || 'ahmed.wael1025@gmail.com'}`"
                                    class="break-all text-base font-medium text-content transition-colors hover:text-primary"
                                >
                                    {{ profile?.email || 'ahmed.wael1025@gmail.com' }}
                                </a>
                            </div>
                        </li>

                        <li class="flex items-start gap-4">
                            <span
                                class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-btn border border-line bg-surface-elevated text-primary"
                                aria-hidden="true"
                            >
                                <MapPin class="h-5 w-5" />
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm text-content-muted">Location</p>
                                <p class="text-base font-medium text-content">
                                    {{ profile?.location || 'Mansoura, Egypt' }}
                                </p>
                            </div>
                        </li>

                        <li class="flex items-start gap-4">
                            <span
                                class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-btn border border-line bg-surface-elevated text-primary"
                                aria-hidden="true"
                            >
                                <Phone class="h-5 w-5" />
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm text-content-muted">Phone</p>
                                <a
                                    :href="`tel:${profile?.phone || '+201212808098'}`"
                                    class="break-all text-base font-medium text-content transition-colors hover:text-primary"
                                >
                                    {{ profile?.phone || '+201212808098' }}
                                </a>
                            </div>
                        </li>

                        <li class="flex items-start gap-4">
                            <span
                                class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-btn border border-line bg-surface-elevated text-primary"
                                aria-hidden="true"
                            >
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.461c-1.826 0-3.606-.492-5.161-1.424l-.37-.22-3.834 1.006 1.024-3.737-.241-.383A10.37 10.37 0 0 1 2.3 12.002C2.3 6.645 6.645 2.3 12.001 2.3c2.595 0 5.034 1.011 6.87 2.846A9.66 9.66 0 0 1 21.7 12.002c0 5.357-4.345 9.701-9.649 9.701m8.536-18.237A11.93 11.93 0 0 0 12.001 0C5.384 0 .01 5.373.01 11.998c0 2.113.551 4.177 1.597 5.99L0 24l6.155-1.614a11.94 11.94 0 0 0 5.845 1.513h.005c6.616 0 11.99-5.373 11.99-11.999 0-3.206-1.249-6.219-3.517-8.487"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm text-content-muted">WhatsApp</p>
                                <a
                                    :href="profile?.whatsapp_url || `https://wa.me/${(profile?.phone || '+201212808098').replace(/\D/g, '')}`"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="break-all text-base font-medium text-content transition-colors hover:text-primary"
                                >
                                    {{ profile?.phone || '+201212808098' }}
                                </a>
                            </div>
                        </li>
                    </ul>

                    <div
                        v-if="profile?.github_url || profile?.linkedin_url"
                        class="mt-8 flex items-center gap-3"
                    >
                        <a
                            v-if="profile?.github_url"
                            :href="profile.github_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-muted transition-colors hover:border-line-hover hover:text-content"
                            aria-label="GitHub profile"
                        >
                            <Github class="h-5 w-5" aria-hidden="true" />
                        </a>
                        <a
                            v-if="profile?.linkedin_url"
                            :href="profile.linkedin_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-btn border border-line text-content-muted transition-colors hover:border-line-hover hover:text-content"
                            aria-label="LinkedIn profile"
                        >
                            <Linkedin class="h-5 w-5" aria-hidden="true" />
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="bg-surface-elevated/40 p-6 sm:p-8 lg:p-10">
                    <div
                        v-if="page.props.flash?.success"
                        class="mb-6 rounded-btn border border-success/40 bg-success/10 px-4 py-3 text-center font-medium text-success"
                        role="status"
                    >
                        {{ page.props.flash.success }}
                    </div>

                    <form class="space-y-5" @submit.prevent="submitContact">
                        <div class="space-y-2">
                            <label for="contact-name" class="block text-sm font-medium text-content-secondary">
                                Name
                            </label>
                            <input
                                id="contact-name"
                                v-model="contactForm.name"
                                type="text"
                                required
                                autocomplete="name"
                                class="form-input"
                            />
                            <p
                                v-if="contactForm.errors.name"
                                class="text-sm text-danger"
                                role="alert"
                            >
                                {{ contactForm.errors.name }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label for="contact-email" class="block text-sm font-medium text-content-secondary">
                                Email Address
                            </label>
                            <input
                                id="contact-email"
                                v-model="contactForm.email"
                                type="email"
                                required
                                autocomplete="email"
                                class="form-input"
                            />
                            <p
                                v-if="contactForm.errors.email"
                                class="text-sm text-danger"
                                role="alert"
                            >
                                {{ contactForm.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label for="contact-message" class="block text-sm font-medium text-content-secondary">
                                Message
                            </label>
                            <textarea
                                id="contact-message"
                                v-model="contactForm.message"
                                rows="5"
                                required
                                class="form-input resize-y min-h-[8rem]"
                            />
                            <p
                                v-if="contactForm.errors.message"
                                class="text-sm text-danger"
                                role="alert"
                            >
                                {{ contactForm.errors.message }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="btn-primary w-full"
                            :disabled="contactForm.processing"
                        >
                            <span v-if="!contactForm.processing">Send Message</span>
                            <span v-else>Sending…</span>
                            <Loader2
                                v-if="contactForm.processing"
                                class="h-5 w-5 animate-spin"
                                aria-hidden="true"
                            />
                            <Send
                                v-else
                                class="h-4 w-4"
                                aria-hidden="true"
                            />
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
