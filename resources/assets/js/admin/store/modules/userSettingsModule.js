import axios from 'axios';

export default {
    state: {
        isUserCardboardPublic: null,
    },
    getters: {
        isUserCardboardPublic(state) {
            return state.isUserCardboardPublic;
        },
    },
    mutations: {
        IS_USER_CARDBOARD_PUBLIC(state, status) {
            state.isUserCardboardPublic = status;
        },
    },
    actions: {
        async isUserCardboardPublic({ commit }) {
            const url = `${window.climbingcards.rest_url}settings?user_id=${window.climbingcards.logged_user_id}`;
            const { data } = await axios.get(url);

            commit('IS_USER_CARDBOARD_PUBLIC', JSON.parse(data.is_climbing_card_public));
        },
        async setUserClimbingCardStatus({ commit }, value) {
            const url = `${window.climbingcards.rest_url}settings`;
            const settings = {
                is_climbing_card_public: value,
                user_id: window.climbingcards.logged_user_id,
            };
            const { data } = await axios.post(url, settings);

            commit('IS_USER_CARDBOARD_PUBLIC', !!data.is_climbing_card_public);
        },
    },
};
