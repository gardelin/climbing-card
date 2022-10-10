<template>
    <section class="header-section border-bottom-gray-100">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header :title="$gettext('Settings')" :description="$gettext('Manage your climbing card settings')" />
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
                            <Settings />
                        </template>
                        <template #fallback>
                            <PulseLoader />
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
    import Settings from '../components/Settings.vue';
    import Header from '../components/partials/Header';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
</script>
