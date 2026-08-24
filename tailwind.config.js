import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                canvas: {
                    DEFAULT: "var(--color-canvas)",
                    deep: "var(--color-canvas-deep)",
                },
                surface: {
                    DEFAULT: "var(--color-surface)",
                    elevated: "var(--color-surface-elevated)",
                    hover: "var(--color-surface-hover)",
                },
                primary: {
                    DEFAULT: "var(--color-primary)",
                    hover: "var(--color-primary-hover)",
                },
                accent: "var(--color-accent)",
                content: {
                    DEFAULT: "var(--color-text)",
                    secondary: "var(--color-text-secondary)",
                    muted: "var(--color-text-muted)",
                },
                line: {
                    DEFAULT: "var(--color-border)",
                    hover: "var(--color-border-hover)",
                },
                success: "var(--color-success)",
                danger: "var(--color-danger)",
            },
            maxWidth: {
                portfolio: "1200px",
            },
            borderRadius: {
                card: "18px",
                btn: "11px",
            },
            spacing: {
                nav: "72px",
            },
        },
    },

    plugins: [forms],
};
