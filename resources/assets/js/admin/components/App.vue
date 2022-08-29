<template>
    <div id="climbing-card">
        <section class="border-bottom-gray-100">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <Navigation />
                    </div>
                </div>
            </div>
        </section>
        <Suspense>
            <router-view />
        </Suspense>
    </div>
</template>

<script>
    import Navigation from './partials/Navigation.vue';
    
    export default {
        name: 'App',
        components: { Navigation },
    };
</script>

<style scoped></style>
