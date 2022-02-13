<template>
    <table class="cards">
        <thead>
            <tr>
                <th class="id">ID</th>
                <th class="route">Smjer</th>
                <th class="crag">Penjaliste</th>
                <th class="grade">Ocjena</th>
                <th class="style">Nacin</th>
                <th class="comment">Komentar</th>
                <th class="climbed_at">Datum</th>
                <th class="actions">Akcije</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="card in cards" :key="card.id">
                <td class="id" data-name="ID">
                    <span>{{ card.id }}</span>
                </td>
                <td class="route" data-name="Route">
                    <input v-if="card.editmode" v-model="card.route" />
                    <span v-else>{{ card.route }}</span>
                    <span v-if="card.errors.route" class="error">{{ card.errors.route }}</span>
                </td>
                <td class="crag" data-name="Crag">
                    <input v-if="card.editmode" v-model="card.crag" />
                    <span v-else>{{ card.crag }}</span>
                    <span v-if="card.errors.crag" class="error">{{ card.errors.crag }}</span>
                </td>
                <td class="grade" data-name="Grade">
                    <select v-if="card.editmode" v-model="card.grade">
                        <option v-for="grade in grades" :key="grade">
                            {{ grade }}
                        </option>
                    </select>
                    <span v-else>{{ card.grade }}</span>
                    <span v-if="card.errors.grade" class="error">{{ card.errors.grade }}</span>
                </td>
                <td class="style" data-name="Style">
                    <select v-if="card.editmode" v-model="card.style">
                        <option value="red point">Red Point</option>
                        <option value="flash">Flash</option>
                        <option value="on sight">On Sight</option>
                    </select>
                    <span v-else :class="card.style.replace(' ', '')">{{ card.style }}</span>
                </td>
                <td class="comment" data-name="Comment">
                    <textarea v-if="card.editmode" v-model="card.comment" />
                    <span v-else>{{ card.comment }}</span>
                </td>
                <td class="climbed_at" data-name="Date">
                    <input v-if="card.editmode" type="date" v-model="card.climbed_at" />
                    <span v-else>{{ card.climbed_at }}</span>
                    <span v-if="card.errors.climbed_at" class="error">{{ card.errors.climbed_at }}</span>
                </td>
                <td class="actions" data-name="Actions">
                    <Edit2 :size="18" v-if="!card.editmode" @click="_edit(card)" />
                    <Save :size="18" v-else @click="_save(card)" />
                    <Trash2 :size="18" @click="_delete(card)" />
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import Utils from '../../../utils/Utils';
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import { Edit2, Trash2, Save } from 'lucide-vue-next';

    export default {
        name: 'Cards',
        components: { Edit2, Trash2, Save },
        data() {
            return {
                grades: Utils.grades(true),
            };
        },
        async setup() {
            const cards = ref([]);
            const store = useStore();
            const response = await fetch(`${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}`);
            const json = await response.json();

            cards.value = json.data.cards.map(card => {
                card.errors = {};
                return card;
            });
            store.commit('setCards', (store.state.cards = cards));

            return {
                cards: computed(() => store.state.cards),
            };
        },
        methods: {
            /**
             * Set edit mode so user can edit card.
             *
             * @return {Void}
             */
            _edit(card) {
                card.editmode = true;
            },

            /**
             * Store new card to database
             *
             * @return {Void}
             */
            _save(card) {
                if (!this._isValid(card)) {
                    return;
                }

                let update = card.id ? true : false;

                fetch(`${window.climbingcards.rest_url}cards/${card.id}`, {
                    method: update ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=UTF-8',
                        'X-WP-Nonce': window.climbingcards.nonce,
                    },
                    body: JSON.stringify(card),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.data.updated) {
                            card.editmode = false;
                        } else if (data.data.created) {
                            card.id = data.data.card.id;
                            card.editmode = false;
                        }
                    })
                    .catch(error => console.log(error));
            },

            /**
             * Delete card entry.
             *
             * @return {Void}
             */
            _delete(card) {
                let index = this.$store.state.cards.indexOf(card);

                if (!card.id) return this.$store.state.cards.splice(index, 1);

                fetch(`${window.climbingcards.rest_url}cards/${card.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json;charset=UTF-8',
                        'X-WP-Nonce': window.climbingcards.nonce,
                    },
                    body: JSON.stringify(card),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.data.deleted) this.$store.state.cards.splice(index, 1);
                    })
                    .catch(error => console.log(error));
            },

            /**
             * Convert mysql datetime so it's readable for human.
             *
             * @return {String}
             */
            _datetimeToHuman(datetime) {
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                };
                const parsed = Date.parse(datetime);
                const date = new Date(parsed);
                const localized = date.toLocalizedDateString('hr-HR', options);

                return localized;
            },

            /**
             * Validate card inputs.
             *
             * @return {Void}
             */
            _isValid(card) {
                card.errors = {
                    route: null,
                    crag: null,
                    grade: null,
                    climbed_at: null,
                };

                if (!card.route) card.errors.route = 'Route required!';
                if (!card.crag) card.errors.crag = 'Crag required!';
                if (!card.grade) card.errors.grade = 'Grade required!';
                if (!card.climbed_at) card.errors.climbed_at = 'Date required!';

                for (let error in card.errors) {
                    if (card.errors[error]) return false;
                }

                return true;
            },
        },
    };
</script>

<style lang="scss" scoped></style>
