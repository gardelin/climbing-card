import axios from 'axios';

export default {
    state: {
        stats: [],
    },
    getters: {
        stats(state) {
            return state.stats;
        },
    },
    mutations: {
        SET_STATS(state, value) {
            state.stats = value;
        },
    },
    actions: {
        async getStatistics({ commit }) {
            const url = `${window.climbingcards.rest_url}stats/${window.climbingcards.logged_user_id}`;
            const { data } = await axios.get(url);

            commit('SET_STATS', data.stats);
        },
    },
};
