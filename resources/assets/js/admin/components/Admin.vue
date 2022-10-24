<template>
    <div class="table-header" style="padding: 2rem 1rem">
        <div>
            <div style="display: flex; gap: 10px">
                <h3>All climbed routes</h3>
                <span class="style">
                    <span class="redpoint">{{ total }} records</span>
                </span>
            </div>
        </div>
    </div>
    <div class="table-header">
        <div class="search-container">
            <Search :size="18" />
            <input class="search" type="text" :placeholder="$gettext('Search Cards')" v-model="searchQuery" @change="onChange" />
        </div>
        <div class="date-container">
            <div class="input-group">
                <flat-pickr v-model="dateRange" :config="flatPickrRangeConfig" :placeholder="$gettext('Select Dates')" @change="onChange" />
                <X :size="18" v-if="dateRange" @click="dateRange = null" />
            </div>
        </div>
    </div>
    <CardsTable :cards="cards" :store-namespace="'admin'" :classes="['table-with-header', 'table-with-footer']" />
    <div class="table-footer">
        <Pagination :store-namespace="'admin'" :current-page="currentPage" :total="total" :per-page="perPage" :search="searchQuery" :startDate="startDate" :endDate="endDate" />
    </div>
</template>

<script setup>
    import { useStore } from 'vuex';
    import { computed, ref } from 'vue';
    import CardsTable from '../components/CardsTable.vue';
    import flatPickr from 'vue-flatpickr-component';
    import { Search, X } from 'lucide-vue-next';
    import Pagination from './Pagination.vue';
    import { getStartAndEndFromDateRange } from '../../utils/Utils';

    const store = useStore();
    const dateRange = ref('');
    const startDate = computed(() => getStartAndEndFromDateRange(dateRange.value).start);
    const endDate = computed(() => getStartAndEndFromDateRange(dateRange.value).end);
    const searchQuery = ref('');
    const flatPickrRangeConfig = {
        altFormat: 'd/m/Y',
        altInput: true,
        mode: 'range',
        locale: { rangeSeparator: ' - ' },
    };

    if (!store.getters['admin/cards'].length) {
        await store.dispatch('admin/getCards');
    }

    const cards = computed(() => store.getters['admin/cards']);
    const currentPage = computed(() => store.getters['admin/currentPage']);
    const total = computed(() => store.getters['admin/total']);
    const perPage = computed(() => store.getters['admin/perPage']);

    const onChange = () => {
        const dates = getStartAndEndFromDateRange(dateRange.value);
        store.dispatch('admin/getCards', { search: searchQuery.value, start_date: dates.start, end_date: dates.end });
    };
</script>
