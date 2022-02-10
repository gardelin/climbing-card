<template>
    <section class="header-section border-bottom-gray-bright">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header title="Cards" description="Manage your climbing card. Edit, Delete your climbed routes." />
                    <div class="cc-btn icon-plus" @click="_addCard()">Add climbed route</div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <Cards />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Cards from '../components/cards/Cards'
import Header from '../components/partials/Header'

export default {
    name: 'Dashboard',
    components: { Cards, Header },
    methods: {
        _addCard() {
            this.$store.state.cards.unshift({
                id: '',
                route: '',
                crag: '',
                grade: '',
                comment: '',
                style: 'red point',
                climbed_at: new Date().toISOString().substring(0,10),
                editmode: true,
                errors: {}
            });
        }
    }
}
</script>
