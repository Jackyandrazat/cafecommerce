import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";
import "../css/app.css";
import "primeicons/primeicons.css";
import { ZiggyVue } from "ziggy-js";
import { route } from "ziggy-js";
import { Ziggy } from "/resources/js/ziggy";
import AppLayout from '@/Layouts/AppLayout.vue';
import ToastService from 'primevue/toastservice';

createInertiaApp({
    resolve: async (name) => {
        // Memeriksa apakah terdapat folder dalam nama halaman
        const [folder, file] = name.split("/");

        if (file) {
            // Jika nama memiliki folder, muat dari folder yang sesuai
            const page = (await import(`./Pages/${folder}/${file}.vue`))
                .default;
            page.layout ??= AppLayout;
            return page;
        }

        // Jika tidak ada folder, muat dari folder Pages langsung
        const page = (await import(`./Pages/${name}.vue`)).default;
        page.layout ??= AppLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy, route)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                },
            })
            .use(ToastService)
            .mount(el);
    },
});
