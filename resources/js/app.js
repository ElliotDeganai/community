import './bootstrap';

import { createApp, h } from 'vue';
//import { createInertiaApp } from '@inertiajs/inertia-vue3';
//import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { createInertiaApp } from '@inertiajs/vue3'
import Store from './Store/index'
//import VueRouter from 'vue-router'
//import router from "./Router/index";

import helpers from './helpers';

 const options = {
    pk: `pk_test_51GvkFDAVOuPOEbtImSyLyDRI9jA1DrqLqBeFQbwPtabNwnvKyQ3U0lkAXDZIZuN2esb32WDwQdAE9kJG8Q4alsNH00aSWKFTey`,
    stripeAccount: process.env.STRIPE_ACCOUNT,
    apiVersion: process.env.API_VERSION,
    locale: process.env.LOCALE,
    test: process.env
  };

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

/* createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({ render: () => h(App, props) });

        VueApp.config.globalProperties.$helpers = helpers;
        //VueApp.config.globalProperties.$stripe = options;
        return VueApp
            .use(plugin)
            .use(require('moment'))
            .use(Store)
            //.use(router)
            //.use(StripePlugin, options)
            .mixin({ methods: { route } })
            .mount(el);
    },
}); */

const app = document.getElementById('app')

if (app) {
    createInertiaApp({
        title: () => `${appName}`,
        resolve: name => require(`./Pages/${name}`),
        setup({el, App, props, plugin}) {
            const VueApp = createApp({ render: () => h(App, props) });

            VueApp.config.globalProperties.$helpers = helpers;
            //VueApp.config.globalProperties.$stripe = options;
            return VueApp
                .use(plugin)
                .use(require('moment'))
                .use(Store)
                //.use(router)
                //.use(StripePlugin, options)
                .mixin({ methods: { route } })
                .mount(el);
        },
    })
}
