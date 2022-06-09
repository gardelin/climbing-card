import { createStore } from 'vuex';

const store = createStore({
    state: {
        cards: [],
        stats: [],
    },
    getters: {
        cards(state) {
            return state.cards;
        },
        stats(state) {
            return state.stats;
        },
    },
    mutations: {
        setCards(state, value) {
            state.cards = value;
        },
        setStats(state, value) {
            state.stats = value;
        },
    },
    actions: {
        appendCard({ state }, card) {
            state.cards.unshift(card);
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
});

export default store;
