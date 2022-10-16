import axios from 'axios';

export default {
    namespaced: true,
    state: {
        cards: [],
        currentPage: null,
        total: null,
        perPage: null,
    },
    getters: {
        currentPage(state) {
            return state.currentPage;
        },
        total(state) {
            return state.total;
        },
        perPage(state) {
            return state.perPage;
        },
        cards(state) {
            return state.cards;
        },
    },
    mutations: {
        SET_CARD(state, item) {
            let index = state.cards.findIndex(card => card.id === item.id);

            if (index !== -1) {
                state.cards[index] = item;
            } else {
                state.cards.unshift(item);
            }
        },
        SET_CARDS(state, value) {
            state.cards = value;
            state.total = state.total + 1;
        },
        DELETE_CARD(state, index) {
            state.cards.splice(index, 1);
            state.total = state.total - 1;
        },
        SORT_CARDS(state, { prop, asc }) {
            state.cards.sort((a, b) => {
                if (asc) {
                    return a[prop] > b[prop] ? 1 : -1;
                } else {
                    return a[prop] < b[prop] ? 1 : -1;
                }
            });
        },
        SET_CURRENT_PAGE(state, value) {
            state.currentPage = value;
        },
        SET_TOTAL(state, value) {
            state.total = value;
        },
        SET_PER_PAGE(state, value) {
            state.perPage = value;
        },
    },
    actions: {
        async getCards({ commit }, params) {
            let queryString = new URLSearchParams(params).toString();
            let url = `${window.climbingcards.rest_url}cards?${queryString}`;
            let { data } = await axios.get(url);

            if (data.data) {
                data.data = data.data.map(card => {
                    card.errors = {
                        route: null,
                        crag: null,
                        grade: null,
                        climbed_at: null,
                    };

                    return card;
                });

                commit('SET_CARDS', data.data);
                commit('SET_CURRENT_PAGE', data.current_page);
                commit('SET_TOTAL', data.total);
                commit('SET_PER_PAGE', data.per_page);
            }
        },
        sortCards({ commit }, { prop, asc }) {
            commit('SORT_CARDS', { prop, asc });
        },
    },
};
