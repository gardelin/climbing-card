<template>
    <section class="header-section border-bottom-gray-100">
        <div class="container">
            <div class="row">
                <div class="col">
                    <Header :title="$gettext('Settings')" :description="$gettext('Manage your climbing card settings')" />
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
                            <div class="wrappers">
                                <div class="wrapper">
                                    <div class="header">
                                        <p class="title">{{ $gettext('General') }}</p>
                                    </div>
                                    <div class="content">
                                        <div class="item">
                                            <div class="item-label">{{ $gettext('Make my card public') }}</div>
                                            <div class="item-content">
                                                <Toggle :offLabel="$gettext('Off')" :onLabel="$gettext('On')" />
                                                <p class="item-description">{{ $gettext('By turning this option your climbing card data will be visible to all page visitors.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template #fallback> loading... </template>
                    </Suspense>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { computed } from 'vue';
    import { useStore } from 'vuex';
    import Toggle from '../components/Toggle';
    // import CardsSkeleton from '../components/loading/CardsSkeleton';
    import Header from '../components/partials/Header';
    // import { mapActions } from 'vuex';
    // import { Plus, Download } from 'lucide-vue-next';

    export default {
        name: 'Settings',
        components: { Header, Toggle },
        setup() {
            // const store = useStore();
            // return {
            //     selected: computed(() => store.state.selected),
            // };
        },
        methods: {
            // newCardTemplate() {
            //     return {
            //         id: '',
            //         route: '',
            //         crag: '',
            //         grade: '',
            //         comment: '',
            //         style: 'red point',
            //         climbed_at: new Date().toISOString().substring(0, 10),
            //         editmode: true,
            //         errors: {
            //             route: null,
            //             crag: null,
            //             grade: null,
            //             climbed_at: null,
            //         },
            //     };
            // },
            // ...mapActions({
            //     appendCard: 'appendCard',
            //     exportToCsv: 'exportToCsv',
            // }),
        },
    };
</script>
