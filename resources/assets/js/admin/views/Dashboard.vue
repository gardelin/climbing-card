<template>
    <section class="header-section border-bottom-gray-bright">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header title="Cards" description="Manage your climbing card. Edit, Delete your climbed routes." />
                    <div class="cc-btn icon-plus" @click.prevent="appendCard(newCardTemplate)">Add climbed route</div>
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
    import Cards from '../components/cards/Cards';
    import CardsSkeleton from '../components/loading/CardsSkeleton';
    import Header from '../components/partials/Header';
    import { mapActions } from 'vuex';

    export default {
        name: 'Dashboard',
        components: { Cards, CardsSkeleton, Header },
        data() {
            return {
                newCardTemplate: {
                    id: '',
                    route: '',
                    crag: '',
                    grade: '',
                    comment: '',
                    style: 'red point',
                    climbed_at: new Date().toISOString().substring(0, 10),
                    editmode: true,
                    errors: {},
                },
            };
        },
        methods: {
            ...mapActions({
                appendCard: 'appendCard',
            }),
        },
    };
</script>
