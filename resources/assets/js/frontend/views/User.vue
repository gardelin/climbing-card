<template>
    <div>
        <Suspense>
            <template #default>
                <div>
                    <h1>{{ $gettext('Card') }}: {{ user.firstname }} {{ user.lastname }}</h1>
                    <UserChart />
                    <div style="margin: 40px 0 60px 0"></div>
                    <UserTable />
                </div>
            </template>
            <template #fallback>
                <PulseLoader />
            </template>
        </Suspense>
    </div>
</template>
<script setup>
    import UserChart from '../components/UserChart.vue';
    import UserTable from '../components/UserTable.vue';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
    import { useStore } from 'vuex';
    import { useRoute } from 'vue-router';

    const store = useStore();
    const route = useRoute();
    const id = route.params.id;

    if (store.getters.users.length === 0) {
        await store.dispatch('getUsers');
    }

    const user = store.getters.user(id);
</script>
