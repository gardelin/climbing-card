import { createStore } from 'vuex';

const store = createStore({
    state: {
        cards: [],
        selected: [],
    },
    getters: {
        cards(state) {
            return state.cards;
        },
        selected(state) {
            return state.selected;
        },
    },
    mutations: {
        setCards(state, value) {
            state.cards = value;
        },
        setSelected(state, value) {
            state.selected = value;
        },
        appendSelected(state, value) {
            state.selected.push(value);
        },
    },
    actions: {
        appendCard({ state }, card) {
            state.cards.unshift(card);
        },
        exportToCsv({ state }) {
            const filtered = state.selected.map(card => {
                return {
                    route: card.route,
                    crag: card.crag,
                    grade: card.grade,
                    style: card.style,
                    comment: card.comment,
                    date: card.date,
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
