<template>
    <div v-if="cards.length">
        <div class="table-header">
            <div class="search-container">
                <Search :size="18" />
                <input class="search" type="text" :placeholder="$gettext('Search Cards')" v-model="searchQuery" />
            </div>
            <div class="date-container">
                <div class="input-group">
                    <flat-pickr v-model="dateRange" :config="flatPickrRangeConfig" :placeholder="$gettext('Select Dates')"> </flat-pickr>
                    <X :size="18" v-if="dateRange" @click="dateRange = null" />
                </div>
            </div>
        </div>
        <table class="cards">
            <thead>
                <tr>
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
                <tr class="item" :class="{ edit: card.editmode === true }" v-for="card in filteredCards" :key="card.id">
                    <td class="route" :data-name="$gettext('Route')">
                        <input v-if="card.editmode" v-model="card.route" :placeholder="$gettext('Route Name')" />
                        <span v-else>{{ card.route }}</span>
                        <span v-if="card.errors.route" class="error">{{ card.errors.route }}</span>
                    </td>
                    <td class="crag" :data-name="$gettext('Crag')">
                        <input v-if="card.editmode" v-model="card.crag" :placeholder="$gettext('Crag - Sector')" />
                        <span v-else>{{ card.crag }}</span>
                        <span v-if="card.errors.crag" class="error">{{ card.errors.crag }}</span>
                    </td>
                    <td class="grade" :data-name="$gettext('Grade')">
                        <select v-if="card.editmode" v-model="card.grade">
                            <option value="" disabled selected>{{ $gettext('Select Grade') }}</option>
                            <option v-for="grade in grades" :key="grade">
                                {{ grade }}
                            </option>
                        </select>
                        <span v-else>{{ card.grade }}</span>
                        <span v-if="card.errors.grade" class="error">{{ card.errors.grade }}</span>
                    </td>
                    <td class="style" :data-name="$gettext('Style')">
                        <select v-if="card.editmode" v-model="card.style">
                            <option value="red point">Red Point</option>
                            <option value="flash">Flash</option>
                            <option value="on sight">On Sight</option>
                        </select>
                        <span v-else :class="card.style.replace(' ', '')">{{ card.style }}</span>
                    </td>
                    <td class="comment" :data-name="$gettext('Comment')">
                        <textarea v-if="card.editmode" v-model="card.comment" />
                        <span v-else>{{ card.comment }}</span>
                    </td>
                    <td class="climbed_at" :data-name="$gettext('Date')">
                        <span v-if="card.editmode">
                            <flat-pickr v-model="card.climbed_at" :config="flatPickrDateConfig" :placeholder="$gettext('Select Date')" />
                        </span>
                        <span v-else>{{ datetimeToHuman(card.climbed_at) }}</span>
                        <span v-if="card.errors.climbed_at" class="error">{{ card.errors.climbed_at }}</span>
                    </td>
                    <td class="actions" :data-name="$gettext('Actions')">
                        <Edit2 :size="18" v-if="!card.editmode" @click="card.editmode = true" />
                        <Save :size="18" v-else @click="_save(card)" />
                        <Trash2 :size="18" @click="this.$store.dispatch('deleteCard', card)" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <p v-else>{{ $gettext('No routes found in your cartboard. You can add it using "Add" button above.') }}</p>
</template>

<script>
    import { ref, computed } from 'vue';
    import { useStore, mapActions } from 'vuex';
    import { Edit2, Trash2, Save, ChevronDown, ChevronUp, Search, X } from 'lucide-vue-next';
    import language from '../../language';
    import flatPickr from 'vue-flatpickr-component';
    import { grades, datetimeToHuman } from '../../utils/Utils';

    const { $gettext } = language;

    export default {
        name: 'CardsTable',
        components: {
            Edit2,
            Trash2,
            Save,
            ChevronDown,
            ChevronUp,
            Search,
            X,
            flatPickr,
        },
        data() {
            return {
                grades: grades(true),
                asc: false,
                sortBy: null,
                flatPickrRangeConfig: {
                    altFormat: 'd/m/Y',
                    altInput: true,
                    mode: 'range',
                    locale: { rangeSeparator: ' - ' },
                },
                flatPickrDateConfig: {
                    altFormat: 'd/m/Y',
                    altInput: true,
                },
            };
        },
        async setup() {
            const store = useStore();
            const dateRange = ref('');
            const searchQuery = ref('');

            if (!store.getters.cards.length) {
                await store.dispatch('getCards');
            }

            return {
                cards: computed(() => store.getters.cards),
                filteredCards: computed(() => store.getters.filterCards({ searchQuery, dateRange })),
                searchQuery,
                dateRange,
                datetimeToHuman,
            };
        },
        methods: {
            ...mapActions(['sortCards', 'saveCard', 'updateCard', 'filterCards']),

            /**
             * Store new card to database
             *
             * @return {Void}
             */
            _save(card) {
                if (this._isValid(card)) {
                    if (card.id) {
                        this.updateCard(card);
                    } else {
                        this.saveCard(card);
                    }
                }
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
             * Sort table column
             *
             * @param {String} prop
             * @return {Void}
             */
            _sort(prop) {
                this.asc = !this.asc;
                this.sortBy = prop;
                const asc = this.asc;

                this.sortCards({ prop, asc });
            },
        },
    };
</script>

<style lang="scss">
    @import 'flatpickr/dist/flatpickr.css';

    .date-container {
        position: relative;

        .lucide {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: var(--cc-gray-500);
            cursor: pointer;
        }

        input {
            border: 1px solid var(--cc-gray-300);
            width: 300px;
            padding: 2px 40px 2px 10px;
            box-shadow: var(--cc-box-shadow-sx);
            border-radius: var(--cc-border-radius);
            font-weight: 300;
        }
    }

    .search-container {
        position: relative;

        .lucide {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: var(--cc-gray-500);
        }

        input {
            border: 1px solid var(--cc-gray-300);
            width: 300px;
            padding: 2px 10px 2px 40px;
            box-shadow: var(--cc-box-shadow-sx);
            border-radius: var(--cc-border-radius);
            font-weight: 300;
        }
    }
</style>
