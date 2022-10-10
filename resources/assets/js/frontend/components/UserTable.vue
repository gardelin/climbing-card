<template>
    <div class="table-header">
        <div class="search-container">
            <Search :size="18" />
            <input class="search" type="text" :placeholder="$gettext('Search Cards')" v-model="searchQuery" />
        </div>
        <div class="date-container">
            <div class="input-group">
                <flat-pickr v-model="dateRange" :config="config" :placeholder="$gettext('Select Dates')"> </flat-pickr>
                <X :size="18" v-if="dateRange" @click="dateRange = null" />
            </div>
        </div>
    </div>
    <table class="cards" id="cards-table">
        <thead>
            <tr>
                <th class="route" @click="_sort('route')">
                    {{ $gettext('Route') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'route' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'route' && this.asc" />
                </th>
                <th class="crag" @click="_sort('crag')">
                    {{ $gettext('Crag') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'crag' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'crag' && this.asc" />
                </th>
                <th class="style" @click="_sort('style')">
                    {{ $gettext('Style') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'style' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'style' && this.asc" />
                </th>
                <th class="grade" @click="_sort('grade')">
                    {{ $gettext('Grade') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'grade' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'grade' && this.asc" />
                </th>
                <th class="comment">{{ $gettext('Comment') }}</th>
                <th class="climbed_at" @click="_sort('climbed_at')">
                    {{ $gettext('Date') }}
                    <ChevronUp :size="15" v-if="this.sortBy === 'climbed_at' && !this.asc" />
                    <ChevronDown :size="15" v-if="this.sortBy === 'climbed_at' && this.asc" />
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="item" v-for="card in filteredCards">
                <td class="route" :data-name="$gettext('Route')">{{ card.route }}</td>
                <td class="crag" :data-name="$gettext('Crag')">{{ card.crag }}</td>
                <td class="style" :data-name="$gettext('Style')">
                    <span class="dot" :class="card.style.replace(' ', '-')"></span>
                </td>
                <td class="grade" :data-name="$gettext('Grade')">{{ card.grade }}</td>
                <td class="comment" :data-name="$gettext('Comment')">{{ card.comment }}</td>
                <td class="date" :data-name="$gettext('Date')">{{ datetimeToHuman(card.climbed_at) }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import { useRoute } from 'vue-router';
    import flatPickr from 'vue-flatpickr-component';
    import { ChevronDown, ChevronUp, Search, X } from 'lucide-vue-next';
    import { datetimeToHuman } from '../../utils/Utils';

    const store = useStore();
    const route = useRoute();
    const id = route.params.id;
    const user = ref([]);
    const cards = ref([]);
    const asc = ref(false);
    const sortBy = ref(null);
    const searchQuery = ref('');
    const dateRange = ref('');
    const config = {
        altFormat: 'd/m/Y',
        altInput: true,
        dateFormat: 'd/m/Y',
        mode: 'range',
        locale: { rangeSeparator: ' - ' },
    };

    if (store.getters.cards(id) === null) {
        await store.dispatch('getUserCards', id);
    }

    cards.value = store.getters.cards(id);
    user.value = store.getters.user(id);

    const filteredCards = computed(() => store.getters.filterCards({ id, searchQuery, dateRange }));

    const _sort = prop => {
        sortBy.value = prop;
        asc.value = !asc.value;
        store.commit('SORT_CARDS', { id: route.params.id, prop, asc: asc.value });
    };
</script>
