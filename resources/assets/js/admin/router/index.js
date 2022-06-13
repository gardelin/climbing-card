import { createWebHashHistory, createRouter } from 'vue-router';

import ClimbingCards from '../views/ClimbingCards';
import Settings from '../views/Settings';
import Stats from '../views/Stats';

// Define all routes
export const routes = [
    {
        name: 'climbing-cards',
        path: '/',
        component: ClimbingCards,
        meta: { title: 'Climbing Card' },
    },
    {
        name: 'settings',
        path: '/settings',
        component: Settings,
        meta: { title: 'Climbing Card - Settings' },
    },
    {
        name: 'stats',
        path: '/stats',
        component: Stats,
        meta: { title: 'Climbing Card - Statistics' },
    },
];

// Create the router
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});

export default router;
