<template>
    <section class="header-section border-bottom-gray-100">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header :title="$gettext('Climbing Cards')" :description="$gettext('Manage your climbed routes.')" />
                    <div style="display: flex">
                        <div class="btn" v-if="this.$store.getters.cards.length" @click.prevent="store.dispatch('exportToCsv')">
                            <Download :size="16" />
                            {{ $gettext('Export CSV') }}
                        </div>
                        <div class="btn" @click.prevent="store.dispatch('appendCard', newCardTemplate())">
                            <Plus :size="16" />
                            {{ $gettext('Add') }}
                        </div>
                    </div>
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
                            <CardsTable />
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
    import { useStore } from 'vuex';
    import CardsTable from '../components/CardsTable';
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
    import Header from '../components/partials/Header';
    import { Plus, Download } from 'lucide-vue-next';

    const store = useStore();

    const newCardTemplate = () => {
        return {
            id: '',
            route: '',
            crag: '',
            grade: '',
            comment: '',
            style: 'red point',
            climbed_at: new Date().toISOString().substring(0, 10),
            editmode: true,
            errors: {
                route: null,
                crag: null,
                grade: null,
                climbed_at: null,
            },
            appendingNew: true,
        };
    };
</script>
