import axios from 'axios';

export default {
    namespaced: true,
    state: {
        roles: null,
        cards: [],
        currentPage: null,
        total: null,
        perPage: null,
    },
    getters: {
        roles(state) {
            return state.roles;
        },
        cards(state) {
            return state.cards;
        },
        currentPage(state) {
            return state.currentPage;
        },
        total(state) {
            return state.total;
        },
        perPage(state) {
            return state.perPage;
        },
    },
    mutations: {
        SET_CARD(state, item) {
            let index = state.cards.findIndex(card => card.id === item.id);

            if (index !== -1) {
                state.cards[index] = item;
                state.total = state.total + 1;
            } else {
                state.cards.unshift(item);
            }
        },
        SET_CARDS(state, value) {
            state.cards = value;
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
        SET_ROLES(state, value) {
            state.roles = value;
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
            let url = `${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}?${queryString}`;
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
            }

            commit('SET_CARDS', data.data);
            commit('SET_CURRENT_PAGE', data.current_page);
            commit('SET_TOTAL', data.total);
            commit('SET_PER_PAGE', data.per_page);
        },
        sortCards({ commit }, { prop, asc }) {
            commit('SORT_CARDS', { prop, asc });
        },
        appendCard({ state }, card) {
            state.cards.unshift(card);
        },
        async saveCard({ commit }, card) {
            const url = `${window.climbingcards.rest_url}cards/${card.id}`;
            const { data } = await axios.post(url, card);

            if (data.created) {
                card.editmode = false;
                commit('SET_CARD', card);
            }
        },
        async updateCard({ state }, card) {
            const url = `${window.climbingcards.rest_url}cards/${card.id}/update`;
            const { data } = await axios.post(url, card);

            if (data.updated) {
                card.editmode = false;
            }
        },
        async deleteCard({ state, commit }, card) {
            if (!!card.id) {
                const url = `${window.climbingcards.rest_url}cards/${card.id}/delete`;
                const { data } = await axios.post(url);
            }

            let index = state.cards.indexOf(card);

            commit('DELETE_CARD', index);
        },
        async exportToCsv({ state }) {
            const url = `${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}/export`;
            const { data } = await axios.get(url);

            const filtered = data.cards.map(card => {
                return {
                    route: card.route,
                    crag: card.crag,
                    grade: card.grade,
                    style: card.style,
                    comment: card.comment,
                    date: card.climbed_at,
                };
            });

            let csvContent = 'data:text/csv;charset=utf-8,';
            csvContent += [Object.keys(filtered[0]).join(';'), ...filtered.map(item => Object.values(item).join(';'))].join('\n').replace(/(^\[)|(\]$)/gm, '');

            const csv = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', csv);
            link.setAttribute('download', 'export.csv');
            link.click();
        },
        async getRoles({ commit }) {
            const url = `${window.climbingcards.rest_url}users/me`;
            const { data } = await axios.get(url);

            commit('SET_ROLES', data.roles);
        },
    },
};
