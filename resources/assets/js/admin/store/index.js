import { createStore } from 'vuex';
import user from './modules/userModule';
import userStatistics from './modules/userStatisticsModule';
import userSettings from './modules/userSettingsModule';
import admin from './modules/adminModule';

const store = createStore({
    modules: {
        user,
        userStatistics,
        userSettings,
        admin,
    },
});

export default store;
