<template>
    <div id="climbing-card">
        <Navigation />
        <router-view />
    </div>
</template>

<script>
    import Navigation from './partials/Navigation.vue';

    export default {
        name: 'App',
        components: { Navigation },
    };
</script>
