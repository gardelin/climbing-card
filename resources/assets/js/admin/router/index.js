import { createWebHashHistory, createRouter } from 'vue-router';

import Dashboard from '../views/Dashboard';
import Settings from '../views/Settings';
import Statistics from '../views/Statistics';

// Define all routes
export const routes = [
    {
        name: 'dashboard',
        path: '/',
        component: Dashboard,
        meta: { title: 'Climbing Card' },
    },
    {
        name: 'settings',
        path: '/settings',
        component: Settings,
        meta: { title: 'Climbing Card - Settings' },
    },
    {
        name: 'statistics',
        path: '/statistics',
        component: Statistics,
        meta: { title: 'Climbing Card - Statistics' },
    },
];

// Create the router
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});

export default router;
