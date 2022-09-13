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
                                <PulseLoader />
                            </template>
                        </Suspense>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { computed } from 'vue';
    import { useStore } from 'vuex';
    import Header from '../components/partials/Header';
    import Statistics from '../components/statistics/Statistics';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

    export default {
        name: 'StatisticsPage',
        components: {
            Header,
            Statistics,
            PulseLoader,
        },
        setup() {
            const store = useStore();

            return {
                stats: computed(() => store.state.stats),
            };
        },
    };
</script>
