import { createStore } from 'vuex';
import cards from './modules/cardsModule';
import statistics from './modules/statisticsModule';
import settings from './modules/settingsModule';

const store = createStore({
    modules: {
        cards,
        statistics,
        settings,
    },
});

export default store;
