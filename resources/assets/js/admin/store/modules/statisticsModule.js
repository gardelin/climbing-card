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
            const response = await fetch(`${window.climbingcards.rest_url}stats/${window.climbingcards.logged_user_id}`);
            const { data } = await response.json();

            commit('SET_STATS', data.stats);
        },
    },
};
