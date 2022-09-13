import { createWebHashHistory, createRouter } from 'vue-router';

import CardsPage from '../pages/CardsPage';
import SettingsPage from '../pages/SettingsPage';
import StatisticsPage from '../pages/StatisticsPage';

// Define all routes
export const routes = [
    {
        name: 'climbing-cards',
        path: '/',
        component: CardsPage,
        meta: { title: 'Climbing Card' },
    },
    {
        name: 'settings',
        path: '/settings',
        component: SettingsPage,
        meta: { title: 'Climbing Card - Settings' },
    },
    {
        name: 'stats',
        path: '/stats',
        component: StatisticsPage,
        meta: { title: 'Climbing Card - Statistics' },
    },
];

// Create the router
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});

export default router;
