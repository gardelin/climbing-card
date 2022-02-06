<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <Header title="Cards" description="Manage your climbing card. Edit, Delete your climbed routes." />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <Cards />
            </div>
        </div>
    </div>
</template>

<script>
import Cards from '../components/cards/Cards'
import Header from '../components/partials/Header'

export default {
    name: 'Dashboard',
    components: { Cards, Header },
}
</script>
