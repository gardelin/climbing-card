<template>
    <section class="header-section border-bottom-gray-100">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header :title="$gettext('Climbing Cards')" :description="$gettext('Manage your climbed routes.')" />
                    <div style="display: flex">
                        <div class="btn" v-if="cards.length" @click.prevent="exportToCsv()">
                            <Download :size="16" />
                            {{ $gettext('Export CSV') }}
                        </div>
                        <div class="btn" @click.prevent="appendCard(newCardTemplate())">
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
                            <Cards />
                        </template>
                        <template #fallback>
                            <CardsSkeleton />
                        </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { computed } from 'vue';
    import { useStore, mapActions } from 'vuex';
    import Cards from '../components/cards/Cards';
    import CardsSkeleton from '../components/loading/CardsSkeleton';
    import Header from '../components/partials/Header';
    import { Plus, Download } from 'lucide-vue-next';

    export default {
        name: 'ClimbingCards',
        components: { Cards, CardsSkeleton, Header, Plus, Download },
        setup() {
            const store = useStore();

            return {
                cards: computed(() => store.state.cards),
            };
        },
        methods: {
            newCardTemplate() {
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
                };
            },
            ...mapActions({
                appendCard: 'appendCard',
                exportToCsv: 'exportToCsv',
            }),
        },
    };
</script>
