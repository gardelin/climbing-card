
<template>
    <div id="climbing-card">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Navigation /> 
                </div>
            </div>
        </div>
        <router-view />
    </div>
</template>

<script>
import Navigation from './partials/Navigation.vue'
export default {
    name: 'App',
    components: { Navigation },
}
</script>

<style scoped>
</style>