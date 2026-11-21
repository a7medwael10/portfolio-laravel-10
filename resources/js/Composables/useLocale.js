import { computed, onMounted, ref } from 'vue';

const STORAGE_KEY = 'portfolio-locale';

const locale = ref('en');

const translations = {
    en: {
        skipToContent: 'Skip to content',
        nav: {
            home: 'Home',
            about: 'About',
            skills: 'Skills',
            experience: 'Experience',
            projects: 'Projects',
            contact: 'Contact',
            viewCv: 'View CV',
            letsTalk: 'Let’s Talk',
            openMenu: 'Open menu',
            closeMenu: 'Close menu',
            switchToLight: 'Switch to light mode',
            switchToDark: 'Switch to dark mode',
            switchLanguage: 'التبديل إلى العربية',
            langButton: 'AR',
        },
        footer: {
            tagline: 'Engineering scalable systems and modern web experiences.',
            rights: 'All rights reserved.',
        },
        hero: {
            available: 'Available for new opportunities',
            greeting: 'Hello, I’m',
            defaultName: 'Ahmed Wael',
            defaultTitle: 'Software Engineer & Full-Stack Developer',
            defaultBio:
                'Full-Stack Developer specializing in building scalable web applications using Laravel for backend development and React for modern, responsive user interfaces.',
            viewProjects: 'View Projects',
            viewCv: 'View CV',
            contact: 'Contact',
            portraitSoon: 'Portrait coming soon',
            portraitAlt: 'portrait',
            githubProfile: 'GitHub profile',
            linkedinProfile: 'LinkedIn profile',
        },
        about: {
            label: 'About',
            title: 'About Me',
            education: 'Education',
            track: 'Track',
            grade: 'Grade',
            opensInNewTab: '(opens in new tab)',
            defaultParagraphs: [
                'I’m Ahmed Wael, a Full-Stack Developer specializing in building scalable web applications using Laravel for backend development and React for modern, responsive user interfaces.',
                'I have hands-on experience developing RESTful APIs, designing and optimizing MySQL and MongoDB databases, integrating third-party services, and building secure, maintainable systems. I follow clean-code practices and apply OOP, SOLID principles, and design patterns to create reliable solutions that can grow with business needs.',
                'I have worked on various projects, including restaurant management systems, e-commerce platforms, educational applications, reservation systems, logistics solutions, and administrative dashboards.',
                'My primary technologies include PHP, Laravel, JavaScript, React, Blade, Bootstrap, Tailwind CSS, MySQL, MongoDB, Git, Docker, and Linux. I’m also familiar with Vue.js, Filament, Express.js, Django, and AI-powered application development.',
                'I’m passionate about solving real-world problems, continuously improving my skills, and delivering high-quality products with strong performance, security, and user experience.',
            ],
        },
        skills: {
            label: 'Expertise',
            title: 'Technical Skills',
            description:
                'My core stack includes PHP, Laravel, Node.js, NestJS, JavaScript, React, Vue.js, and Next.js, supported by MySQL, MongoDB, Docker, and Git to build secure, scalable, and maintainable applications.',
            skillSingular: 'skill',
            skillPlural: 'skills',
        },
        experience: {
            label: 'Career',
            title: 'Experience',
            description:
                'Roles focused on scalable web applications, APIs, databases, and shipping maintainable systems.',
            opensInNewTab: '(opens in new tab)',
        },
        projects: {
            label: 'Work',
            title: 'Projects',
            description:
                'Selected work across restaurant, e-commerce, education, reservation, logistics, and admin platforms.',
            companyExperience: 'Company Experience',
            personalProject: 'Personal Project',
            freelance: 'Freelance',
            project: 'Project',
            viewDetails: 'View project details',
            prevProject: 'Previous project',
            nextProject: 'Next project',
            closeDetails: 'Close project details',
            aboutProject: 'About the project',
            noDescription: 'No project description is available yet.',
            technologies: 'Technologies & skills',
            github: 'GitHub',
            liveDemo: 'Live demo',
            noProjects: 'No projects available yet.',
            screenshotAlt: 'project screenshot',
        },
        contact: {
            label: 'Contact',
            title: 'Let’s Connect',
            description:
                'Open to new opportunities and interesting projects. Feel free to drop a message.',
            getInTouch: 'Get in touch',
            intro:
                'I’m a Software Engineer and Full-Stack Developer focused on building scalable, reliable, and user-friendly web applications. Have a project or opportunity in mind? Let’s connect.',
            email: 'Email',
            location: 'Location',
            defaultLocation: 'Mansoura, Egypt',
            phone: 'Phone',
            whatsapp: 'WhatsApp',
            nameLabel: 'Name',
            emailLabel: 'Email Address',
            messageLabel: 'Message',
            sendMessage: 'Send Message',
            sending: 'Sending…',
            successDefault: 'Message sent successfully!',
        },
        dates: {
            present: 'Present',
        },
        seo: {
            defaultDescription:
                'Software Engineer and Full-Stack Developer building scalable web applications, reliable APIs, and modern user experiences.',
        },
    },
    ar: {
        skipToContent: 'تخطي إلى المحتوى',
        nav: {
            home: 'الرئيسية',
            about: 'عني',
            skills: 'المهارات',
            experience: 'الخبرات',
            projects: 'المشاريع',
            contact: 'تواصل معي',
            viewCv: 'عرض السيرة الذاتية',
            letsTalk: 'تواصل معي',
            openMenu: 'فتح القائمة',
            closeMenu: 'إغلاق القائمة',
            switchToLight: 'التبديل إلى الوضع الفاتح',
            switchToDark: 'التبديل إلى الوضع الداكن',
            switchLanguage: 'Switch to English',
            langButton: 'EN',
        },
        footer: {
            tagline: 'هندسة أنظمة قابلة للتوسع وتجارب ويب حديثة.',
            rights: 'جميع الحقوق محفوظة.',
        },
        hero: {
            available: 'متاح لفرص عمل جديدة',
            greeting: 'مرحباً، أنا',
            defaultName: 'أحمد وائل',
            defaultTitle: 'مهندس برمجيات ومطور Full-Stack',
            defaultBio:
                'مطور Full-Stack متخصص في بناء تطبيقات ويب قابلة للتوسع باستخدام Laravel للواجهة الخلفية وReact وVue.js لواجهات مستخدم حديثة ومتجاوبة.',
            viewProjects: 'استعراض المشاريع',
            viewCv: 'عرض السيرة الذاتية',
            contact: 'تواصل معي',
            portraitSoon: 'الصورة الشخصية قريباً',
            portraitAlt: 'الصورة الشخصية',
            githubProfile: 'حساب GitHub',
            linkedinProfile: 'حساب LinkedIn',
        },
        about: {
            label: 'نبذة',
            title: 'عني',
            education: 'التعليم',
            track: 'التخصص',
            grade: 'التقدير',
            opensInNewTab: '(يفتح في تبويب جديد)',
            defaultParagraphs: [
                'أنا أحمد وائل، مطور Full-Stack متخصص في بناء تطبيقات ويب قابلة للتوسع باستخدام Laravel للباك إند وReact لواجهات مستخدم حديثة وسريعة الاستجابة.',
                'لدي خبرة عملية في تطوير واجهات برمجة التطبيقات RESTful APIs، وتصميم وتحسين قواعد بيانات MySQL وMongoDB، وربط الخدمات الخارجية، وبناء أنظمة آمنة وقابلة للصيانة وفق مبادئ Clean Code وOOP وSOLID وDesign Patterns.',
                'عملت على مشاريع متنوعة تشمل أنظمة إدارة المطاعم، ومنصات التجارة الإلكترونية، والتطبيقات التعليمية، وأنظمة الحجوزات، والحلول اللوجستية، ولوحات التحكم الإدارية.',
                'تشمل تقنياتي الأساسية PHP وLaravel وJavaScript وReact وBlade وBootstrap وTailwind CSS وMySQL وMongoDB وGit وDocker وLinux، بالإضافة إلى خبرة في Vue.js وFilament وExpress.js وDjango وتطوير التطبيقات المدعومة بالذكاء الاصطناعي.',
                'شغوف بحل المشكلات الواقعية، والتطوير المستمر لمهاراتي، وتقديم منتجات عالية الجودة بأفضل أداء وأمان وتجربة مستخدم.',
            ],
        },
        skills: {
            label: 'الخبرات التقنية',
            title: 'المهارات',
            description:
                'تشمل تقنياتي الأساسية PHP وLaravel وNode.js وNestJS وJavaScript وReact وVue.js وNext.js، مدعومة بـ MySQL وMongoDB وDocker وGit لبناء تطبيقات آمنة وقابلة للتوسع والصيانة.',
            skillSingular: 'مهارة',
            skillPlural: 'مهارات',
        },
        experience: {
            label: 'المسار المهني',
            title: 'الخبرات العملية',
            description:
                'أدوار وظيفية تركز على بناء تطبيقات ويب قابلة للتوسع، وتطوير الـ APIs، وقواعد البيانات، وإطلاق أنظمة سهلة الصيانة.',
            opensInNewTab: '(يفتح في تبويب جديد)',
        },
        projects: {
            label: 'الأعمال',
            title: 'المشاريع',
            description:
                'مختارات من أعمالي في منصات المطاعم، التجارة الإلكترونية، التعليم، الحجوزات، اللوجستيات، ولوحات التحكم.',
            companyExperience: 'خبرة شركة',
            personalProject: 'مشروع شخصي',
            freelance: 'عمل حر',
            project: 'مشروع',
            viewDetails: 'عرض تفاصيل المشروع',
            prevProject: 'المشروع السابق',
            nextProject: 'المشروع التالي',
            closeDetails: 'إغلاق تفاصيل المشروع',
            aboutProject: 'عن المشروع',
            noDescription: 'لا يوجد وصف متاح للمشروع حالياً.',
            technologies: 'التقنيات والمهارات',
            github: 'GitHub',
            liveDemo: 'معاينة حية',
            noProjects: 'لا توجد مشاريع متاحة حالياً.',
            screenshotAlt: 'صورة المشروع',
        },
        contact: {
            label: 'التواصل',
            title: 'لنتواصل',
            description:
                'متاح لفرص عمل جديدة ومشاريع مميزة. لا تتردد في إرسال رسالة.',
            getInTouch: 'تواصل معي مباشرة',
            intro:
                'أنا مهندس برمجيات ومطور Full-Stack أركز على بناء تطبيقات ويب موثوقة وقابلة للتوسع وسهلة الاستخدام. هل لديك مشروع أو فرصة عمل؟ يسعدني تواصلك.',
            email: 'البريد الإلكتروني',
            location: 'الموقع',
            defaultLocation: 'المنصورة، مصر',
            phone: 'الهاتف',
            whatsapp: 'واتساب',
            nameLabel: 'الاسم',
            emailLabel: 'البريد الإلكتروني',
            messageLabel: 'الرسالة',
            sendMessage: 'إرسال الرسالة',
            sending: 'جاري الإرسال…',
            successDefault: 'تم إرسال رسالتك بنجاح!',
        },
        dates: {
            present: 'حتى الآن',
        },
        seo: {
            defaultDescription:
                'مهندس برمجيات ومطور Full-Stack متخصص في بناء تطبيقات ويب قابلة للتوسع، وAPIs موثوقة، وتجارب مستخدم حديثة.',
        },
    },
};

