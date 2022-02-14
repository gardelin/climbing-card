<template>
    <table class="cards">
        <thead>
            <tr>
                <th class="export">
                    <input type="checkbox" v-model="selectAll" @change="_selectAll()" />
                </th>
                <th class="route" @click="_sort('route')">
                    {{ $gettext('Route') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'route' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'route' && this.asc" />
                </th>
                <th class="crag" @click="_sort('crag')">
                    {{ $gettext('Crag') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'crag' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'crag' && this.asc" />
                </th>
                <th class="grade" @click="_sort('grade')">
                    {{ $gettext('Grade') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'grade' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'grade' && this.asc" />
                </th>
                <th class="style" @click="_sort('style')">
                    {{ $gettext('Style') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'style' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'style' && this.asc" />
                </th>
                <th class="comment">{{ $gettext('Comment') }}</th>
                <th class="climbed_at" @click="_sort('climbed_at')">
                    {{ $gettext('Date') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'climbed_at' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'climbed_at' && this.asc" />
                </th>
                <th class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="card in cards" :key="card.id">
                <td class="export" data-name="Export">
                    <input type="checkbox" v-if="!card.editmode" v-model="selected" :value="card" number />
                </td>
                <td class="route" data-name="Route">
                    <input v-if="card.editmode" v-model="card.route" placeholder="Route Name" />
                    <span v-else>{{ card.route }}</span>
                    <span v-if="card.errors.route" class="error">{{ card.errors.route }}</span>
                </td>
                <td class="crag" data-name="Crag">
                    <input v-if="card.editmode" v-model="card.crag" placeholder="Crag - Sector" />
                    <span v-else>{{ card.crag }}</span>
                    <span v-if="card.errors.crag" class="error">{{ card.errors.crag }}</span>
                </td>
                <td class="grade" data-name="Grade">
                    <select v-if="card.editmode" v-model="card.grade">
                        <option value="" disabled selected>Select Grade</option>
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
    import { Edit2, Trash2, Save, ChevronDown, ChevronUp } from 'lucide-vue-next';
    import language from '../../language';

    const { $gettext } = language;

    export default {
        name: 'Cards',
        components: { Edit2, Trash2, Save, ChevronDown, ChevronUp },
        data() {
            return {
                grades: Utils.grades(true),
                selectAll: false,
                asc: false,
                sortBy: null,
            };
        },
        async setup() {
            const cards = ref([]);
            const store = useStore();
            const response = await fetch(`${window.climbingcards.rest_url}cards/${window.climbingcards.logged_user_id}`);
            const json = await response.json();

            cards.value = json.data.cards.map(card => {
                card.errors = {
                    route: null,
                    crag: null,
                    grade: null,
                    climbed_at: null,
                };

                return card;
            });

            store.commit('setCards', (store.state.cards = cards));

            const selected = computed({
                get: () => store.state.selected,
                set: value => {
                    store.commit('setSelected', value);
                },
            });

            return {
                cards: computed(() => store.state.cards),
                selected: selected,
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

                if (!card.route) card.errors.route = $gettext('Route required!');
                if (!card.crag) card.errors.crag = $gettext('Crag required!');
                if (!card.grade) card.errors.grade = $gettext('Grade required!');
                if (!card.climbed_at) card.errors.climbed_at = $gettext('Date required!');

                for (let error in card.errors) {
                    if (card.errors[error]) return false;
                }

                return true;
            },

            /**
             * Check all routes
             *
             * @return {Void}
             */
            _selectAll(e) {
                if (this.selectAll) {
                    this.$store.commit('setSelected', (this.$store.state.selected = this.$store.state.cards));
                } else {
                    this.$store.commit('setSelected', (this.$store.state.selected = []));
                }
            },

            /**
             * Sort table column
             *
             * @param {String} prop
             * @return {Void}
             */
            _sort(prop) {
                this.asc = !this.asc;
                this.sortBy = prop;
                const asc = this.asc;

                this.$store.state.cards.sort((a, b) => {
                    return asc ? a[prop] > b[prop] : a[prop] < b[prop];
                });
            },
        },
    };
</script>

<style lang="scss" scoped></style>
