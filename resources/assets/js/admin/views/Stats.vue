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
                                <Statistics />
                            </template>
                            <template #fallback> 
                                <StatisticsSkeleton />
                            </template>
                        </Suspense>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import Header from '../components/partials/Header';
    import Statistics from '../components/statistics/Statistics';
    import StatisticsSkeleton from '../components/loading/StatisticsSkeleton';
    import { computed } from 'vue';
    import { useStore } from 'vuex';

    export default {
        name: 'Stats',
        components: { 
            Header,
            Statistics,
            StatisticsSkeleton,
        },
        setup() {
            const store = useStore();

            return {
                stats: computed(() => store.state.stats),
            };
        },
    };
</script>
