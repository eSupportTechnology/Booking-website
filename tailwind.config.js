import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Lato", "sans-serif"], // Add Lato font as the default sans-serif font
                segoe: [
                    '"Segoe UI"',
                    "Tahoma",
                    "Geneva",
                    "Verdana",
                    "sans-serif",
                ],
            },
        },
    },

    plugins: [forms],
};
