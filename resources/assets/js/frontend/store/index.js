import { createStore } from 'vuex';

const store = createStore({
    state: {
        users: [],
    },
    getters: {
        users(state) {
            return state.users;
        },
        user: state => id => {
            let index = state.users.findIndex(user => user.id == id);

            if (state.users[index]) return state.users[index];

            return null;
        },
        cards: state => id => {
            let index = state.users.findIndex(user => user.id == id);

            if (state.users[index] && state.users[index].cards) return state.users[index].cards;

            return null;
        },
        filterCards:
            state =>
            ({ id, searchQuery, dateRange }) => {
                let index = state.users.findIndex(user => user.id == id);

                let cards = null;
                if (state.users[index] && state.users[index].cards) {
                    cards = state.users[index].cards;
                }

                if (!cards) {
                    return [];
                }

                const dates = dateRange && dateRange.value ? dateRange.value.split(' - ') : false;

                if (dates?.[0] && !dates?.[1]) {
                    dates[1] = dates[0];
                }

                if (dates?.[0] && dates?.[1]) {
                    const from = new Date(dates[0]);
                    const to = new Date(dates[1]);

                    cards = cards.filter(card => {
                        const check = new Date(card.climbed_at);
                        return check >= from && check <= to;
                    });
                }

                const query = searchQuery.value.toLowerCase();

                cards = cards.filter(card => {
                    return false || card.route.toLowerCase().includes(query) || card.crag.toLowerCase().includes(query) || card.grade.toLowerCase().includes(query);
                });

                return cards;
            },
        stats: state => id => {
            let index = state.users.findIndex(user => user.id == id);

            if (state.users[index] && state.users[index].stats) return state.users[index].stats;

            return null;
        },
    },
    mutations: {
        SET_USERS(state, value) {
            state.users = value;
        },
        SET_CARDS(state, { id, value }) {
            let index = state.users.findIndex(user => user.id == id);

            state.users[index].cards = value;
        },
        SET_STATS(state, { id, value }) {
            let index = state.users.findIndex(user => user.id == id);

            state.users[index].stats = value;
        },
        SORT_CARDS(state, { id, prop, asc }) {
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

            console.log('SET_USERS');
            commit('SET_USERS', json.data.users);
        },
        async getUserCards({ commit }, userId) {
            const response = await fetch(`${window.climbingcards.rest_url}/cards/${userId}`);
            const json = await response.json();

            console.log('SET_CARDS');
            commit('SET_CARDS', { id: userId, value: json.data.cards });
        },
        async getUserStats({ commit }, userId) {
            const response = await fetch(`${window.climbingcards.rest_url}/stats/${userId}`);
            const json = await response.json();

            console.log('SET_STATS');
            commit('SET_STATS', { id: userId, value: json.data.stats });
        },
    },
});

export default store;
