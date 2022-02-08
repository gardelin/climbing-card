import {createStore} from 'vuex';

const store = createStore({
    state: {
        cards: [],
    },
    mutations: {
        setCards(state, value) {
            state.cards = value;
        },
    },
});

export default store;
