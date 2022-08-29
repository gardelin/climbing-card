<template>
    <div>
        <h1>{{ $gettext('Card') }}: {{ user.firstname }} {{ user.lastname }}</h1>
        <h3>{{ $gettext('Number of climbed routes per grade') }}</h3>
        <canvas id="chart"></canvas>
        <div class="border-bottom-gray-100" style="margin: 40px 0 60px 0"></div>
        <div class="table-header">
            <div class="search-container">
                <Search :size="18" />
                <input class="search" type="text" :placeholder="$gettext('Search Cards')" v-model="searchQuery" />
            </div>
            <div class="date-container">
                <div class="input-group">
                    <flat-pickr v-model="dateRange" :config="config" :placeholder="$gettext('Select Dates')"> </flat-pickr>
                    <X :size="18" v-if="dateRange" @click="dateRange = null" />
                </div>
            </div>
        </div>
        <table class="cards" id="cards-table">
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
                    <th class="style" @click="_sort('style')">
                        {{ $gettext('Style') }}
                        <ChevronUp :size="15" v-if="this.sortBy === 'style' && !this.asc" />
                        <ChevronDown :size="15" v-if="this.sortBy === 'style' && this.asc" />
                    </th>
                    <th class="grade" @click="_sort('grade')">
                        {{ $gettext('Grade') }}
                        <ChevronUp :size="15" v-if="this.sortBy === 'grade' && !this.asc" />
                        <ChevronDown :size="15" v-if="this.sortBy === 'grade' && this.asc" />
                    </th>
                    <th class="comment">{{ $gettext('Comment') }}</th>
                    <th class="climbed_at" @click="_sort('climbed_at')">
                        {{ $gettext('Date') }}
                        <ChevronUp :size="15" v-if="this.sortBy === 'climbed_at' && !this.asc" />
                        <ChevronDown :size="15" v-if="this.sortBy === 'climbed_at' && this.asc" />
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="item" v-for="card in filteredCards">
                    <td class="route" :data-name="$gettext('Route')">{{ card.route }}</td>  
                    <td class="crag" :data-name="$gettext('Crag')">{{ card.crag }}</td>
                    <td class="style" :data-name="$gettext('Style')">
                        <span class="dot" :class="card.style.replace(' ', '-')"></span>
                    </td>
                    <td class="grade" :data-name="$gettext('Grade')">{{ card.grade }}</td>
                    <td class="comment" :data-name="$gettext('Comment')">{{ card.comment }}</td>
                    <td class="date" :data-name="$gettext('Date')">{{ card.climbed_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import { useRoute } from 'vue-router';
    import Chart from 'chart.js/auto';
    import Utils from '../../utils/Utils';
    import flatPickr from 'vue-flatpickr-component';
    import { ChevronDown, ChevronUp, Search, X } from 'lucide-vue-next';

    export default {
        name: 'User',
        components: { 
            ChevronDown, 
            ChevronUp, 
            Search, 
            X,
            flatPickr,
        },
        async setup() {
            const store = useStore();
            const route = useRoute();
            const id = route.params.id;

            const user = ref([]);
            const cards = ref([]);
            const stats = ref([]);
            const searchQuery = ref('');
            const dateRange = ref('');

            if (store.getters.users.length === 0) {
                await store.dispatch('getUsers')
            }

            if (store.getters.cards(id) === null) {
                await store.dispatch('getUserCards', id)
            }

            if (store.getters.stats(id) === null) {
                await store.dispatch('getUserStats', id)
            }

            cards.value = store.getters.cards(id);
            stats.value = store.getters.stats(id);
            user.value = store.getters.user(id);

            const filteredCards = computed(() => {
                let data = cards.value;
                const term = searchQuery.value.toLowerCase();
                const dates = dateRange && dateRange.value ? dateRange.value.split(' - ') : false;

                if (dates?.[0] && !dates?.[1]) dates[1] = dates[0];

                // Filter by date
                if (dates?.[0] && dates?.[1]) {
                    const from = new Date(dates[0]);
                    const to = new Date(dates[1]);

                    data = data.filter(card => {
                        const check = new Date(card.climbed_at);
                        return check >= from && check <= to;
                    });
                }

                // Filter by searched term
                data = data.filter(card => {
                    return false 
                        || card.route.toLowerCase().indexOf(term) != -1 
                        || card.crag.toLowerCase().indexOf(term) != -1 
                        || card.grade.toLowerCase().indexOf(term) != -1;
                });

                return data;
            });

            return {
                user,
                cards,
                stats,
                filteredCards,
                grades: Utils.grades(true),
                asc: false,
                sortBy: null,
                config: {
                    altFormat: 'Y-m-d',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    mode: 'range',
                    locale: { rangeSeparator: ' - ' },
                },
                searchQuery,
                dateRange,
            }
        },
        async mounted() {
            let canvas = document.getElementById('chart');
            let chart = Chart.getChart('chart')

            if (chart && typeof chart.destroy === 'function') {
                chart.destory();
            }

            chart = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: this.stats.map((item) => { return item.grade }),
                    datasets: [
                        {
                            label: "On Sight",
                            data: this.stats.map((item) => { return parseInt(item.on_sight) }),
                            backgroundColor: 'rgba(0,161,154, 0.3)',
                            borderColor: 'rgba(0,161,154, 1)',
                        },
                        {
                            label: "Flash",
                            data: this.stats.map((item) => { return parseInt(item.flash) }),
                            backgroundColor: 'rgba(248,178,49, 0.3)',
                            borderColor: 'rgba(248,178,49, 1)',
                        },
                        {
                            label: "Red Point",
                            data: this.stats.map((item) => { return parseInt(item.red_point) }),
                            backgroundColor: 'rgba(213,28,84, 0.3)',
                            borderColor: 'rgba(213,28,84, 1)',
                        }
                    ],
                },
                options: {
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                callback: function(value) {
                                    if (value % 1 === 0) {
                                        return value;
                                    }
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    borderWidth: 1,
                },
            });
        },
        methods: {
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
             * Sort table column
             *
             * @param {String} prop
             * @return {Void}
             */
            _sort(prop) {
                this.asc = !this.asc;
                this.sortBy = prop;
                const asc = this.asc;

                this.$store.commit('SORT_CARDS', { id: this.$route.params.id, prop, asc });
            },
        },
    };
</script>

<style lang="scss">
</style>