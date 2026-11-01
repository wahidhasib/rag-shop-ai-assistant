import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "ziggy-js";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    withApp: (app) => {
        app.directive("focus", {
            mounted: (el: HTMLElement, binding) => {
                if (binding.value !== false) {
                    el.focus();
                }
            },
        });

        app.use(ZiggyVue);
    },
    progress: {
        color: "#4B5563",
    },
});
