<script setup>
import { computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import HeroSection from "@/Components/Portfolio/HeroSection.vue";
import AboutSection from "@/Components/Portfolio/AboutSection.vue";
import SkillsSection from "@/Components/Portfolio/SkillsSection.vue";
import ExperienceSection from "@/Components/Portfolio/ExperienceSection.vue";
import ProjectsSection from "@/Components/Portfolio/ProjectsSection.vue";
import ContactSection from "@/Components/Portfolio/ContactSection.vue";

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

const formatDate = (dateString) => {
    if (!dateString) return "Present";
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
    });
};

const getMainImage = (project) => {
    if (project.main_image_url) {
        return project.main_image_url;
    }

    if (project.images && project.images.length > 0) {
        const main = project.images.find((img) => img.is_main);
        const image = main || project.images[0];

        if (image.image_url) {
            return image.image_url;
        }

        if (image.image_path) {
            return image.image_path.startsWith("http")
                ? image.image_path
                : `/media/images/${image.image_path.replace(/^storage\//, "")}`;
        }
    }

    return null;
};

const contactForm = useForm({
    name: "",
    email: "",
    message: "",
});

const submitContact = () => {
    contactForm.post(route("contact.store"), {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset();
        },
    });
};

const prefersReducedMotion = () =>
    typeof window !== "undefined" &&
    window.matchMedia("(prefers-reduced-motion: reduce)").matches;

const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({
            behavior: prefersReducedMotion() ? "auto" : "smooth",
        });
    }
};
const seoTitle = computed(() => {
    const name = props.profile?.name || "Ahmed Wael";
    const title = props.profile?.title || "Software Engineer & Full-Stack Developer";
    return `${name} | ${title}`;
});

const seoDescription = computed(
    () =>
        props.profile?.bio ||
        "Software Engineer and Full-Stack Developer building scalable web applications, reliable APIs, and modern user experiences."
);

const ogImage = computed(
    () => props.profile?.hero_image_url || props.profile?.avatar_url || "/images/logo.png"
);
</script>

<template>
    <Head :title="seoTitle">
        <meta
            head-key="description"
            name="description"
            :content="seoDescription"
        />
        <meta head-key="og:type" property="og:type" content="website" />
        <meta head-key="og:title" property="og:title" :content="seoTitle" />
        <meta
            head-key="og:description"
            property="og:description"
            :content="seoDescription"
        />
        <meta head-key="og:image" property="og:image" :content="ogImage" />
        <meta head-key="og:url" property="og:url" :content="route('home')" />
        <meta
            head-key="twitter:card"
            name="twitter:card"
            content="summary_large_image"
        />
        <meta head-key="twitter:title" name="twitter:title" :content="seoTitle" />
        <meta
            head-key="twitter:description"
            name="twitter:description"
            :content="seoDescription"
        />
        <meta head-key="twitter:image" name="twitter:image" :content="ogImage" />
    </Head>

    <PublicLayout :profile="profile">
        <HeroSection :profile="profile" @navigate="scrollToSection" />
        <AboutSection
            :profile="profile"
            :education="education"
            :format-date="formatDate"
        />
        <SkillsSection :categories="categories" />
        <ExperienceSection
            :experiences="experiences"
            :format-date="formatDate"
        />
        <ProjectsSection :projects="projects" :get-main-image="getMainImage" />
        <ContactSection
            :profile="profile"
            :contact-form="contactForm"
            :submit-contact="submitContact"
        />
    </PublicLayout>
</template>
