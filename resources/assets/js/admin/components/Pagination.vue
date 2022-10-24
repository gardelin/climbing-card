<template>
    <div class="pagination-wrapper">
        <div class="pagination-per-page">
            <p style="margin: 0">
                Per page:
                <select class="select" @change="handlePerPageClick">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </p>
        </div>
        <div class="pagination">
            <div class="btn btn-sm" v-if="!isFirstPage" @click="handleFirstPageClick">First</div>
            <div class="btn btn-sm" v-if="hasPrevPage" @click="handlePrevPageClick">Prev</div>
            <p style="margin: 0">Page <input class="input" type="number" :value="props.currentPage" @change="handlePageNumberChange" min="1" :max="pages()" style="width: 64px" /> of {{ pages() }}</p>
            <div class="btn btn-sm" v-if="hasNextPage" @click="handleNextPageClick">Next</div>
            <div class="btn btn-sm" v-if="!isLastPage" @click="handleLastPageClick">Last</div>
        </div>
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();
    const props = defineProps({
        currentPage: {
            type: Number,
            required: true,
            default: 1,
        },
        total: {
            type: Number,
            required: true,
            default: 100,
        },
        perPage: {
            type: Number,
            required: true,
            default: 10,
        },
        storeNamespace: {
            type: String,
            required: true,
        },
        search: {
            type: String,
            required: false,
            default: '',
        },
        startDate: {
            type: String,
            required: false,
            default: '',
        },
        endDate: {
            type: String,
            required: false,
            default: '',
        },
    });

    const handlePageNumberChange = e => {
        store.dispatch(`${props.storeNamespace}/getCards`, {
            pg: e.target.value,
            per_pg: props.perPage,
            search: props.search,
            end_date: props.endDate,
            start_date: props.startDate,
        });
    };

    const handleNextPageClick = e => {
        store.dispatch(`${props.storeNamespace}/getCards`, {
            pg: props.currentPage + 1,
            per_pg: props.perPage,
            search: props.search,
            end_date: props.endDate,
            start_date: props.startDate,
        });
    };

    const handlePrevPageClick = e => {
        store.dispatch(`${props.storeNamespace}/getCards`, {
            pg: props.currentPage - 1,
            per_pg: props.perPage,
            search: props.search,
            end_date: props.endDate,
            start_date: props.startDate,
        });
    };

    const handleFirstPageClick = e => {
        store.dispatch(`${props.storeNamespace}/getCards`, {
            pg: 1,
            per_pg: props.perPage,
            search: props.search,
            end_date: props.endDate,
            start_date: props.startDate,
        });
    };

    const handleLastPageClick = e => {
        store.dispatch(`${props.storeNamespace}/getCards`, {
            pg: pages(),
            per_pg: props.perPage,
            search: props.search,
            end_date: props.endDate,
            start_date: props.startDate,
        });
    };

    const handlePerPageClick = e => {
        store.dispatch(`${props.storeNamespace}/getCards`, {
            pg: 1,
            per_pg: e.target.value,
            search: props.search,
            end_date: props.endDate,
            start_date: props.startDate,
        });
    };

    const hasNextPage = computed(() => {
        return props.currentPage < pages() ? true : false;
    });

    const hasPrevPage = computed(() => {
        return props.currentPage > 1 ? true : false;
    });

    const isFirstPage = computed(() => {
        return props.currentPage === 1 ? true : false;
    });

    const isLastPage = computed(() => {
        return props.currentPage === pages() ? true : false;
    });

    const pages = () => {
        return Math.ceil(props.total / props.perPage);
    };
</script>

<style scoped lang="scss">
    .pagination-wrapper {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .pagination {
        display: flex;
        gap: 10px;

        .btn {
            margin: 0;
        }
    }

    .pagination-per-page {
        display: flex;
        align-content: center;
    }
</style>
