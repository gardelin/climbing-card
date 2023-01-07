<template>
    <h2>{{ $gettext('Climbed style per grade') }}</h2>
    <canvas id="chart"></canvas>
</template>

<script setup>
    import { onMounted, computed } from 'vue';
    import { useStore } from 'vuex';
    import Chart from 'chart.js/auto';

    const store = useStore();
    const stats = computed(() => store.getters.stats);

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
                barThickness: 50,
            },
        });
    });
</script>
