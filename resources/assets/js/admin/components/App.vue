<template>
    <div id="climbing-card">
        <Suspense>
            <template #default>
                <div>
                    <Navigation />
                    <router-view />
                </div>
            </template>
            <template #fallback>
                <PulseLoader />
            </template>
        </Suspense>
    </div>
</template>

<script setup>
    import Navigation from './partials/Navigation.vue';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
</script>
