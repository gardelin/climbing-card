<template>
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
                        <template #default> loaded </template>
                        <template #fallback> loading ... </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import Header from '../components/partials/Header';
    import { mapActions } from 'vuex';

    export default {
        name: 'Statistics',
        components: { Header },
        setup() {
            const store = useStore();

            return {
                cards: computed(() => store.state.cards),
            };
        },
        methods: {},
    };
</script>
