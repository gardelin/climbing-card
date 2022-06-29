import { createWebHashHistory, createRouter } from 'vue-router';

import Users from '../views/Users';
import User from '../views/User';

// Define all routes
export const routes = [
    {
        name: 'users',
        path: '/',
        component: Users,
        meta: { title: 'Users' },
    },
    {
        name: 'user',
        path: '/users/:id',
        component: User,
        meta: { title: 'User' },
    },
];

// Create the router
const router = createRouter({
    history: createWebHashHistory(),
    routes: routes,
});

export default router;
