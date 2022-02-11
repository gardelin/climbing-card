import { createStore } from 'vuex';

const store = createStore({
    state: {
        cards: [],
    },
    getters: {
        cards(state) {
            return state.cards;
        },
    },
    mutations: {
        setCards(state, value) {
            state.cards = value;
        },
    },
    actions: {
        appendCard({ state }, card) {
            state.cards.unshift(card);
        },
    },
});

export default store;
