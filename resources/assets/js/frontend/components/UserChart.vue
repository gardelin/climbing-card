<template>
    <h3>{{ $gettext('Number of climbed routes per grade') }}</h3>
    <canvas id="chart"></canvas>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useStore } from 'vuex';
    import { useRoute } from 'vue-router';
    import Chart from 'chart.js/auto';

    const store = useStore();
    const stats = ref([]);
    const route = useRoute();
    const id = route.params.id;

    if (store.getters.stats(id) === null) {
        await store.dispatch('getUserStats', id);
    }

    stats.value = store.getters.stats(id);

    onMounted(() => {
        let canvas = document.getElementById('chart');
        let chart = Chart.getChart('chart');

        if (chart && typeof chart.destroy === 'function') {
            chart.destory();
        }

        chart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: stats.value.map(item => {
                    return item.grade;
                }),
                datasets: [
                    {
                        label: 'On Sight',
                        data: stats.value.map(item => {
                            return parseInt(item.on_sight);
                        }),
                        backgroundColor: 'rgba(0,161,154, 0.3)',
                        borderColor: 'rgba(0,161,154, 1)',
                    },
                    {
                        label: 'Flash',
                        data: stats.value.map(item => {
                            return parseInt(item.flash);
                        }),
                        backgroundColor: 'rgba(248,178,49, 0.3)',
                        borderColor: 'rgba(248,178,49, 1)',
                    },
                    {
                        label: 'Red Point',
                        data: stats.value.map(item => {
                            return parseInt(item.red_point);
                        }),
                        backgroundColor: 'rgba(213,28,84, 0.3)',
                        borderColor: 'rgba(213,28,84, 1)',
                    },
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
                            callback: function (value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            },
                        },
                    },
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
                borderWidth: 1,
            },
        });
    });
</script>

<style lang="scss">
    canvas {
        max-height: 600px !important;
    }
</style>
