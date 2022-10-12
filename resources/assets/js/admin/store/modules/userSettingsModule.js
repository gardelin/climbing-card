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
            const response = await fetch(`${window.climbingcards.rest_url}settings?user_id=${window.climbingcards.logged_user_id}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'X-WP-Nonce': window.climbingcards.nonce,
                },
            });

            const { data } = await response.json();

            commit('IS_USER_CARDBOARD_PUBLIC', JSON.parse(data.is_climbing_card_public));
        },
        async setUserClimbingCardStatus({ commit }, value) {
            const response = await fetch(`${window.climbingcards.rest_url}settings`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'X-WP-Nonce': window.climbingcards.nonce,
                },
                body: JSON.stringify({
                    is_climbing_card_public: value,
                    user_id: window.climbingcards.logged_user_id,
                }),
            });

            const { data } = await response.json();

            commit('IS_USER_CARDBOARD_PUBLIC', !!data.is_climbing_card_public);
        },
    },
};
