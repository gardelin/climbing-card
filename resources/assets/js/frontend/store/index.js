import { createStore } from 'vuex';

const store = createStore({
    state: {
        users: [],
    },
    getters: {
        users(state) {
            return state.users;
        },
        user: (state) => (id) => {
            let index = state.users.findIndex(user => user.id == id);

            if (state.users[index])
                return state.users[index];

            return null;
        },
        cards: (state) => (id) => {
            let index = state.users.findIndex(user => user.id == id);

            if (state.users[index] && state.users[index].cards)
                return state.users[index].cards;

            return null;
        },
        stats: (state) => (id) => {
            let index = state.users.findIndex(user => user.id == id);

            if (state.users[index] && state.users[index].stats)
                return state.users[index].stats;

            return null;
        },
    },
    mutations: {
        SET_USERS(state, value) {
            state.users = value;
        },
        SET_CARDS(state, {id, value}) {
            let index = state.users.findIndex(user => user.id == id);

            state.users[index].cards = value;
        },
        SET_STATS(state, {id, value}) {
            let index = state.users.findIndex(user => user.id == id);

            state.users[index].stats = value;
        },
        SORT_CARDS(state, {id, prop, asc}) {
            let index = state.users.findIndex(user => user.id == id);

            state.users[index].cards.sort((a, b) => {
                if (asc) {
                    return a[prop] > b[prop] ? 1 : -1;
                } else {
                    return a[prop] < b[prop] ? 1 : -1;
                }
            });
        },
    },
    actions: {
        async getUsers({ commit }) {
            const response = await fetch(`${window.climbingcards.rest_url}/users`);
            const json = await response.json();

            commit('SET_USERS', json.data.users)
        },
        async getUserCards({ commit }, userId) {
            const response = await fetch(`${window.climbingcards.rest_url}/cards/${userId}`);
            const json = await response.json();

            commit('SET_CARDS', {id: userId, value: json.data.cards})
        },
        async getUserStats({ commit }, userId) {
            const response = await fetch(`${window.climbingcards.rest_url}/stats/${userId}`);
            const json = await response.json();

            commit('SET_STATS', {id: userId, value: json.data.stats})
        },
    },
});

export default store;