const applyLocale = (value) => {
    const next = value === 'ar' ? 'ar' : 'en';
    locale.value = next;
    document.documentElement.setAttribute('lang', next);
    document.documentElement.setAttribute('dir', next === 'ar' ? 'rtl' : 'ltr');
    try {
        localStorage.setItem(STORAGE_KEY, next);
    } catch {
        // Ignore storage failures
    }
};

const resolveInitialLocale = () => {
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'ar' || stored === 'en') {
            return stored;
        }
    } catch {
        // Ignore
    }

    return 'en';
};

export function useLocale() {
    const isRtl = computed(() => locale.value === 'ar');

    const toggleLocale = () => {
        applyLocale(locale.value === 'ar' ? 'en' : 'ar');
    };

    const setLocale = (value) => {
        applyLocale(value);
    };

    const t = (path) => {
        const parts = path.split('.');
        let current = translations[locale.value] || translations.en;
        for (const part of parts) {
            if (current && Object.prototype.hasOwnProperty.call(current, part)) {
                current = current[part];
            } else {
                current = undefined;
                break;
            }
        }
        if (current !== undefined) {
            return current;
        }
        let fallback = translations.en;
        for (const part of parts) {
            if (fallback && Object.prototype.hasOwnProperty.call(fallback, part)) {
                fallback = fallback[part];
            } else {
                return path;
            }
        }
        return fallback;
    };

    const localized = (record, field) => {
        if (!record) return null;
        if (locale.value === 'ar') {
            const arValue = record[`${field}_ar`];
            if (Array.isArray(arValue) ? arValue.length > 0 : Boolean(arValue && String(arValue).trim())) {
                return arValue;
            }
        }
        return record[field] ?? null;
    };

    onMounted(() => {
        applyLocale(resolveInitialLocale());
    });

    return {
        locale,
        isRtl,
        toggleLocale,
        setLocale,
        t,
        localized,
    };
}
