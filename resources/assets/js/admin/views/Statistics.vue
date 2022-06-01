<template>
    <div>
        <section class="header-section border-bottom-gray-100">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <Header :title="$gettext('Statistics')" :description="$gettext('Check your climbing statistics')" />
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <Suspense>
                            <template #default>
                                <div>
                                    <table class="cards">
                                        <thead>
                                            <tr>
                                                <th>{{ $gettext('Grade') }}</th>
                                                <th>{{ $gettext('Total') }}</th>
                                                <th>{{ $gettext('On Sight') }}</th>
                                                <th>{{ $gettext('Flash') }}</th>
                                                <th>{{ $gettext('Red Point') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="item" v-for="stat in stats">
                                                <td data-name="{{ $gettext('Grade') }}"><strong>{{ stat.grade }}</strong></td>
                                                <td data-name="{{ $gettext('Total') }}">{{ stat.total }}</td>
                                                <td data-name="{{ $gettext('On Sight') }}">{{ stat.on_sight }}</td>
                                                <td data-name="{{ $gettext('Flash') }}">{{ stat.flash }}</td>
                                                <td data-name="{{ $gettext('Red Point') }}">{{ stat.red_point }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <canvas id="chart"></canvas>
                                </div>
                            </template>
                            <template #fallback> loading ... </template>
                        </Suspense>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { ref, computed, onMounted } from 'vue';
    import { useStore } from 'vuex';
    import Header from '../components/partials/Header';
    import Chart from 'chart.js/auto';

    export default {
        name: 'Statistics',
        components: { 
            Header,
        },
        setup() {
            const stats = ref([]);
            const store = useStore();

            onMounted(async() => {
                const response = await fetch(`${window.climbingcards.rest_url}stats/${window.climbingcards.logged_user_id}`);
                const json = await response.json();
                let stats = json.data.stats;

                store.commit('setStats', (store.state.stats = stats));

                let canvas = document.getElementById('chart').getContext('2d');

                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: stats.map((item) => { return item.grade }),
                        datasets: [
                            {
                                label: "On Sight",
                                data: stats.map((item) => { return parseInt(item.on_sight) }),
                                backgroundColor: '#00a19a',
                            },
                            {
                                label: "Flash",
                                data: stats.map((item) => { return parseInt(item.flash) }),
                                backgroundColor: '#f8b231',
                            },
                            {
                                label: "Red Point",
                                data: stats.map((item) => { return parseInt(item.red_point) }),
                                backgroundColor: '#d51c54',
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
                        barThickness: 50,
                    },
                });
            });

            return {
                stats: computed(() => store.state.stats),
            };
        },
        methods: {},
    };
</script>
