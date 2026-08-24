import { onMounted, ref } from 'vue';

const STORAGE_KEY = 'portfolio-theme';

const theme = ref('dark');

const applyTheme = (value) => {
    const next = value === 'light' ? 'light' : 'dark';
    theme.value = next;
    document.documentElement.setAttribute('data-theme', next);
    try {
        localStorage.setItem(STORAGE_KEY, next);
    } catch {
        // Ignore storage failures (private mode, etc.)
    }
};

const resolveInitialTheme = () => {
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'light' || stored === 'dark') {
            return stored;
        }
    } catch {
        // Ignore
    }

    if (window.matchMedia('(prefers-color-scheme: light)').matches) {
        return 'light';
    }

    return 'dark';
};

export function useTheme() {
    const toggleTheme = () => {
        applyTheme(theme.value === 'dark' ? 'light' : 'dark');
    };

    onMounted(() => {
        applyTheme(resolveInitialTheme());
    });

    return {
        theme,
        toggleTheme,
        applyTheme,
    };
}
