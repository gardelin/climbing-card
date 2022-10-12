import { createWebHashHistory, createRouter } from 'vue-router';
import store from '../store';

import CardsPage from '../pages/CardsPage';
import SettingsPage from '../pages/SettingsPage';
import StatisticsPage from '../pages/StatisticsPage';
import AdminPage from '../pages/AdminPage';
import NotAllowedPage from '../pages/NotAllowedPage';

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
    {
        name: 'not-allowed',
        path: '/not-allowed',
        component: NotAllowedPage,
        meta: { title: 'Climbing Card - Not Allowed' },
    },
    {
        name: 'admin',
        path: '/admin',
        component: AdminPage,
        meta: {
            title: 'Climbing Card - Admin',
            requiredAuthorization: true,
            roles: ['administrator'],
        },
    },
];

// Create the router
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});

router.beforeEach(async (to, from, next) => {
    if (!store.getters['user/user']) {
        await store.dispatch('user/getUser');
    }

    const user = store.getters['user/user'];
    const hasAccess = to.meta?.roles?.some(r => user.roles.includes(r));

    if (to.meta.requiredAuthorization && !hasAccess) {
        return next('/not-allowed');
    }

    return next();
});

export default router;
