import { App, plugin } from "@inertiajs/inertia-vue";
import Vue from "vue";
import Layout from "./Shared/Layout";
import "../css/app.css";

Vue.use(plugin);

const el = document.getElementById("app");

new Vue({
    render: (h) =>
        h(App, {
            props: {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: async (name) => {
                    const page = (await import(`./Pages/${name}`)).default;
                    page.layout = page.layout || Layout;
                    return page;
                },
            },
        }),
}).$mount(el);

Vue.mixin({ methods: { route: window.route } });
