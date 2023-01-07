<template>
    <h2>{{ $gettext('Number of routes per grade') }}</h2>
    <canvas id="radar-chart"></canvas>
</template>

<script setup>
    import { onMounted, computed } from 'vue';
    import { useStore } from 'vuex';
    import Chart from 'chart.js/auto';
    import { randomRgba } from '../../utils/Utils';

    const store = useStore();
    const stats = computed(() => store.getters.stats);

    onMounted(() => {
        let canvas = document.getElementById('radar-chart');
        let chart = Chart.getChart('radar-chart');

        if (chart && typeof chart.destroy === 'function') {
            chart.destory();
        }

        chart = new Chart(canvas, {
            type: 'pie',
            data: {
                labels: stats.value.map(item => {
                    return item.grade;
                }),
                datasets: [
                    {
                        data: stats.value.map(item => {
                            return item.total;
                        }),
                        backgroundColor: stats.value.map(() => {
                            return randomRgba();
                        }),
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

<style scoped>
    canvas {
        max-height: 800px;
    }
</style>
