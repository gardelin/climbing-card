export default {
    state: {
        cards: [],
    },
    getters: {
        cards(state) {
            return state.cards;
        },
        filterCards:
            state =>
            ({ searchQuery, dateRange }) => {
                let cards = state.cards;
                const dates = dateRange && dateRange.value ? dateRange.value.split(' - ') : false;

                if (dates?.[0] && !dates?.[1]) {
                    dates[1] = dates[0];
                }

                if (dates?.[0] && dates?.[1]) {
                    const from = new Date(dates[0]);
                    const to = new Date(dates[1]);

                    cards = state.cards.filter(card => {
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
        },
        DELETE_CARD(state, index) {
            state.cards.splice(index, 1);
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
    },
    actions: {
        async getCards({ commit }) {
            let response = await fetch(`${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}`);
            let { data } = await response.json();

            if (data.cards) {
                data.cards = data.cards.map(card => {
                    card.errors = {
                        route: null,
                        crag: null,
                        grade: null,
                        climbed_at: null,
                    };

                    return card;
                });

                commit('SET_CARDS', data.cards);
            }
        },
        sortCards({ commit }, { prop, asc }) {
            commit('SORT_CARDS', { prop, asc });
        },
        filterCards({ commit }, { searchQuery, dateRange }) {
            commit('FILTER_CARDS', { searchQuery, dateRange });
        },
        appendCard({ state }, card) {
            state.cards.unshift(card);
        },
        async saveCard({ commit }, card) {
            const response = await fetch(`${window.climbingcards.rest_url}cards/${card.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'X-WP-Nonce': window.climbingcards.nonce,
                },
                body: JSON.stringify(card),
            });

            const { data } = await response.json();

            if (data.created) {
                card.editmode = false;
            }
        },
        async updateCard({ state }, card) {
            const response = await fetch(`${window.climbingcards.rest_url}cards/${card.id}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                    'X-WP-Nonce': window.climbingcards.nonce,
                },
                body: JSON.stringify(card),
            });

            const { data } = await response.json();

            if (data.updated) {
                card.editmode = false;
            }
        },
        async deleteCard({ state, commit }, card) {
            if (!!card.id) {
                const response = await fetch(`${window.climbingcards.rest_url}cards/${card.id}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=UTF-8',
                        'X-WP-Nonce': window.climbingcards.nonce,
                    },
                    body: JSON.stringify(card),
                });
            }

            let index = state.cards.indexOf(card);

            commit('DELETE_CARD', index);
        },
        exportToCsv({ state }) {
            const filtered = state.cards.map(card => {
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

            const data = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', data);
            link.setAttribute('download', 'export.csv');
            link.click();
        },
    },
};
