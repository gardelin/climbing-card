<template>
    <div>
        <GradesLinearChart />
        <GradesPieChart />

        <h2>{{ $gettext('Total routes per grade') }}</h2>
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
                    <td :data-name="$gettext('Grade')">
                        <strong>{{ stat.grade }}</strong>
                    </td>
                    <td :data-name="$gettext('Total')">{{ stat.total }}</td>
                    <td :data-name="$gettext('On Sight')">{{ stat.on_sight }}</td>
                    <td :data-name="$gettext('Flash')">{{ stat.flash }}</td>
                    <td :data-name="$gettext('Red Point')">{{ stat.red_point }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { useStore } from 'vuex';
    import GradesLinearChart from './GradesLinearChart.vue';
    import GradesPieChart from './GradesPieChart.vue';

    const store = useStore();

    if (!store.getters.stats.length) {
        await store.dispatch('getStatistics');
    }

    const stats = computed(() => store.getters.stats);
</script>
