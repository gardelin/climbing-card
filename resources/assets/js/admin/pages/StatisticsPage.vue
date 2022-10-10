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

<script setup>
    import Header from '../components/partials/Header';
    import Statistics from '../components/Statistics';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
</script>
