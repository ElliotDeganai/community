import { createWebHistory, createRouter } from "vue-router";
import Default from "../Pages/Home/Default.vue";

const routes = [
  {
    path: "/default",
    name: "Default",
    component: Default,
  },
/*   {
    path: "/about",
    name: "About",
    component: About,
  }, */
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
